<?php 

namespace Jakmall\Recruitment\Calculator\Commands;

use Jakmall\Recruitment\Calculator\Commands\AddCommand;

class DivideCommand extends AddCommand
{
    protected function getCommandVerb(): string
    {
        return 'divide';
    }

    protected function getCommandPassiveVerb(): string
    {
        return 'dividied';
    }

    protected function getOperator(): string
    {
        return '/';
    }

    /**
     * @param int|float $number1
     * @param int|float $number2
     *
     * @return int|float
     */
    protected function calculate($number1, $number2)
    {
        return $number1 / $number2;
    }
}
