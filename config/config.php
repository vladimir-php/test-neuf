<?php

use App\Application\Output\File;
use App\Application\Output\Console;

use App\Application\Handler\AdditionHandler;
use App\Application\Handler\DivisionHandler;
use App\Application\Handler\MultiplicationHandler;
use App\Application\Handler\SubtractionHandler;

return [

    // @todo switch default log key to storing it in .env
    'defaultLog' => 'file',
    'logs' => [
        'file' => [
            'driver' => File::class,
            'options' => [
                'filepath' => 'log.txt',
                'formats' => [ "{message}\r\n", ],
            ],
        ],
        'console' => [
            'driver' => Console::class,
            'options' => [],
        ],
    ],

    'operation'=> [
        'handlers' => [
            'plus' => AdditionHandler::class,
            'minus' => SubtractionHandler::class,
            'multiply' => MultiplicationHandler::class,
            'division' => DivisionHandler::class,
        ],
        'logTemplates' => [
            'start' => 'Start {operation} operation',
            'end' => 'Finish {operation} operation ',
        ],
        'rules' => [
            'errorTemplates' => [
                'negativeResult' => 'numbers {val1} and {val2} are wrong',
                'divisionByZero' => 'numbers {val1} and {val2} are wrong, is not allowed',
                'valueLimits'   => 'numbers {val1} and {val2} are wrong, values must be from -100 to 100'
            ],
        ],
    ],

    'resultOutput' => [
        'file' => 'result.csv',
        'format' => "{message}\r\n",
    ],

];