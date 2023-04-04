<?php

namespace App\Application\Output;

use App\Application\Format\FormatInterface;

/**
 *
 */
interface OutputInterface {

    /**
     * @param array $options
     */
    public function __construct(array $options);

    /**
     * @param FormatInterface $format
     * @return void
     */
    public function addFormat(FormatInterface $format): void;

    /**
     * @return void
     */
    public function open(): void;

    /**
     * @param string $data
     * @return void
     */
    public function write(string $data): void;

    /**
     * @return void
     */
    public function close(): void;
}