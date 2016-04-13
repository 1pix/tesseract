.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _fundamentals-standardized-data-structures:

Standardized data structures (SDS)
----------------------------------

Two SDS are defined and in use for now.


.. _fundamentals-standardized-data-structures-full-recordset-sds:

Full Recordset SDS (recordset)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

The full recordset SDS is basically designed to return the record set resulting
from a database query with added information and a (optional) recursive structure for joined tables.
Obviously other sources than a database query can also return such a SDS.

An example is the best way to understand how this SDS is structured.
Let's say you perform the following query using Data Query:

.. code:: sql

    SELECT pages.uid, pages.title, tt_content.uid, tt_content.header FROM pages
    LEFT JOIN tt_content ON tt_content.pid = pages.uid

In a usual situation you would get your result in a structure like this:

+---+----------------------+------------------------+---------------------------+------------------------------+
| 0 | (value of pages.uid) | (value of pages.title) | (value of tt_content.uid) | (value of tt_content.header) |
+---+----------------------+------------------------+---------------------------+------------------------------+
| 1 | ...                  |                        |                           |                              |
+---+----------------------+------------------------+---------------------------+------------------------------+

The full recordset SDS instead provides you with is a PHP array corresponding to the list of pages retrieved,
where each page has a subtable containing its related content elements. The structure will look like this:

+------------+-------------------------------------------------------------------------------------------------------------------------+
| name       | pages                                                                                                                   |
+------------+-------------------------------------------------------------------------------------------------------------------------+
| count      | Number of records returned (for table pages, not counting joined records)                                               |
+------------+-------------------------------------------------------------------------------------------------------------------------+
| totalCount | Total number of records without limits applied (except if limit was hard-coded in SQL query)                            |
+------------+-------------------------------------------------------------------------------------------------------------------------+
| uidList    | Comma-separated list of uid's, usable directly by TYPO3                                                                 |
+------------+-------------------------------------------------------------------------------------------------------------------------+
| header     | +--------+---------------------+                                                                                        |
|            | | uid    | +-------+---------+ |                                                                                        |
|            | |        | | label | uid     | |                                                                                        |
|            | |        | +-------+---------+ |                                                                                        |
|            | +--------+---------------------+                                                                                        |
|            | | header | +-------+---------+ |                                                                                        |
|            | |        | | label | Header: | |                                                                                        |
|            | |        | +-------+---------+ |                                                                                        |
|            | +--------+---------------------+                                                                                        |
+------------+-------------------------------------------------------------------------------------------------------------------------+
| filter     | Full Data Filter structure (see below for details about that structure)                                                 |
|            |                                                                                                                         |
|            | Note that this was introduced at a later point, so it may not be available on older versions of Tesseract components.   |
+------------+-------------------------------------------------------------------------------------------------------------------------+
| records    | +---+-----------------------------------------------------------------------------------------------------------------+ |
|            | | 0 | +----------------+--------------------------------------------------------------------------------------------+ | |
|            | |   | | uid            | (value)                                                                                    | | |
|            | |   | +----------------+--------------------------------------------------------------------------------------------+ | |
|            | |   | | title          | (value)                                                                                    | | |
|            | |   | +----------------+--------------------------------------------------------------------------------------------+ | |
|            | |   | | __substructure | +------------+---------------------------------------------------------------------------+ | | |
|            | |   | |                | | tt_content | +---------+-------------------------------------------------------------+ | | | |
|            | |   | |                | |            | | name    | tt_content                                                  | | | | |
|            | |   | |                | |            | +---------+-------------------------------------------------------------+ | | | |
|            | |   | |                | |            | | count   | Number of records returned (for table tt_content)           | | | | |
|            | |   | |                | |            | +---------+-------------------------------------------------------------+ | | | |
|            | |   | |                | |            | | uidList | Comma-separated list of uid's, usable directly by TYPO3 CMS | | | | |
|            | |   | |                | |            | +---------+-------------------------------------------------------------+ | | | |
|            | |   | |                | |            | | header  | +--------+---------------------+                            | | | | |
|            | |   | |                | |            | |         | | uid    | +-------+---------+ |                            | | | | |
|            | |   | |                | |            | |         | |        | | label | uid     | |                            | | | | |
|            | |   | |                | |            | |         | |        | +-------+---------+ |                            | | | | |
|            | |   | |                | |            | |         | +--------+---------------------+                            | | | | |
|            | |   | |                | |            | |         | | header | +-------+---------+ |                            | | | | |
|            | |   | |                | |            | |         | |        | | label | Header: | |                            | | | | |
|            | |   | |                | |            | |         | |        | +-------+---------+ |                            | | | | |
|            | |   | |                | |            | |         | +--------+---------------------+                            | | | | |
|            | |   | |                | |            | +---------+-------------------------------------------------------------+ | | | |
|            | |   | |                | |            | | records | +---+----------------------+                                | | | | |
|            | |   | |                | |            | |         | | 0 | +--------+---------+ |                                | | | | |
|            | |   | |                | |            | |         | |   | | uid    | (value) | |                                | | | | |
|            | |   | |                | |            | |         | |   | +--------+---------+ |                                | | | | |
|            | |   | |                | |            | |         | |   | | header | (value) | |                                | | | | |
|            | |   | |                | |            | |         | |   | +--------+---------+ |                                | | | | |
|            | |   | |                | |            | |         | +---+----------------------+                                | | | | |
|            | |   | |                | |            | |         | | 1 | ...                  |                                | | | | |
|            | |   | |                | |            | |         | +---+----------------------+                                | | | | |
|            | |   | |                | |            | |         | | 2 | ...                  |                                | | | | |
|            | |   | |                | |            | |         | +---+----------------------+                                | | | | |
|            | |   | |                | |            | +---------+-------------------------------------------------------------+ | | | |
|            | |   | |                | +------------+---------------------------------------------------------------------------+ | | |
|            | |   | +----------------+--------------------------------------------------------------------------------------------+ | |
|            | +---+-----------------------------------------------------------------------------------------------------------------+ |
|            | | 1 | ...                                                                                                             | |
|            | +---+-----------------------------------------------------------------------------------------------------------------+ |
+------------+-------------------------------------------------------------------------------------------------------------------------+

