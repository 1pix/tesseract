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
 * Interface for objects that can behave as Data Providers
 *
 * @author Francois Suter (Cobweb) <typo3@cobweb.ch>
 * @package TYPO3
 * @subpackage tx_tesseract
 */
interface DataProviderInterface {

	/**
	 * This method returns the type of data structure that the Data Provider can prepare
	 *
	 * @return string Type of the provided data structure
	 */
	public function getProvidedDataStructure();

	/**
	 * This method indicates whether the Data Provider can create the type of data structure requested or not
	 *
	 * @param string $type Type of data structure
	 * @return boolean True if it can handle the requested type, false otherwise
	 */
	public function providesDataStructure($type);

	/**
	 * This method returns the type of data structure that the Data Provider can receive as input
	 *
	 * @return string Type of used data structures
	 */
	public function getAcceptedDataStructure();

	/**
	 * This method indicates whether the Data Provider can use as input the type of data structure requested or not
	 *
	 * @param string $type Type of data structure
	 * @return boolean True if it can use the requested type, false otherwise
	 */
	public function acceptsDataStructure($type);

	/**
	 * This method assembles the data structure and returns it
	 *
	 * @return array Standardised data structure
	 */
	public function getDataStructure();

	/**
	 * This method is used to pass a data structure to the Data Provider
	 *
	 * @param array $structure Standardised data structure
	 * @return void
	 */
	public function setDataStructure($structure);

	/**
	 * This method is used to pass a Data Filter structure to the Data Provider
	 *
	 * @param array $filter Data Filter structure
	 * @return void
	 */
	public function setDataFilter($filter);

	/**
     * This method returns a list of tables and fields (or equivalent) available in the data structure,
     * complete with localized labels
     *
     * @param string $language 2-letter iso code for language
     * @return array List of tables and fields
     */
	public function getTablesAndFields($language = '');

	/**
	 * This method can be used to get the hasEmptyOutputStructure flag
	 *
	 * @return boolean The empty output structure flag
	 */
	public function getEmptyDataStructureFlag();

	/**
	 * This method can be used to set the hasEmptyOutputStructure flag
	 *
	 * @param boolean $flag The value to set
	 * @return void
	 */
	public function setEmptyDataStructureFlag($flag);
}
