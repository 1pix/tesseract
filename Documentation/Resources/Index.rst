.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _currently-available-resources:

Currently available resources
=============================

Here is a list of the currently available Tesseract components.


.. _currently-available-resources-controllers:

Controllers
-----------


.. _currently-available-resources-controllers-display-controller:

Display Controller (displaycontroller)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

The Display Controller is a controller that acts as FE plug-in.
It thus coordinates the work of the other components to produce output
that is integrated into the TYPO3 CMS page rendering process.
The Display Controller defines relationships between the various components.
This is described in details in the :ref:`Display Controller manual <displaycontroller:start>`,
but here's a short overview to relate this to the general schema shown above.

The Display Controller refers to one Data Consumer for the display itself.
It also refers to a Data Provider that feeds the Data Consumer.
This provider is called "Primary Provider". It can also refer to a so-called
"Secondary Provider" which feeds into the Primary Provider.
Each provider can be linked to a Data Filter.


.. _currently-available-resources-data-providers:

Data Providers
--------------


.. _currently-available-resources-data-providers-dataquery:

Data Query (dataquery)
^^^^^^^^^^^^^^^^^^^^^^

Data Query is a SQL-based Data Provider. This means it relies on SQL queries
to select data that is then transformed into a recordset-type SDS.
Data Query hides all the handling of the TYPO3 CMS-specific fields
(deleted flag and enable fields) and also transparently handles language and
workspace overlays.

It can receive filtering information from a Data Filter,
which is transformed into SQL syntax.


.. _currently-available-resources-data-providers-googlequery:

Google Query (googlequery)
^^^^^^^^^^^^^^^^^^^^^^^^^^

Google Query is a Data Provider based on Google Search solutions.
It actually contains two providers, one returning recordset-type SDS
(which acts as a Primary Provider with the Display Controller)
and one returning idlist-type SDS (which acts as a Secondary Provider with the Display Controller).


.. _currently-available-resources-data-consumers:

Data Consumers
--------------


.. _currently-available-resources-data-consumers-templatedisplay:

Template-based display (templatedisplay)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

This extension provides a way to transform the data returned by Data Providers into HTML
using templates based on TYPO3 CMS's famous `###` marker syntax. Thanks to a nice visual interface,
it's possible to simply click on a marker and match it to a field from the list of available data.
Local TypoScript processing can then be added for rendering.


.. _currently-available-resources-data-consumers-fluidbased-display:

Fluid-based display (fluiddisplay)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

This extensions makes it possible to use the Fluid templating engine for rendering.
This makes it possible to benefit from all the power and features of Fluid,
plus the numerous view helpers developed by the community.


.. _currently-available-resources-data-consumers-phpbased-display-phpdisplay:

PHP-based display (phpdisplay)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

For even more flexibility, this extension makes it possible to use raw PHP for rendering.
Useful in special cases where none of the above Data Consumer are enough.


.. _currently-available-resources-data-filters:

Data Filters
------------


.. _currently-available-resources-data-filters-datafilter:

Data Filter (datafilter)
^^^^^^^^^^^^^^^^^^^^^^^^

The Data Filter extension is currently the only implementation of the Data Filter concept.
It is a very flexible tool allowing to pick data from a variety of sources
(in particular GET/POST variables, but also contextual values set in TypoScript
or results from some common PHP functions like `date()`) and set it to be matched
against fields used by Data Providers, so as to restrict the records that those tools return.

It also handles sorting (field and order) and limit and offset parameters.


.. _currently-available-resources-utilities:

Utilities
---------


.. _currently-available-resources-utilities-tesseract:

Tesseract (tesseract)
^^^^^^^^^^^^^^^^^^^^^

This extension is the basic brick of the Tesseract architecture.
On top of this general documentation, it provides TYPO3 CMS services
for each of component types used by Tesseract (controller, data provider,
data consumer, data filter), PHP interfaces for defining the API
and some utility classes.


.. _currently-available-resources-utilities-overlays:

Improved Overlays API (overlays)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

This extension is a tool box designed to simplify work with language overlays.
On the one hand it provides very general methods which make it easy to retrieve
properly overlaid records. On the other hand it also provides a number of
very basic methods that handle such tasks as assembling the proper
language fields conditions in a SQL statement, based on TCA definitions.


.. _currently-available-resources-utilities-expressions:

Generic Expression Parser (expressions)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

This extension provides a library inspired by TypoScript's getText function.
It makes it possible to retrieve values from a variety of sources
with a simple syntax and provides a simple API for parsing strings
containing such expressions. Retrieved values can also be post-processed by functions,
which make it possible, for example, to quote strings tso that they are safe to use inside a SQL query.

The expression parser is at the heart of the Data Filter extension.
It is also used by several other Tesseract components.


.. _currently-available-resources-utilities-context:

Contexts (context)
^^^^^^^^^^^^^^^^^^

One major aspect of Tesseract is to be able to reuse components in various places
of a given web site. In particular Data Providers, which often to query the same data
but with different parameters. This is possible thanks to Data Filters.
Contexts take this one step further, by making it possible to define values in TypoScript
which can be retrieved easily by Data Filters. This allows to have a given Data Provider
be the same for a whole site and vary the content it returns just thanks to some
TypoScript values that vary along the page tree.
