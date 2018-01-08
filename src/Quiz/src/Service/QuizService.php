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
use Quiz\Entity\QuizEntity;
use Dot\Mapper\Entity\EntityInterface;

class QuizService implements MapperManagerAwareInterface, QuizServiceInterface
{
    use MapperManagerAwareTrait;

    public function import(QuizEntity $quiz)
    {
//        var_dump($mapper = $this->getMapperManager()); exit;
        $mapper = $this->getMapperManager()->get(QuizEntity::class);
        return $mapper->save($quiz);
    }
}
