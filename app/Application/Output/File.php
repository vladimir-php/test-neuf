<?php


namespace App\Application\Output;

use App\Application\Exception\InputException;

/**
 * @todo unify code with FileInterface
 */
class File extends Output
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
        parent::__construct($options);

        if ( !array_key_exists( 'filepath', $options ) ) {
            throw new InputException( 'Wrong file output interface options: "filepath" key expected.' );
        }
        $this->filepath = $options[ 'filepath' ];
    }


    /**
     * @return void
     * @throws InputException
     */
    public function open(): void {
        if (file_exists($this->filepath) ) {
            unlink($this->filepath);
        }

        $this->fileHandle = fopen($this->filepath, 'w');
        if (!$this->fileHandle) {
            throw new InputException( 'Can\'t open file for writing: ' . $this->filepath);
        }
    }

    /**
     * @param string $data
     * @return void
     */
    public function writeRaw(string $data): void {
        fwrite($this->fileHandle, $data);
    }

    /**
     * @return void
     */
    public function close(): void {
        fclose($this->fileHandle);
    }

}