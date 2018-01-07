<?php
/**
 * Created by PhpStorm.
 * User: Adriana
 * Date: 1/7/2018
 * Time: 7:12 PM
 */

namespace Quiz\Service;

use Dot\Mapper\Mapper\MapperManagerAwareInterface;
use Dot\Mapper\Mapper\MapperManagerAwareTrait;

class QuizService implements MapperManagerAwareInterface
{
    use MapperManagerAwareTrait;

    public function import(QuizEntity $quiz)
    {
        $options = [
            'fields' => '*',
        ];

        $mapper = $this->getMapperManager()->get(QuizEntity::class);
        return $mapper->save($quiz);
    }
}
