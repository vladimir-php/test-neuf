<?php

namespace App\Application\Handler;


/**
 *
 */
class AdditionHandler extends Handler {

    /**
     * @param int $val1
     * @param int $val2
     * @return int|float
     */
    public function execute(int $val1, int $val2): int|float {
        return $val1 + $val2;
    }

}