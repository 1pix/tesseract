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
 * Interface for objects that can behave as Data Consumers
 *
 * @author Francois Suter (Cobweb) <typo3@cobweb.ch>
 * @package TYPO3
 * @subpackage tx_tesseract
 */
interface DataConsumerInterface
{

    /**
     * This method returns the type of data structure that the Data Consumer can use
     *
     * @return    string    type of used data structures
     */
    public function getAcceptedDataStructure();

    /**
     * This method indicates whether the Data Consumer can use the type of data structure requested or not
     *
     * @param    string $type : type of data structure
     * @return    boolean        true if it can use the requested type, false otherwise
     */
    public function acceptsDataStructure($type);

    /**
     * This method is used to pass a data structure to the Data Consumer
     *
     * @param    array $structure : standardised data structure
     * @return    void
     */
    public function setDataStructure($structure);

    /**
     * This method is used to pass a Data Filter structure to the Data Consumer
     *
     * @param    array $filter : Data Filter structure
     * @return    void
     */
    public function setDataFilter($filter);

    /**
     * This method starts whatever rendering process the Data Consumer is programmed to do
     *
     * @return    void
     */
    public function startProcess();

    /**
     * This method returns the result of the work done by the Data Consumer (FE output or whatever else)
     * or displays an error message if no structure was set
     *
     * @return    mixed    the result of the Data Consumer's work
     */
    public function getResult();
}
