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
 * Interface for Data Controllers when setting up relationships between
 * Tesseract components.
 *
 * @author Francois Suter (Cobweb) <typo3@cobweb.ch>
 * @package TYPO3
 * @subpackage tx_tesseract
 */
interface DataControllerInterface {

	/**
	 * This method is used to load the details about the controller
	 * This is mostly meant to match the other interfaces. In effect,
	 * it is really just about storing the controller's id
	 *
	 * @param integer $uid ID of the controller
	 * @return void
	 */
	public function loadData($uid);

	/**
	 * This method should return the Data Provider that the controller
	 * should pass to the Data Consumer, according to the relations defined
	 * by the controller
	 * NOTE: this is essentially meant to be used in the BE, when the
	 * Data Consumer must be "put in touch" with its Data Provider in order to
	 * know what data will be available, for mapping purposes
	 *
	 * @return \Tesseract\Tesseract\Component\DataProvider An object implementing the Data Provider interface
	 */
	public function getRelatedProvider();
}