As you can see, the data from the main table (the one in the FROM statement) and the data from each of the subtables
(the ones in the JOIN statements) are separated for ease of use. Furthermore the "pages." or "tt_content."
prefix that was necessary for disambiguating the fields in the SELECT statement are removed.
Again this makes it easier to use. It also becomes possible to add data like a count of all records
or a comma-separated list of all primary keys, which could be quite convenient to manipulate in TypoScript
during the display.

Once inside records additional fields can be added but it is advised to prefix them with `__` (two underscores)
to avoid overwriting a field from the database. The prime example for such fields is the one containing the subtable,
which is called `__substructure`. Any other field can be imagined, although none are currently used.

The structure for a subtable is absolutely identical to the data for the main table.
There can be any number of subtables for a given record and any level of recursion is possible.
How many recursion levels can be prepared depends on the capabilities of the specific Data Provider.
Whether all the levels can be used or not depends on the specific Data Consumer.
The name of each subtable is used as associative index in the array of subtables.


.. _fundamentals-standardized-data-structures-list-primary-keys-sds:

List of primary keys SDS (idlist)
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

The idlist SDS is a simpler structure which is basically designed to return a list of primary keys.
However these keys can be related to different tables. The structure is schematically described below:

================ ========================================================================================================================================
uniqueTable      Name of a table if all primary keys come from the same table, empty otherwise
---------------- ----------------------------------------------------------------------------------------------------------------------------------------
uidList          Comma-separated list of all primary keys
---------------- ----------------------------------------------------------------------------------------------------------------------------------------
uidListWithTable Comma-separated list of all primary keys including table names (à la RECORDS cObj). Example: pages_12,tt_content_23,tt_address_58
---------------- ----------------------------------------------------------------------------------------------------------------------------------------
count            Number of records returned with limits applied
---------------- ----------------------------------------------------------------------------------------------------------------------------------------
totalCount       Total number of records without limits applied
---------------- ----------------------------------------------------------------------------------------------------------------------------------------
filter           Full Data Filter structure (see below for details about that structure)

                 Note that this was introduced at a later point, so it may not be available on older versions of Tesseract components.
================ ========================================================================================================================================
