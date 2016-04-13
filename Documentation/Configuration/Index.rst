.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _configuration:

Configuration
=============

It is possible to use TypoScript to configure default values
for the Data Filters, Data Providers and Data Consumers. The general syntax is the following:

.. code-block:: typoscript

   config.tx_tesseract.[table name].default.[field name] = foo

Let's say you want to have a default value of 20 for the "Max items per view"
in the "datafilter" extension. The syntax would be:

.. code-block:: typoscript

   config.tx_tesseract.tx_datafilter_filters.default.limit_start = 20
