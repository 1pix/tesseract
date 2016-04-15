<?php
namespace Tesseract\Tesseract\Service;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use Tesseract\Tesseract\Component\DataFilterInterface;
use Tesseract\Tesseract\Exception\MissingComponentException;

/**
 * Base datafilter service. All Data Filter services should inherit from this class.
 *
 * @author Francois Suter (Cobweb) <typo3@cobweb.ch>
 * @package TYPO3
 * @subpackage tx_tesseract
 */
abstract class FilterBase extends Component implements DataFilterInterface
{
    /**
     * Allowed values for ordering engines
     *
     * @var array
     */
    protected static $allowedOrderingEngines = array('source', 'provider');

    /**
     * Name of the table where the details about the data query are stored
     *
     * @var    string
     */
    protected $table;

    /**
     * Primary key of the record to fetch for the details
     *
     * @var    integer
     */
    protected $uid;

    /**
     * Record from the database about the Data Filter
     *
     * @var    array
     */
    protected $filterData = array();

    /**
     * Will contain the complete filter structure
     *
     * @var    array
     */
    protected $filter;

    // Data Filter interface methods
    // (implement only methods that make sense here)

    /**
     * Loads the details about the Data Filter passing it whatever data it needs
     *
     * This will generally be a table name (stored in $data['table']) and a primary key value (stored in $data['uid'])
     *
     * @param array $data Data for the Data Filter
     * @throws MissingComponentException
     * @return void
     */
    public function loadData($data)
    {
        $this->table = $data['table'];
        $this->uid = (int)$data['uid'];
        $whereClause = 'uid = ' . $this->uid;
        if (isset($GLOBALS['TSFE'])) {
            $whereClause .= $GLOBALS['TSFE']->sys_page->enableFields($this->table, $GLOBALS['TSFE']->showHiddenRecords);
        }
        $row = $this->getDatabaseConnection()->exec_SELECTgetSingleRow(
                '*',
                $this->table,
                $whereClause
        );
        if (empty($row)) {
            throw new MissingComponentException(
                    'Could not load filter details',
                    1431703807
            );
        } else {
            $this->filterData = $row;
        }

        $this->loadTyposcriptConfiguration($data['table']);
    }

    /**
     * Replaces unset data with default values defined with TypoScript.
     *
     * @param string $tableName Name of the table containing the data
     * @return void
     */
    protected function loadTyposcriptConfiguration($tableName)
    {
        if (isset($GLOBALS['TSFE'])) {
            $typoscriptConfiguration = $GLOBALS['TSFE']->config['config']['tx_tesseract.'][$tableName . '.']['default.'];
            // If there's some TypoScript configuration, use its values, but only if there's not already a value from the DB
            if (is_array($typoscriptConfiguration)) {
                foreach ($typoscriptConfiguration as $key => $value) {
                    if (!isset($this->filterData[$key]) || $this->filterData[$key] == '') {
                        $this->filterData[$key] = $typoscriptConfiguration[$key];
                    }
                }
            }
        }
    }

    /**
     * Returns the filter's data.
     *
     * @return array The filter's data, as stored in the corresponding database record
     */
    public function getData()
    {
        return $this->filterData;
    }

    /**
     * This method makes it possible to force the data of the filter
     * Normally it should be defined via loadData().
     *
     * @param array $data Complete filter information
     * @return void
     */
    public function setData(array $data)
    {
        $this->filterData = $data;
    }

    /**
     * Returns true or false depending on whether the filter can be considered empty or not.
     *
     * @return bool
     */
    public function isFilterEmpty()
    {
        // Return true if there are no filters
        return count($this->filter['filters']) == 0;
    }

    /**
     * Returns the filter information itself.
     *
     * @return array Internal filter array
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * Passes to the DataFilter an existing filter structure, generally coming from some cache
     *
     * @param array $filter An existing data filter structure
     * @return void
     */
    public function setFilter($filter)
    {
        if (is_array($filter) && count($filter) > 0) {
            $this->filter = $filter;
        }
    }

    /**
     * Performs necessary initialisations when an instance of this service
     * is called up several times.
     *
     * @return void
     */
    public function reset()
    {
        $this->filter = array();
    }
}
