<?php

namespace Jakmall\Recruitment\Calculator\Commands;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\OutputInterface;
use Illuminate\Console\Command;

class HistoryListCommand extends Command
{
    public function configure()
    {
        $this->setName('history:list')
            ->setDescription('Show calculator history')
            ->addArgument('argumens', InputArgument::IS_ARRAY, 'Argumen to filter');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        if (file_exists('data.json') and filesize('data.json') > 0) {
            $histories = $this->tableHistory($input, $output);
        } else {
            $histories = [];
        }

        if (sizeof($histories) < 1) {
            $output->writeln('<fg=green>History is empty!</>');
        } else {
            $table = new Table($output);
            $table
                ->setHeaders(['No', 'Command', 'Description', 'Result', 'Output', 'Time'])
                ->setRows($histories);
            $table->render();
        }
    }

    protected function tableHistory(InputInterface $input, OutputInterface $output)
    {
        $json = file_get_contents('data.json');
        $data = (array) json_decode($json, true);
        $commands = $input->getArgument('argumens');
        $i = 1;
        if (sizeof($commands) > 0) {
            foreach ($data as $item) {
                if (in_array(strtolower($item['Command']), $commands)) {
                    $newarray[] = array(
                        'ID' => $i++,
                        'Command' => $item['Command'],
                        'Description' => $item['Description'],
                        'Result' => $item['Result'],
                        'Output' => $item['Output'],
                        'Time' => $item['Time'],
                    );
                }
            }
        } else {
            foreach ($data as $item) {
                $newarray[] = array(
                    'ID' => $i++,
                    'Command' => $item['Command'],
                    'Description' => $item['Description'],
                    'Result' => $item['Result'],
                    'Output' => $item['Output'],
                    'Time' => $item['Time'],
                );
            }
        }

        return $newarray;
    }
}
