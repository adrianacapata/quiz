<?php
/**
 * Console application bootstrap file
 */
use ZF\Console\Application;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

/**
 * Self-called anonymous function that creates its own scope and keep the global namespace clean.
 */
call_user_func(function () {
    /** @var \Interop\Container\ContainerInterface $container */
    $container = require 'config/container.php';

    /** @var Application $app */
    $app = $container->get(Application::class);

    $exit = $app->run();
    exit($exit);
});
