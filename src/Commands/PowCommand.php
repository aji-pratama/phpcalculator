<?php 

namespace Jakmall\Recruitment\Calculator\Commands;

use Jakmall\Recruitment\Calculator\Commands\AddCommand;

class PowCommand extends AddCommand
{
    protected function getCommandVerb(): string
    {
        return 'pow';
    }

    protected function getCommandPassiveVerb(): string
    {
        return 'powed';
    }

    protected function getOperator(): string
    {
        return '^';
    }

    /**
     * @param int|float $number1
     * @param int|float $number2
     *
     * @return int|float
     */
    protected function calculate($number1, $number2)
    {
        return $number1 ** $number2;
    }
}
