<?php

namespace App\Application\Handler;


use App\Application\Application;
use App\Application\Handler\Rule\RuleDivisionByZero;

/**
 *
 */
class DivisionHandler extends Handler {

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();

        // Add rule to check a division by zero
        $this->rules[] = new RuleDivisionByZero(
            Application::get()->config()->get('operation.rules.errorTemplates.divisionByZero')
        );
    }


    /**
     * @param int $val1
     * @param int $val2
     * @return int|float
     */
    public function execute(int $val1, int $val2): int|float {
        return $val1 / $val2;
    }

}