<?php

namespace App\Application\Handler\Rule;

use App\Application\Application;

/**
 *
 */
abstract class Rule {

    /**
     * @param string $errorTemplate
     */
    public function __construct(
        protected string $errorTemplate
    ) {

    }

    /**
     * @param int $val1
     * @param int $val2
     * @return bool
     */
    public function checkParameters(int $val1, int $val2): bool {
        return true;
    }

    /**
     * @param int|float $result
     * @return bool
     */
    public function checkResult(int|float $result): bool {
        return true;
    }

    /**
     * @param int $val1
     * @param int $val2
     * @return string
     */
    public function getErrorMessage(int $val1, int $val2): string {
        return str_replace( ['{val1}', '{val2}'], [$val1, $val2], $this->errorTemplate );
    }

}