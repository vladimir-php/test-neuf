<?php

use App\Application\Application;
use App\Config\Config;
use App\Application\Exception\InputException;


// --- Try to include composer autoload file
$autoloadFile = __DIR__.'/../vendor/autoload.php';
if (!file_exists($autoloadFile) )  {
    die('ERROR: Please run composer install.');
}
require $autoloadFile;
// ---


try {

    // Config initialization
    $config = new Config(require_once __DIR__ . '/../config/config.php');

    // --- Log initialization
    $output = $config->get('logs.' . $config->get('defaultLog') );
    if (!$output) {
        throw new InputException('Unable to find a valid output config.');
    }
    $log = new $output['driver']( $output['options'] );
    // ---

    // Create an application object
    $app = new Application($config, $log);

}
catch (\Exception $e) {
    exit($e->getMessage() );
}

return $app;