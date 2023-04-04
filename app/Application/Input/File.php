<?php


namespace App\Application\Input;

use App\Application\Exception\InputException;

/**
 * @todo unify code with FileInterface
 */
class File implements InputInterface
{
    /**
     * @var string|mixed
     */
    protected string $filepath;


    /**
     * @var mixed
     */
    protected mixed $fileHandle;


    /**
     * @param array $options
     * @throws InputException
     */
    public function __construct(array $options) {
        if ( !array_key_exists( 'filepath', $options ) ) {
            throw new InputException( 'Wrong file input interface options: "filepath" key expected.' );
        }
        $this->filepath = $options[ 'filepath' ];
    }


    /**
     * @return void
     * @throws InputException
     */
    public function open(): void {
        if (!file_exists($this->filepath) ) {
            throw new InputException('File does not found: ' . $this->filepath);
        }

        $this->fileHandle = fopen($this->filepath, 'r');
        if (!$this->fileHandle) {
            throw new InputException( 'Can\'t open file for reading: ' . $this->filepath);
        }
    }

    /**
     * @param int|null $length
     * @return string
     */
    public function read(?int $length = null): string|false {
        return fgets($this->fileHandle, $length);
    }

    /**
     * @return void
     */
    public function close(): void {
        fclose($this->fileHandle);
    }

}