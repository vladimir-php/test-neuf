<?php


namespace App\Config;

/**
 *
 */
class Config {

    /**
     * @param array $config
     */
    public function __construct(
        protected array $config
    ) {

    }

    /**
     * @param string $dottedKey
     * @return mixed
     */
    public function get(string $dottedKey): mixed {

        // Supporting dotted keys
        $keys = explode('.', $dottedKey);

        // Try to find value through all config cascade
        $config = $this->config;
        foreach($keys as $key) {
            if (!array_key_exists($key, $config) ) {
                return null;
            }
            $config = $config[$key];
        }
        return $config;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function set(string $key, mixed $value): void {
        $this->config[$key] = $value;
    }

}