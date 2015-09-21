<?php

/**
 * Allow you to export CSV file easily
 * 
 * @author Louis Hatier
 */
class SimpleCsv
{
    private $_charset;
    private $_separator;
    private $_eol;
    private $_content;

    /**
     * You can pass a charset like ISO-8859-15
     * 
     * @param string $charset
     * @param string $separator
     * @param string $_eol
     * @return SimpleCsv
     */
    public function __construct($charset = 'UTF-8', $separator = ';', $eol = "\r\n")
    {
        $this->_charset = $charset;
        $this->_separator = $separator;
        $this->_eol = $eol;
        $this->_content = array();
    }

    /**
     * Store a line in the content array
     * 
     * @param array $data
     * @return string
     */
    public function writeLine(array $data)
    {
        $line = '';
        $keys = array_keys($data);
        $lastKey = end($keys);
        foreach ($data as $key => $value) {
            $line .= $this->_protect($value);
            if ($key !== $lastKey) { // no separator for the last element
                $line .= $this->_separator;
            }
        }
        $this->_content[] = $line;
    }

    /**
     * Return the CSV content
     * 
     * @return string
     */
    public function getContent()
    {
        return implode($this->_eol, $this->_content);
    }

    /**
     * Show the CSV file
     * 
     * @param string $fileName
     * @return string
     */
    public function show($fileName)
    {
        header('Content-type: text/csv; charset=' . $this->_charset);
        header('Content-Disposition: attachment; filename="' . $fileName . '.csv"');
        echo $this->getContent();
    }

    /**
     * Save the CSV
     * 
     * @param string $location
     * @return void
     */
    public function save($location)
    {
        file_put_contents($location, $this->getContent());
    }

    /**
     * Protect a string with quote
     * 
     * @param string $text
     * @return string
     */
    private function _protect($text)
    {
        $text = str_replace('"', '""', $text);
        return '"' . utf8_decode($text) . '"'; // decode to be good looking in Excel (french accent for instance)
    }
}
