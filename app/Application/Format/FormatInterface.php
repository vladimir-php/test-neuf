<?php

namespace App\Application\Format;

interface FormatInterface {

    /**
     * @param string $message
     * @return string
     */
    public function format(string $message): string;

}