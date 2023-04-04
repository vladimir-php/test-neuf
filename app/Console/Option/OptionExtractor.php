<?php

namespace App\Console\Option;


/**
 *
 */
class OptionExtractor {

    /**
     * @var array|null
     */
    protected ?array $data = null;

    /**
     * @var array
     */
    protected array $options = [];


    /**
     * @param OptionValue $option
     * @return void
     */
    public function addOption(OptionValue $option): void {

        // Reset data on each option creation (to remove cache in getData function)
        $this->data = null;

        $this->options[] = $option;
    }


    /**
     * @return array
     */
    public function getData(): array {
        if ($this->data === null) {

            // Accumulate all parameters for getopt function
            $shortOptions = ''; $longOptions = [];
            foreach($this->options as $option) {

                $shortOptions .= $option->getShortName();

                $longName = $option->getLongName();
                if ($longName) {
                    $longOptions[] = $longName;
                }
            }

            // Get final data
            $this->data = getopt($shortOptions, $longOptions);
        }
        return $this->data;
    }


}