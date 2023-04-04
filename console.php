#!/usr/bin/env php
<?php

use App\Console\Option\OptionExtractor;
use App\Console\Option\OptionValue;
use App\Application\HandlerProcess\HandlerProcess;
use App\Application\Input;
use App\Application\Output;
use App\Application\Format\Format;
use App\Application\Exception\InputException;


$app = require __DIR__.'/app/app.php';

try {

    $app->start();

    // Create option extractor
    $optionExtractor = new OptionExtractor();

    // Create option values
    $actionOption = new OptionValue( $optionExtractor,'a:', 'action:' );
    $fileOption = new OptionValue( $optionExtractor,'f:', 'file:' );

    // Get final option values
    $actionName = $actionOption->getValue();
    $fileInput = $fileOption->getValue();

    if ($actionName === null || $fileInput === null) {
        throw new InputException("Wrong input parameters.");
    }

    // --- Try to initialize handler depended on input option
    $handlerClass = $app->config()->get( 'operation.handlers.' . $actionName );
    if (!$handlerClass) {
        throw new InputException('Unknown action: ' . $actionName);
    }
    $handler = new $handlerClass();
    // ---

    // --- Input & output interfaces
    $input = new Input\File([ 'filepath' => $fileInput ]);
    $output = new Output\File([ 'filepath' => $app->config()->get('resultOutput.file') ]);
    $output->addFormat( new Format($app->config()->get('resultOutput.format') ) );
    // ---

    // Create & execute a handler process
    $handlerProcess = new HandlerProcess($app, $handler, $input, $output);

    // Add starting log
    $app->log()->write( str_replace(
        '{operation}', $actionName, $app->config()->get('operation.logTemplates.start')
    ) );

    // Execute a handler process
    // @todo move separator to external option & pass it here
    $handlerProcess->execute();

    // Add ending log
    $app->log()->write( str_replace(
        '{operation}', $actionName, $app->config()->get('operation.logTemplates.end')
    ) );

    $app->finish();

} catch (\Exception|InputException $e) {
    die($e->getMessage() );
}
