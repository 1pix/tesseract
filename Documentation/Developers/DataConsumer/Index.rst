.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _developers-guide-api-data-consumer:

Data Consumer
^^^^^^^^^^^^^

Similarly the :code:`\Tesseract\Tesseract\Component\DataConsumerInterface`
defines what methods are expected from a class in order to mark it as a Data Consumer.
The methods are:

getAcceptedDataStructures()
  This method returns a list (array) of all SDS types that the Data Consumer can accept as an input.

acceptsDataStructure()
  This method takes a SDS type as an input and returns true or false
  depending on whether the Data Consumer can handle it as an input or not.

setDataStructure()
  This method is used to pass to the Data Consumer an input SDS

setDataFilter()
  This method is used to pass a Data Filter structure to the Data Consumer.

startProcess()
  This method tells the Data Consumer to start rendering the SDS into its final output,
  but that output is not returned yet. It is just stored internally.

getResult()
  This method gets the output produced by the Data Consumer. This means it's normally called after
  :code:`startProcess()`.

  It can also be called directly (i.e. not after :code:`startProcess()`) when the Data Consumer
  should not be passed any structure. In this case, it is expected to render some kind of error output.
  This situation is likely to happen when a filter didn't return any filtering values.
  In this you may either want to get everything from the Data Provider, or nothing.
  In the latter case it's not necessary to call the Data Provider at all
  and the Data Consumer may be called without SDS.
