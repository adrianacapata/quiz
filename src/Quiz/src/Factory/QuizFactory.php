<?php
/**
 * Created by PhpStorm.
 * User: Adriana
 * Date: 1/7/2018
 * Time: 9:17 PM
 */

namespace Quiz\Factory;

use Interop\Container\ContainerInterface;
use Quiz\Console\Command\ImportCommand;
use Quiz\Service\QuizServiceInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class QuizFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {

        $service = $container->get(QuizServiceInterface::class);
        return new ImportCommand($service);
    }
}
