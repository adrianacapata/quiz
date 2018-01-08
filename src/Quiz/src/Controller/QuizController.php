<?php
/**
 * Created by PhpStorm.
 * User: Adriana
 * Date: 1/7/2018
 * Time: 6:05 PM
 */

namespace Quiz\Controller;

use Dot\Controller\AbstractActionController;
use Quiz\Console\CsvHandler;

class QuizController extends AbstractActionController
{

    public function csvImport()
    {

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
        if ($discounted == false) {
            $product['discontinued_at'] = null;
        }
    //                self::addProduct($product);
    } else {
        $csvHandlerWrite->writeCsvLine($data);
    }
    }
}
}
