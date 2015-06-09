<?php

namespace Meeting\Helper;

use Keboola\Csv\CsvFile;

class CsvHelper
{
    private $_header;
    private $_filename;
    private $_outputDirectory;

    public function storeCsvReport($data)
    {
        if (!file_exists($this->_outputDirectory))
            mkdir($this->_outputDirectory, 0777, true);

        $csvFile = new CsvFile($this->_outputDirectory.'/'.$this->_filename);
        $csvFile->writeRow($this->_header);

        foreach ($data as $row)
            $csvFile->writeRow($row);

        return $csvFile;
    }

    /**
     * @param mixed $header
     */
    public function setHeader($header)
    {
        $this->_header = $header;
    }

    /**
     * @param mixed $filename
     */
    public function setFilename($filename)
    {
        $this->_filename = $filename;
    }

    /**
     * @param mixed $outputDirectory
     */
    public function setOutputDirectory($outputDirectory)
    {
        $this->_outputDirectory = $outputDirectory;
    }
}