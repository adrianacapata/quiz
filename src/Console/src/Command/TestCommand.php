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
use Quiz\Controller\QuizController;
use Quiz\Entity\QuizEntity;
use Quiz\Service\QuizService;
use Quiz\Service\QuizServiceInterface;
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

        self::csvImport();
        return 0;
    }

    public function __construct(QuizServiceInterface $service)
    {
        $this->service = $service;
    }

    public function addCsv()
    {
        $import = new QuizEntity();

    }

    public function csvImport()
    {

//        var_dump(date('Y-m-d H:i:s')); exit;
        $sourcePath = getcwd() . '\src\Console\src\stock.csv';
        $destPath = getcwd() . '\src\Console\src\report.csv';

        $csvHandlerRead = new CsvHandler($sourcePath);
        $csvHandlerWrite = new CsvHandler($destPath, 'w');

        $header = $csvHandlerRead->getHeader();

        $csvHandlerWrite->setHeader($header);
        $csvHandlerWrite->writeHeaderLine();

        while ($data = $csvHandlerRead->readAssocNextRecord()) {
            $product = [];
            $valid = true;
            $discounted = false;
            if ($data['Cost in GBP'] < 5 && $data['Stock'] < 10) {
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


                $import = new QuizEntity();

                $import->setName($product['name']);
                $import->setDescription($product['description']);
                $import->setCode($product['code']);

                $date = date('Y-m-d H:i:s');

                if ($discounted == false) {
                    $import->setDiscontinuedAt('0000-00-00 00:00:00');
                }
//var_dump($import->getDiscontinuedAt());
                $this->service->import($import);

                //                self::addProduct($product);
            } else {
                $csvHandlerWrite->writeCsvLine($data);
            }
        }
    }
}
