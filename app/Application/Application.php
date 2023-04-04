<?php

namespace App\Application;

use App\Config\Config;
use App\Application\Output\OutputInterface;

/**
 *
 */
class Application {

    /**
     * @todo move out logic with instance to a separate singleton class
     * @var self |null
     */
    private static ?self $instance = null;

    /**
     * @param Application $instance
     * @return void
     */
    public static function set(self $instance): void {
        static::$instance = $instance;
    }

    /**
     * @return static
     * @throws \Exception
     */
    public static function get(): self {
        if (!static::$instance) {
            throw new \Exception('Application instance does not set.');
        }
        return static::$instance;
    }

    /**
     * @param Config $config
     * @param OutputInterface $log
     */
    public function __construct(
        protected Config $config,
        protected OutputInterface $log
    ) {
        static::set($this);
    }

    /**
     * @return void
     */
    public function start(): void {
        $this->log->open();
    }

    /**
     * @return Config
     */
    public function config(): Config {
        return $this->config;
    }


    /**
     * @return OutputInterface
     */
    public function log(): OutputInterface {
        return $this->log;
    }

    /**
     * @return void
     */
    public function finish(): void {
        $this->log->close();
    }

}