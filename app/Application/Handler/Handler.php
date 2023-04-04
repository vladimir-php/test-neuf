<?php

namespace App\Application\Handler;

use App\Application\Application;
use App\Application\Exception\HandlerException;
use App\Application\Handler\Rule\RuleNotNegativeResult;
use App\Application\Handler\Rule\RuleValueLimits;

/**
 *
 */
abstract class Handler {

    /**
     * @var array
     */
    protected array $rules = [];

    /**
     * @throws \Exception
     */
    public function __construct() {

        // Add value limits rule
        $this->rules[] = new RuleValueLimits(
            Application::get()->config()->get('operation.rules.errorTemplates.valueLimits')
        );

        // Add default rule for negative result
        $this->rules[] = new RuleNotNegativeResult(
            Application::get()->config()->get('operation.rules.errorTemplates.negativeResult')
        );
    }

    /**
     * @param int $val1
     * @param int $val2
     * @return int|float
     * @throws HandlerException
     */
    public function getResult(int $val1, int $val2): int|float {

        // @todo unify code with duplication of $rule->getErrorMessage($val1, $val2) calls: create seprated rule exception
        // Check parameters by rules
        foreach($this->rules as $rule) {
            if (!$rule->checkParameters($val1, $val2) ) {
                throw new HandlerException($rule->getErrorMessage($val1, $val2) );
            }
        }

        // Get a result from the child class
        $result = $this->execute($val1, $val2);

        // Check result by rules
        foreach($this->rules as $rule) {
            if (!$rule->checkResult($result) ) {
                throw new HandlerException($rule->getErrorMessage($val1, $val2) );
            }
        }

        return $result;
    }


    /**
     * @param int $val1
     * @param int $val2
     * @return int
     */
    abstract function execute(int $val1, int $val2): int|float;

}