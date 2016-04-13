.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _fundamentals:

Fundamentals
============

Displaying list of things (news items, flats, cars, movies, etc.) is a very common task in any web site.
It is generally expected that such lists can be filtered and sorted. Each item should link to a detail view
with cross-linking to related items (like actors to a movie, for example).

The common way to solve such tasks in TYPO3 CMS is to create a specific extension,
dedicated to a particular topic (cars, movies, etc.). Although TYPO3 CMS does provide some libraries
for easing this task, it still means a multiplication of extensions that basically perform the same task.

The aim of the Tesseract Project is to provide a generic way of achieving this,
to avoid the need for repetitive, dedicated extensions. Such generalization can be achieved
by defining a clean API and data exchange standards, orchestrated by controllers.

.. toctree::
    :maxdepth: 2
    :titlesonly:

    MainConcept/Index
    StandardizedDataStructures/Index
    DataFiltersStructure/Index
