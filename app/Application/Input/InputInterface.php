<?php

namespace App\Application\Input;

/**
 *
 */
interface InputInterface {

    /**
     * @param string $filepath
     */
    public function __construct(array $options);

    /**
     * @return void
     */
    public function open(): void;

    /**
     * @param int|null $length
     * @return string
     */
    public function read(?int $length = null): string|false;

    /**
     * @return void
     */
    public function close(): void;
}