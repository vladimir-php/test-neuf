<?php


namespace App\Application\Output;

use App\Application\Format\Format;
use App\Application\Format\FormatInterface;

/**
 *
 */
abstract class Output implements OutputInterface {

    /**
     * @var array
     */
    protected array $formats = [];

    /**
     * @param array $options
     */
    public function __construct(array $options) {

        // Check for the format initialization
        if ( array_key_exists( 'formats', $options ) && is_array($options[ 'formats' ]) ) {
            foreach ($options[ 'formats' ] as $format) {
                $this->addFormat(new Format($format) );
            }
        }
    }

    /**
     * @param FormatInterface $format
     * @return void
     */
    public function addFormat(FormatInterface $format): void
    {
        $this->formats[] = $format;
    }


    /**
     * @param string $data
     * @return string
     */
    public function getFormattedData(string $data): string {
        foreach($this->formats as $format) {
            $data = $format->format($data);
        }
        return $data;
    }

    /**
     * @param string $data
     * @return void
     */
    public function write(string $data): void {
        $this->writeRaw($this->getFormattedData($data) );
    }


    /**
     * @param string $data
     * @return void
     */
    abstract function writeRaw(string $data): void;

}