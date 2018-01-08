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
        self::csvTest();

        return 0;
    }

    public function csvTest()
    {

//        var_dump(date('Y-m-d H:i:s')); exit;
        $sourcePath = getcwd() . '\src\Console\src\stock.csv';
        //set path to report.csv file
        $destPath = getcwd() . '\src\Console\src\report.csv';

        //object to read csv file
        $csvHandlerRead = new CsvHandler($sourcePath);

        //object to write the report.csv file
        $csvHandlerWrite = new CsvHandler($destPath, 'w');

        //get the headers of the stock.csv file
        $header = $csvHandlerRead->getHeader();

        //set headers
        $csvHandlerWrite->setHeader($header);
        $csvHandlerWrite->writeHeaderLine();

        //parse csv file associatively
        while ($data = $csvHandlerRead->readAssocNextRecord()) {
            //proudcts will be inserted to db
            $product = [];
            $valid = true;
            $discounted = false;
            if ($data['Cost in GBP'] < 5 && $data['Stock'] < 10) {
                $valid = false;
            } elseif ($data['Cost in GBP'] > 1000) {
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
            }
        }
    }
}
