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

use Tesseract\Tesseract\Component\DataControllerOutputInterface;
use TYPO3\CMS\Core\Service\AbstractService;

/**
 * Base component class for all Tesseract components: Data Providers, Data Filters and Data Consumers
 * (controllers are a case apart).
 *
 * All Tesseract components are expected to be services extending
 * \Tesseract\Tesseract\Service\Component or any class derived from it.
 *
 * @author Francois Suter (Cobweb) <typo3@cobweb.ch>
 * @package TYPO3
 * @subpackage tx_tesseract
 */
abstract class Component extends AbstractService
{
    /**
     * Reference to the component's parent object, normally some kind of controller
     *
     * @var DataControllerOutputInterface
     */
    protected $controller;

    /**
     * Loads the details of a component into member variables.
     *
     * Usually expected data will be a table name (stored in $data['table'])
     * and a primary key value (stored in $data['uid'])
     *
     * @param array $data Data for the component
     * @return void
     */
    abstract public function loadData($data);

    /**
     * Returns the component's details
     *
     * @return array The component's details
     */
    abstract public function getData();

    /**
     * Sets the component's details.
     *
     * This is normally done via loadData(). This method is used in particular
     * during unit testing
     *
     * @param array $data Complete component information
     * @return void
     */
    abstract public function setData(array $data);

    /**
     * Sets a reference to the parent object, normally an instance of some controller
     *
     * @param DataControllerOutputInterface $controller Reference to a parent object
     * @return void
     */
    public function setController(DataControllerOutputInterface $controller)
    {
        $this->controller = $controller;
    }

    /**
     * Returns a reference to the component's controller
     *
     * @return DataControllerOutputInterface The controller
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * Returns the global database object.
     *
     * @return \TYPO3\CMS\Core\Database\DatabaseConnection
     */
    protected function getDatabaseConnection()
    {
        return $GLOBALS['TYPO3_DB'];
    }
}
