<?php

namespace App\Application\Handler\Rule;

/**
 *
 */
class RuleNotNegativeResult extends Rule {

    /**
     * @param int|float $result
     * @return bool
     */
    public function checkResult(int|float $result): bool {
        return !($result < 0);
    }


}