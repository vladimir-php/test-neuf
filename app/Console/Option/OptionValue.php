<?php

namespace App\Console\Option;


/**
 *
 */
class OptionValue {


    /**
     * @param OptionExtractor $extractor
     * @param string $shortName
     * @param string|null $longName
     */
    public function __construct(
        protected OptionExtractor $extractor,
        protected string $shortName,
        protected ?string $longName = null
    ) {
        $this->extractor->addOption($this);
    }


    /**
     * @return string
     */
    public function getShortName(): string {
        return $this->shortName;
    }

    /**
     * @return string|null
     */
    public function getLongName(): ?string {
        return $this->longName;
    }

    /**
     * @return string|null
     */
    public function getValue(): ?string {
        $data = $this->extractor->getData();

        foreach([$this->shortName, $this->longName] as $key) {
            if ($key === null) {
                continue;
            }

            // Convert to array key
            $key = str_replace(':', '', $key);

            // Try to get value from the full data
            if ($key && array_key_exists($key, $data) ) {
                return $data[$key];
            }
        }

        return null;
    }



}