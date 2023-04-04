<?php


namespace App\Application\HandlerProcess;


use App\Application\Application;
use App\Application\Exception\HandlerException;
use App\Application\Handler\Handler;
use App\Application\Input\InputInterface;
use App\Application\Output\OutputInterface;


class HandlerProcess {


    /**
     * @param Application $app
     * @param Handler $handler
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    public function __construct(
        protected Application $app,
        protected Handler $handler,
        protected InputInterface $input,
        protected OutputInterface $output
    ) {

    }


    /**
     * @param string $separator
     * @return void
     */
    public function execute(string $separator = ';'): void {

        $this->input->open();
        $this->output->open();

        $checkedBom = false;
        while (($line = $this->input->read()) !== false) {
            try {

                // Check & remove BOM from the first line
                $bom = pack('CCC', 0xEF, 0xBB, 0xBF);
                if (!$checkedBom && substr($line, 0, 3) === $bom) {
                    $line = substr($line, 3);
                    $checkedBom = true;
                }

                // Get & check values
                $values = explode($separator, $line);
                if (count($values) < 2 || !is_numeric($values[0]) || !is_numeric($values[1]) ) {
                    throw new HandlerException('Input parameters are wrong: ' . $line);
                }

                // @todo: supporting float? - use trim instead of intval & change all fn params to int|float
                $val1 = intval($values[0]);
                $val2 = intval($values[1]);

                // Try to get a result
                $result = $this->handler->getResult($val1, $val2);

                // Write result to output interface
                $this->output->write( implode($separator, [$val1, $val2, $result]) );
            }
            catch (HandlerException $e) {
                $this->app->log()->write($e->getMessage() );
            }
        }

        $this->output->close();
        $this->input->close();
    }

}