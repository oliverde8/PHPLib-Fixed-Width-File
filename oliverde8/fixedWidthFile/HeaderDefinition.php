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
 * Class to handle the definition of the header
 *
 * @package oliverde8\fixedWidthFile
 */
class HeaderDefinition {

    /** @var array List of headers */
    protected $headers = array();

    /** @var array List of widths for each column */
    protected $widths = array();

    /**
     * Adds a column to the file
     *
     * @param int  $width Width of the column
     * @param null $code Code of the column (the key the data will be in)
     * @param null $name Name of the column (to use if columns are written on first line)
     *
     * @return $this
     */
    public function addColumn($width, $code = null, $name = null)
    {
        $i = count($this->widths);
        if (is_null($code)) {
            $code = $i;
        }

        $this->editColumn($code, $width, $name);

        return $this;
    }

    /**
     * Allows modification of an existing columns
     *
     * @param string $code  Code of the column to modify
     * @param int    $width New width of the column
     * @param null   $name  The new name of the column
     *
     * @return $this
     */
    public function editColumn($code, $width, $name = null)
    {
        $this->widths[$code] = $width;
        $this->headers[$code] = $name;

        return $this;
    }

    /**
     * Get defined widths
     *
     * @return int[]
     */
    public function getWidths()
    {
        return $this->widths;
    }

    /**
     * @return string[]
     */
    public function getNames()
    {
        return $this->headers;
    }
} 