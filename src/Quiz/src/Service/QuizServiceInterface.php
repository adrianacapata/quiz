<?php
/**
 * Created by PhpStorm.
 * User: Adriana
 * Date: 1/7/2018
 * Time: 9:13 PM
 */

namespace Quiz\Service;

use Quiz\Entity\QuizEntity;

interface QuizServiceInterface
{
    public function import(QuizEntity $quiz);
}
