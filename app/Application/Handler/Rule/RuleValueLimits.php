<?php

namespace App\Application\Handler\Rule;

/**
 *
 */
class RuleValueLimits extends Rule {

    /**
     * @param int $val1
     * @param int $val2
     * @return bool
     */
    public function checkParameters(int $val1, int $val2): bool {
        return ($val1 >= -100 && $val1 <= 100) && ($val2 >= -100 && $val2 <= 100);
    }

}