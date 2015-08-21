<?php
namespace Tesseract\Tesseract\Utility;

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

use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * This class provides a custom field for the extension configuration screen
 *
 * @author Francois Suter (Cobweb) <typo3@cobweb.ch>
 * @package TYPO3
 * @subpackage tx_tesseract
 */
class ExtensionManagerConfigurationHelper {
	protected static $extensionsList = array(
		'tesseract',
		'expressions',
		'overlays',
		'context',
		'displaycontroller',
		'datafilter',
		'dataquery',
		'templatedisplay'
	);

	public function  __construct() {
		$GLOBALS['LANG']->includeLLFile('EXT:tesseract/locallang.xml');
	}

	/**
	 * Returns a list with the status of all "core" Tesseract extensions.
	 *
	 * @param array	 $params Information about the field to be rendered
	 * @param \TYPO3\CMS\Core\TypoScript\ConfigurationForm $parentObject The calling parent object.
	 * @return string The HTML selector
	 */
	public function installationCheck(array $params, $parentObject) {
		$checkText = '<p style="margin-bottom: 10px;"><strong>' . $GLOBALS['LANG']->getLL('installationCheck.warning') . '</strong></p>';
		foreach (self::$extensionsList as $anExtension) {
			$checkText .= $this->wrapMessage(
				$anExtension,
				ExtensionManagementUtility::isLoaded($anExtension)
			);
		}
		return $checkText;
	}

	/**
	 * Prepares an installation status message for a given extension.
	 *
	 * @param string $extension The extension key
	 * @param boolean $status True if extension is installed, false otherwise
	 * @return string HTML for the message
	 */
	protected function wrapMessage($extension, $status) {
			// Assemble flash messages and render it
		$severity = FlashMessage::OK;
		$messageText = $GLOBALS['LANG']->getLL('installationCheck.extensionInstalled');
		$title = $GLOBALS['LANG']->getLL('installationCheck.extension') . ': ' . $extension;
		if (!$status) {
			$severity = FlashMessage::WARNING;
			$messageText = $GLOBALS['LANG']->getLL('installationCheck.extensionNotInstalled');
		}

		/** @var $flashMessage \TYPO3\CMS\Core\Messaging\FlashMessage */
		$flashMessage = GeneralUtility::makeInstance(
			'TYPO3\\CMS\\Core\\Messaging\\FlashMessage',
			$messageText,
			$title,
			$severity
		);
		return $flashMessage->render();
	}
}
