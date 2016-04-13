.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _developers-guide-api-base-component:

Base component
^^^^^^^^^^^^^^

All providers, filters and consumers are supposed to inherit from a base Tesseract component class
(:code:`\Tesseract\Tesseract\Service\Component`). This class defines the following methods:

loadData()
  This method is used to load the necessary information about the component.
  It takes a type and a primary key and retrieves the information from the database.
  It is the proper way of retrieving such data. The :code:`setData()` method (see below) is used in special cases.

setData()
  This method can be used to (forcefully) set the information related to the Tesseract component.
  This is usually achieved via :code:`loadData()`, but is sometimes useful.
  In particular it is used in the context of unit testing.

getData()
  This method returns the information related to the Tesseract component.

setController()
  This method is used to pass to the component a reference to its controller.

getController()
  This method returns a reference to the component's controller.