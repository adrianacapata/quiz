<?php
/**
 * Created by PhpStorm.
 * User: Adriana
 * Date: 1/7/2018
 * Time: 11:44 PM
 */

namespace Quiz;

use Dot\Mapper\Factory\DbMapperFactory;
use Quiz\Entity\QuizEntity;
use Quiz\Factory\QuizFactory;
use Quiz\Mapper\QuizMapper;

class ConfigProvider
{

    public function __invoke(): array
    {
        return [
            'dot_mapper' => $this->getMappers(),
        ];
    }

    public function getMappers(): array
    {
        return [
            'mapper_manager' => [
                'factories' => [
                    QuizMapper::class => DbMapperFactory::class
                ],
                'aliases' => [
                    QuizEntity::class => QuizMapper::class
                ]
            ]
        ];
    }
}