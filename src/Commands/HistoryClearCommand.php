<?php 

namespace Jakmall\Recruitment\Calculator\Commands;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Illuminate\Console\Command;

class HistoryClearCommand extends Command
{
    
    public function configure()
    {
        $this->setName('history:clear')
            ->setDescription('Clear calculator history');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $str = file_put_contents('data.json', '');
        $output->writeln('<fg=green>History cleared!</>');
    }
}
