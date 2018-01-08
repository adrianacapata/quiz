<?php

use Frontend\Console\Command\HelloCommand;

return [
    'dot_console' => [
        //'name' => 'DotKernel Console',
        //'version' => '1.0.0',

        'commands' => [
            [
                'name' => 'hello',
                'description' => 'Hello, World! command example',
                'handler' => HelloCommand::class,
            ],

            [
                'name' => 'test',
                'description' => 'some description',
                'handler' => \Quiz\Console\Command\TestCommand::class,
            ],

            [
                'name' => 'import',
                'description' => 'some description',
                'handler' => \Quiz\Console\Command\ImportCommand::class,
            ]
        ]
    ]
];
