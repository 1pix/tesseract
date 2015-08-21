<?php
namespace Tesseract\Tesseract\Component;

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

/**
 * Interface for objects that can behave as Data Filters
 *
 * @author Francois Suter (Cobweb) <typo3@cobweb.ch>
 * @package TYPO3
 * @subpackage tx_tesseract
 */
interface DataFilterInterface {

	/**
	 * This method processes the Data Filter's configuration and returns the filter structure
	 *
	 * @return array Standardised filter structure
	 */
	public function getFilterStructure();

	/**
	 * This method returns true or false depending on whether the filter can be considered empty or not
	 * @abstract
	 * @return boolean
	 */
	public function isFilterEmpty();

	/**
	 * This method returns the filter information itself
	 *
	 * @return array Internal filter array
	 */
	public function getFilter();

	/**
	 * This method is used to pass to the DataFilter an existing filter structure, generally coming from some cache
	 *
	 * @param array $filter An existing data filter structure
	 * @return void
	 */
	public function setFilter($filter);

	/**
	 * This method is used to save the filter in session
	 * It expects the filter to have some kind of key to identify the storage in session
	 *
	 * @return void
	 */
	public function saveFilter();
}
