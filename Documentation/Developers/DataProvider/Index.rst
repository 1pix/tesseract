.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _developers-guide-api-data-provider:

Data Provider
^^^^^^^^^^^^^

The :code:`\Tesseract\Tesseract\Component\DataProviderInterface`
defines the methods that a data source must implement
in order to be recognized as a Data Provider. These methods are:

getProvidedDataStructures()
  This method returns a list (array) of all SDS types that the Data Provider
  can return (so one or more of “recordset”, “idlist” or any other that may be added at a later point).

providesDataStructure()
  This method takes a SDS type as an input and returns true or false
  depending on whether the Data Provider can provide it as an output or not.

getAcceptedDataStructures()
  This method returns a list (array) of all SDS types that the Data Provider can accept as an input.

acceptsDataStructure()
  This method takes a SDS type as an input and returns true or false
  depending on whether the Data Provider can handle it as an input or not.

getDataStructure()
  This method returns the SDS created by the Data Provider

setDataStructure()
  This method is used to pass to the Data Provider an input SDS

setDataFilter()
  This method is used to pass a Data Filter structure to the Data Provider.

getTablesAndFields()
  This method returns a list of tables and fields available in the data structure, complete with localized labels.

setEmptyDataStructureFlag()
  This method is used to set a flag that indicates whether an empty SDS should be returned or not.

getEmptyDataStructureFlag()
  This method is used to retrieve the status of the flag mentioned above.

Additionally the base implementation (:code:`\Tesseract\Tesseract\Service\ProviderBase`)
adds the following method (which could be overridden as needed):

initEmptyDataStructure()
  This method is used to prepare an empty SDS, for example setting an empty “records” array and set the count to 0.
  It is used when the empty structure flag has been set to TRUE.
