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

use TYPO3\CMS\Core\Service\AbstractService;
use Tesseract\Tesseract\Component\DataControllerInterface;

/**
 * Base controller service. All Controller services should inherit from this class
 *
 * @author Francois Suter (Cobweb) <typo3@cobweb.ch>
 * @package TYPO3
 * @subpackage tx_tesseract
 */
abstract class ControllerBase extends AbstractService implements DataControllerInterface
{
    /**
     * Primary key of the controller record
     *
     * @var    integer
     */
    protected $uid;

    // Controller interface methods
    // (implement only methods that make sense here)

    /**
     * /**
     * Stores the ID of the controller.
     *
     * @param integer $id Primary key of the controller instance
     */
    public function loadData($id)
    {
        $this->uid = $id;
    }
}
