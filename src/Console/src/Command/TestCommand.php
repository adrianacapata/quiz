<?php
/**
 * Created by PhpStorm.
 * User: Adriana
 * Date: 1/6/2018
 * Time: 6:33 PM
 */

namespace Quiz\Console\Command;

use Dot\AnnotatedServices\Annotation\Service;
use Dot\Console\Command\AbstractCommand;
use Symfony\Component\Console\Tests\DependencyInjection\AddConsoleCommandPassTest;
use Zend\Console\Adapter\AdapterInterface;
use ZF\Console\Route;
use Quiz\Console\CsvHandler;

/**
 * Class TestCommand
 * @package Frontend\Console\Command
 *
 * @Service
 */

class TestCommand extends AbstractCommand
{

    /**
     * @param Route $route
     * @param AdapterInterface $console
     */
    public function __invoke(Route $route, AdapterInterface $console)
    {
        $commands = require 'config/autoload/console.global.php';
//        $commands = $container->get('dot_console');
//        var_dump($commands['dot_console']['commands']); exit;
//        switch () {
//            case 'test':
//                $sourcePath = getcwd() . '\src\Console\src\stock.csv';
//                $destPath = getcwd() . '\src\Console\src\something.txt';
//
//
//                $csvHandlerRead = new CsvHandler($sourcePath);
//                $csvHandlerWrite = new CsvHandler($destPath, 'w');
//
//
//                $header = $csvHandlerRead->getHeader();
//                $csvHandlerWrite->setHeader($header);
//                $csvHandlerWrite->writeHeaderLine();
//
//                while ($data = $csvHandlerRead->readAssocNextRecord()) {
//                    $allData[] = $data;
////            $console->write('test');
//                }
////        $csvHandlerWrite->writeCsvLine($data);
//        break;
//            case 'test2':
//                echo 'test2';
//                break;
//        }


                $sourcePath = getcwd() . '\src\Console\src\stock.csv';
                $destPath = getcwd() . '\src\Console\src\something.txt';

                $csvHandlerRead = new CsvHandler($sourcePath);
                $csvHandlerWrite = new CsvHandler($destPath, 'w');


                $header = $csvHandlerRead->getHeader();
                $csvHandlerWrite->setHeader($header);
                $csvHandlerWrite->writeHeaderLine();

                while ($data = $csvHandlerRead->readAssocNextRecord()) {
                    $allData[] = $data;
                    foreach ($data as $key => $value) {
                        var_dump($data);
                    }

                }
//        $csvHandlerWrite->writeCsvLine($allData);


        return 0;
    }
}