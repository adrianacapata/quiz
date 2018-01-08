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
        self::csvTest();

        return 0;
    }

    public function csvTest()
    {
        $sourcePath = getcwd() . '\src\Console\src\stock.csv';

        //object to read csv file
        $csvHandlerRead = new CsvHandler($sourcePath);

        //counts processed items
        $i = 0;
        //counts valid items
        $j = 0;

        //parse csv file associatively
        while ($data = $csvHandlerRead->readAssocNextRecord()) {
            $i++;
            //proudcts will be inserted to db
            $product = [];

            $valid = true;
            $discounted = false;

            //import rules
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
                $j++;
                $product = [
                    'name' => $data['Product Name'],
                    'description' => $data['Product Description'],
                    'code' => $data['Product Code']
                ];
            }
        }

        echo $i . " items were processed\n";
        echo $j . " items can be inserted in db\n";
        echo $i - $j . " item/items were skipped";
//        $fp = fopen(getcwd() . '\src\Console\src\report.txt', 'r');
    }
}
