<?php
/**
 * Created by PhpStorm.
 * User: Adriana
 * Date: 1/7/2018
 * Time: 9:08 PM
 */

return [
    'dependencies' => [
        'invokables' => [
            \Quiz\Service\QuizServiceInterface::class => \Quiz\Service\QuizService::class
        ],
        'factories' => [
            \Quiz\Console\Command\TestCommand::class => \Quiz\Factory\QuizFactory::class,
        ]
    ]
];
