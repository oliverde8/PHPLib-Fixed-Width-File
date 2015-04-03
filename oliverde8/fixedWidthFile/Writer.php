<?php
/**
 * @author      Oliver de Cramer (oliverde8 at gmail.com)
 * @copyright    GNU GENERAL PUBLIC LICENSE
 *                     Version 3, 29 June 2007
 *
 * PHP version 5.3 and above
 *
 * LICENSE: This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see {http://www.gnu.org/licenses/}.
 */

namespace oliverde8\fixedWidthFile;

use oliverde8\fixedWidthFile\Exception\Open as OpenException;
use oliverde8\fixedWidthFile\Exception\Width as WidthException;

/**
 * Class to handle the generation of a text file where for each columns the number of caracter is constant.
 *
 * @package oliverde8\fixedWidthFile
 */
class Writer {

    /** @var String Name of the file to write into */
    protected $fileName;
    /** @var resource Opened file */
    protected $file;

    /** @var string String to use as a padding */
    protected $padString;
    /** @var int Padding type to use */
    protected $padType;

    protected $header = NULL;

    /**
     * Build the Constatn column generator helper.
     *
     * @param string $fileName  Path of the file to write into
     * @param string $padString Pad to use around the strings
     * @param int    $padType   Pad type
     *
     * @throws OpenException If file can't be opened.
     */
    function __construct($fileName, $padString = ' ', $padType = STR_PAD_LEFT)
    {
        $this->fileName = $fileName;
        $this->padString = $padString;
        $this->padType = $padType;

        $this->file = @fopen($fileName, 'w');

        if (!$this->file) {
            throw new OpenException("Couln't open file : '$fileName'");
        }
    }

    /**
     * Get the header definition to use or enrich it
     *
     * @return HeaderDefinition
     */
    public function getHeader()
    {
        if (is_null($this->header)) {
            $this->header = new HeaderDefinition();
        }

        return $this->header;
    }

    public function setHeader(HeaderDefinition $header)
    {
        $this->header = $header;
    }

    /**
     * Writes a line data respecting the column information defined earlier
     *
     * @param string[] $data Data to write
     *
     * @return $this
     *
     * @throws WidthException If data contains a string that can't be written in the defined width
     */
    public function writeLine($data)
    {
        $line = '';
        $padTypes = $this->getHeader()->getPadTypes();
        foreach ($this->getHeader()->getWidths() as $code => $width) {
            $padType = isset($padTypes[$code]) ? $padTypes[$code] : $this->padType;
            if (isset($data[$code])) {
                $line .= self::padText($data[$code], $width, $this->padString, $padType);
            } else {
                $line .= self::padText('', $width, $this->padString, $padType);
            }
        }

        fwrite($this->file, $line."\n");

        return $this;
    }

  function __destruct()
  {
    $this->terminate();
  }


  /**
     * Finishes writing into the file
     */
    public function terminate()
    {
        fclose($this->file);
        $this->file = null;
    }

    /**
     * @param string $text      Text to pad
     * @param int    $width     Width that the text need to have
     * @param string $padString string to use as padding
     * @param int    $padType   Padding type
     *
     * @return string
     * @throws WidthException If data contains a string that can't be written in the defined width
     */
    public static function padText($text, $width, $padString = ' ', $padType = STR_PAD_LEFT)
    {
        if (strlen($text) > $width) {
            throw new WidthException("Text('$text') is to long and padding can't be added.");
        } else {
            return str_pad($text, $width, $padString, $padType);
        }
    }
}
