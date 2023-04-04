<?php

namespace App\Application\Format;


/**
 *
 */
class Format implements FormatInterface {

    /**
     * @param string $template
     * @param string $keyword
     */
    public function __construct(
        protected string $template,
        protected string $keyword = '{message}'
    ) {

    }

    /**
     * @param string $message
     * @return string
     */
    public function format(string $message): string {
        return str_replace($this->keyword, $message, $this->template);
    }

}