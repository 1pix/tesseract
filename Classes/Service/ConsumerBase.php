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

use Tesseract\Tesseract\Component\DataConsumerInterface;
use Tesseract\Tesseract\Exception\MissingComponentException;

/**
 * Base dataconsumer service. Data Consumer services should inherit from this class, *except* FE Data Consumer services,
 * which should inherit from derived class \Tesseract\Tesseract\Service\FrontendConsumerBase.
 *
 * @author Francois Suter (Cobweb) <typo3@cobweb.ch>
 * @package TYPO3
 * @subpackage tx_tesseract
 */
abstract class ConsumerBase extends Component implements DataConsumerInterface {
	/**
	 * @var string Name of the table where the details about the consumer are stored
	 */
	protected $table;

	/**
	 * @var int Primary key of the record to fetch for the details
	 */
	protected $uid;

	/**
	 * @var array Consumer details (will generally be coming from the DB)
	 */
	protected $consumerData = array();

	/**
	 * @var array Associated Data Filter structure
	 */
	protected $filter;

	/**
	 * Loads the details about the Data Consumer passing it whatever data it needs
	 *
	 * This will generally be a table name and a primary key value
	 *
	 * @param array $data Data for the Data Consumer
	 * @throws MissingComponentException
	 */
	public function loadData($data) {
		$this->table = $data['table'];
		$this->uid = intval($data['uid']);
		// Get record where the details of the data display are stored
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
				'Could not load consumer details',
				1431703807
			);
		} else {
			$this->consumerData = $row;
		}

		$this->loadTyposcriptConfiguration($data['table']);
	}

	/**
	 * Returns the data consumer's details
	 *
	 * @return array The data consumer's details
	 */
	public function getData() {
		return $this->consumerData;
	}

	/**
	 * Sets the full data consumer's details
	 *
	 * Should be used only when needed. Normal way is to use loadData()
	 *
	 * @param array $data Complete consumer details
	 * @return void
	 */
	public function setData(array $data) {
		$this->consumerData = $data;
	}

	/**
	 * This method replaces unset data with default values defined with TypoScript
	 *
	 * @param string $tableName Name of the table containing the data
	 * @return void
	 */
	protected function loadTyposcriptConfiguration($tableName) {
		if (isset($GLOBALS['TSFE'])) {
			$typoscriptConfiguration = $GLOBALS['TSFE']->config['config']['tx_tesseract.'][$tableName . '.']['default.'];
				// If there's some TypoScript configuration, use its values, but only if there's not already a value from the DB
			if (is_array($typoscriptConfiguration)) {
				foreach ($typoscriptConfiguration as $key => $value) {
					if (!isset($this->consumerData[$key]) || $this->consumerData[$key] == '') {
						$this->consumerData[$key] = $typoscriptConfiguration[$key];
					}
				}
			}
		}
	}

	/**
	 * This method is used to pass a Data Filter structure to the Data Provider
	 *
	 * @param array $filter Data Filter structure
	 * @return void
	 */
	public function setDataFilter($filter) {
		if (is_array($filter)) {
			$this->filter = $filter;
		}
	}
}
