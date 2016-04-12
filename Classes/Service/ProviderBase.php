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

use Tesseract\Tesseract\Exception\MissingComponentException;
use Tesseract\Tesseract\Tesseract;
use Tesseract\Tesseract\Component\DataProviderInterface;

/**
 * Base dataprovider service. All Data Provider services should inherit from this class
 *
 * @author Francois Suter (Cobweb) <typo3@cobweb.ch>
 * @package TYPO3
 * @subpackage tx_tesseract
 */
abstract class ProviderBase extends Component implements DataProviderInterface
{
    /**
     * @var string Name of the table where the details about the provider are stored
     */
    public $table;

    /**
     * @var integer Primary key of the record to fetch for the details
     */
    public $uid;

    /**
     * @var array Data Provider details
     */
    public $providerData = array();

    /**
     * @var array Associated Data Filter structure
     */
    public $filter = array();

    /**
     * @var array Input standardised data structure
     */
    public $structure = array();

    /**
     * @var bool Set to true if empty structure was forced (see initEmptyDataStructure())
     */
    public $hasEmptyOutputStructure = false;

    /**
     * @var array Output standardised data structure
     */
    public $outputStructure = array();

    // Data Provider interface methods
    // (implement only methods that make sense here)

    /**
     * Loads the details about the Data Provider passing it whatever data it needs.
     *
     * This will generally be a table name (stored in $data['tablenames']) and a primary key value (stored in $data['uid_foreign']).
     *
     * @param array $data Data for the Data Provider
     * @throws MissingComponentException
     * @return void
     */
    public function loadData($data)
    {
        $this->table = $data['table'];
        $this->uid = intval($data['uid']);
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
                    'Could not load provider details',
                    1431705346
            );
        } else {
            $this->providerData = $row;
        }

        $this->loadTyposcriptConfiguration($data['table']);
    }

    /**
     * Returns the data provider's details.
     *
     * @return array The data provider's details.
     */
    public function getData()
    {
        return $this->providerData;
    }

    /**
     * Sets the full data provider's details.
     *
     * Should be used only when needed. Normal way is to use loadData().
     *
     * @param array $data Complete provider details
     * @return void
     */
    public function setData(array $data)
    {
        $this->providerData = $data;
    }

    /**
     * This method replaces unset data with default values defined with TypoScript.
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
                    if (!isset($this->providerData[$key]) || $this->providerData[$key] == '') {
                        $this->providerData[$key] = $typoscriptConfiguration[$key];
                    }
                }
            }
        }
    }

    /**
     * This method is used to pass a Data Filter structure to the Data Provider.
     *
     * @param array $filter Data Filter structure
     * @return void
     */
    public function setDataFilter($filter)
    {
        if (is_array($filter)) {
            $this->filter = $filter;
        }
    }

    /**
     * This method is used to pass a data structure to the Data Provider.
     *
     * @param array $structure Standardised data structure
     * @return void
     */
    public function setDataStructure($structure)
    {
        if (is_array($structure)) {
            $this->structure = $structure;
        }
    }

    /**
     * This method can be used to get the hasEmptyOutputStructure flag.
     *
     * @return boolean The empty output structure flag
     */
    public function getEmptyDataStructureFlag()
    {
        return $this->hasEmptyOutputStructure;
    }

    /**
     * This method can be used to set the hasEmptyOutputStructure flag.
     *
     * @param boolean $flag The value to set
     * @return void
     */
    public function setEmptyDataStructureFlag($flag)
    {
        if ($flag) {
            $this->hasEmptyOutputStructure = true;
        } else {
            $this->hasEmptyOutputStructure = false;
        }
    }

    // t3lib_svbase methods

    /**
     * This method resets values for a number of properties.
     *
     * This is necessary because services are managed as singletons
     *
     * NOTE: If you make your own implementation of reset in your DataProvider class, don't forget to call parent::reset()
     *
     * @return void
     */
    public function reset()
    {
        parent::reset();
        $this->table = '';
        $this->uid = '';
        $this->providerData = array();
        $this->filter = array();
        $this->structure = array();
        $this->hasEmptyOutputStructure = false;
        $this->outputStructure = array();
    }

    // Other methods

    /**
     * This method prepares an empty data structure
     * i.e. with most properties undefined, an empty array for "records" and a "count" of 0.
     *
     * @param string $tablename Name of the main table (a structure should always have a table defined)
     * @param string $type Type of datastructure
     * @return void
     */
    protected function initEmptyDataStructure($tablename, $type = Tesseract::RECORDSET_STRUCTURE_TYPE)
    {
        // Set up base structure
        $this->outputStructure = array(
                'count' => 0,
                'totalCount' => 0,
                'uidList' => false,
                'filter' => array(),
        );
        // Initialize more data dependent of structure type
        if ($type == Tesseract::RECORDSET_STRUCTURE_TYPE) {
            $this->outputStructure['records'] = array();
            $this->outputStructure['name'] = $tablename;
            $this->outputStructure['header'] = false;
        } elseif ($type == Tesseract::IDLIST_STRUCTURE_TYPE) {
            $this->outputStructure['uniqueTable'] = $tablename;
            $this->outputStructure['uidListWithTable'] = '';
        }
    }
}
