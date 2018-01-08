<?php
/**
 * Created by PhpStorm.
 * User: Adriana
 * Date: 1/7/2018
 * Time: 6:10 PM
 */

namespace Quiz\Mapper;

use Dot\Mapper\Mapper\AbstractDbMapper;
use Dot\Mapper\Mapper\MapperInterface;

class QuizMapper extends AbstractDbMapper implements MapperInterface
{
    protected $table = 'product';
}
