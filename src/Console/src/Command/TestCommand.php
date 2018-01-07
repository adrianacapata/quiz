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

        $sourcePath = getcwd() . '\src\Console\src\stock.csv';
        $destPath = getcwd() . '\src\Console\src\report.csv';

        $csvHandlerRead = new CsvHandler($sourcePath);
        $csvHandlerWrite = new CsvHandler($destPath, 'w');

        $header = $csvHandlerRead->getHeader();

        $csvHandlerWrite->setHeader($header);
        $csvHandlerWrite->writeHeaderLine();

        while ($data = $csvHandlerRead->readAssocNextRecord()) {

            $valid = true;
            $discounted = false;
            if ($data['Cost in GBP'] < 5 && $data['Stock'] > 10) {
                $valid = false;
            } else if ($data['Cost in GBP'] > 1000) {
                $valid = false;
            }
            if (strtolower($data['Discontinued']) == 'yes') {
                $valid = true;
                $discounted = true;
            }
            if ($valid == true) {
                $product = [
                    'name' => $data['Product Name'],
                    'description' => $data['Product Description'],
                    'code' => $data['Product Code']
                ];
                if ($discounted == false) {
                    $product['discontinued_at'] = null;
                }
//                self::addProduct($product);
            } else {
                $csvHandlerWrite->writeCsvLine($data);
            }
        }
        return 0;
    }
}
