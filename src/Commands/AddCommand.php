<?php

namespace Jakmall\Recruitment\Calculator\Commands;

use Illuminate\Console\Command;

class AddCommand extends Command
{
    /**
     * @var string
     */
    protected $signature;

    /**
     * @var string
     */
    protected $description;

    public function __construct()
    {
        $commandVerb = $this->getCommandVerb();

        $this->signature = sprintf(
            '%s {numbers* : The numbers to be %s}',
            $commandVerb,
            $this->getCommandPassiveVerb()
        );
        $this->description = sprintf('%s all given Numbers', ucfirst($commandVerb));
        parent::__construct();
    }

    protected function getCommandVerb(): string
    {
        return 'add';
    }

    protected function getCommandPassiveVerb(): string
    {
        return 'added';
    }

    public function handle(): void
    {
        $numbers = $this->getInput();
        $description = $this->generateCalculationDescription($numbers);
        $result = $this->calculateAll($numbers);

        $this->comment(sprintf('%s = %s', $description, $result));
        $this->recordHistory(ucwords($this->getCommandVerb()), $description, $result, sprintf('%s = %s', $description, $result));
    }

    protected function getInput(): array
    {
        return $this->argument('numbers');
    }

    protected function generateCalculationDescription(array $numbers): string
    {
        $operator = $this->getOperator();
        $glue = sprintf(' %s ', $operator);

        return implode($glue, $numbers);
    }

    protected function getOperator(): string
    {
        return '+';
    }

    /**
     * @param array $numbers
     *
     * @return float|int
     */
    protected function calculateAll(array $numbers)
    {
        $number = array_pop($numbers);

        if (count($numbers) <= 0) {
            return $number;
        }

        return $this->calculate($this->calculateAll($numbers), $number);
    }

    /**
     * @param int|float $number1
     * @param int|float $number2
     *
     * @return int|float
     */
    protected function calculate($number1, $number2)
    {
        return $number1 + $number2;
    }

    /**
     * @param string $command
     * @param string $description
     * @param string $result
     * @param string $output
     */
    protected function recordHistory($command, $description, $result, $output)
    {
        $array = array(
            'Command' => $command,
            'Description' => $description,
            'Result' => $result,
            'Output' => $output,
            'Time' => date('m-d-Y H:i:s'),
        );
        $file = './data.json';

        if (!file_exists($file)) {
            file_put_contents($file, null);
        }

        $fileData = json_decode(file_get_contents($file), true);
        $fileData[] = json_decode(json_encode($array));
        $dataAsJson = json_encode($fileData);
        file_put_contents($file, $dataAsJson);
    }
}
