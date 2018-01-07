<?php
/**
 * Created by PhpStorm.
 * User: Adriana
 * Date: 1/6/2018
 * Time: 6:42 PM
 */

namespace Quiz\Console;


class CsvHandler
{
    // file
    protected $fileHandle;
    protected $mode;

    // csv
    protected $delimiter;
    protected $enclosure;
    protected $escape;

    // header
    protected $header = null;

    /**
     * @return array|null
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * @param array|null $header
     */
    public function setHeader($header)
    {
        $this->header = $header;
    }

    /**
     *
     * @param string $filename - file to be loaded
     */
    public function __construct(
        $filename,
        $mode = 'r',
        $hasHeader = true,
        $delimiter = ",",
        $enclosure = '"',
        $escape = "\\"
    ) {
//        echo getcwd() . '\src\Console\src\stock.csv'; exit;
        $this->fileHandle = fopen($filename, $mode);
//        echo $this->fileHandle; exit;
        $this->mode = $mode;
        $this->delimiter = $delimiter;
        $this->enclosure = $enclosure;
        $this->escape = $escape;
        // $this->data;
        if ($hasHeader == true) {
            $this->header = fgetcsv($this->fileHandle, $mode, $delimiter, $enclosure, $escape);
        }
    }

    /**
     * Read next CSV record
     * @return array
     */
    public function readNextRecord()
    {
        $delimiter = $this->delimiter;
        $mode = $this->mode;
        $enclosure = $this->enclosure;
        $escape = $this->escape;

        $data = fgetcsv($this->fileHandle, $mode, $delimiter, $enclosure, $escape);
        $this->data = $data;
        return $data;
    }

    /**
     * Read next CSV record (associatively)
     * @return array|bool
     */
    public function readAssocNextRecord()
    {
        $assocRecord = array();

        // read original record
        $record = $this->readNextRecord();
        $header = $this->header;

        if ($record === false) {
            return false;
        }

        // merge keys and values
        $keyCount = count($this->header);
        for ($i=0; $i<$keyCount; $i++) {
            $assocRecord[$header[$i]] = @$record[$i];
        }

        return $assocRecord;
    }

    /**
     * Read all lines from csv
     *
     * @param bool $associative - [optional] - read lines associatively, true by default
     * @return array
     */
    public function readAllLines($associative = true)
    {
        $allLines = array();

        // choose method
        $method = "readAssocNextRecord";
        if ($associative == false) {
            $method = "readNextRecord";
        }

        // write all records in array
        while (($currentRecord = $this->$method()) !== false) {
            $allLines[] = $currentRecord;
        }

        return $allLines;
    }


    /**
     * write in csv file
     * @access public
     * @param array $data
     * @return void
     */
    public function writeCsvLine($data)
    {
        $delimiter = $this->delimiter;
        $mode = $this->mode;
        $enclosure = $this->enclosure;
        $escape = $this->escape;

        return fputcsv($this->fileHandle, array_values($data), $delimiter, $enclosure, $escape);
    }


    /**
     * write in csv file header
     * @access public
     * @param none
     * @return void
     */
    public function writeHeaderLine()
    {
        return $this->writeCsvLine($this->header);
    }

    /**
     * write in csv file data
     * @access public
     * @param string $path
     * @param array $data
     * @return void
     */
    public static function writeCsvFile($path, $data)
    {
        $file = fopen($path, 'w');
        $header = array_keys($data[0]);

        fputcsv($file, $header);

        foreach ($data as $value) {
            fputcsv($file, $value);
        }

        fclose($file);
        return TRUE;
    }
}
