<?php
/**
 * Created by PhpStorm.
 * User: Adriana
 * Date: 1/8/2018
 * Time: 10:31 PM
 */

namespace Quiz\Console\Command;

use Dot\Console\Command\AbstractCommand;
use Quiz\Console\CsvHandler;
use Quiz\Entity\QuizEntity;
use Quiz\Service\QuizServiceInterface;
use Zend\Console\Adapter\AdapterInterface;
use ZF\Console\Route;

class ImportCommand extends AbstractCommand
{

    /**
     * @param Route $route
     * @param AdapterInterface $console
     */
    public function __invoke(Route $route, AdapterInterface $console)
    {
        self::csvImport();
        return 0;
    }

    public function __construct(QuizServiceInterface $service)
    {
        $this->service = $service;
    }

    public function csvImport()
    {
        //get source path to the csv file
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
            //proudcts that will be inserted to db
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
                    'code' => $data['Product Code'],
                    'stock' => $data['Stock'],
                    'price' => $data['Cost in GBP']
                ];

                //create new product entity
                $import = new QuizEntity();

                $import->setName($product['name']);
                $import->setDescription($product['description']);
                $import->setCode($product['code']);
                $import->setStock($product['stock']);
                $import->setPrice($product['price']);

                $date = date('Y-m-d H:i:s');

                if ($discounted == true) {
                    //@TODO fix this!!!
                    $import->setDiscontinuedAt($date);
                }

                $this->service->import($import);
            } else {
                $csvHandlerWrite->writeCsvLine($data);
            }
        }
        echo 'see items that were skipped in src\Console\src\report.csv';
    }
}
