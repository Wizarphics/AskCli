<?php

use Wizarphics\AskCli\App;
use Wizarphics\AskCli\Command\CommandRegistry;

defined('COMMANDS_PATH') or define('COMMANDS_PATH', __DIR__.'/Uses/Command');

function getRegistry($multiple=false): CommandRegistry
{

    $config = $multiple===false?['app_path' => COMMANDS_PATH]:[
            'app_path' => [
                COMMANDS_PATH,
                __DIR__ . '/Uses/VendorCommand'
            ]
    ];

    $app = new App($config);

    if (!$multiple) {
        $app->registerCommand("minicli-test", function () {
            return true;
        });
    }

    /** @var CommandRegistry $registry */
    $registry = $app->commandRegistry;

    return $registry;
}