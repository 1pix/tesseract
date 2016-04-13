.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _developers-guide-api-data-filters:

Data Filters
^^^^^^^^^^^^

The same goes again for the Data Filters, with the
:code:`\Tesseract\Tesseract\Component\DataFilterInterface`:

getFilterStructure()
  This method processes the Data Filter's configuration and returns the filter structure.

isFilterEmpty()
  This method returns true if the "filters" part of the filter structure is empty, false otherwise.

getFilter()
  This method is called to get the Data Filter itself. It will start the processing
  of the filter configuration and return the standard Data Filter structure.

setFilter()
  This method is used to pass an existing Data Filter structure to the Data Filter.
  This will normally be a Data Filter structure that was saved in cache.

saveFilter()
  This method saves the Data Filter into the transient session object (“ses”).

