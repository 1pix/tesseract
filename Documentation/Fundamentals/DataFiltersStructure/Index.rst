.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _fundamentals-data-filters-structure:

Data Filters Structure
----------------------

Data Filters have their own standard structure. This structure makes it possible
to define filters for the data that's going to be provided by the Data Providers.
The Data Provider is expected to be able to understand such a structure and act on it.
On top of true filters, the Data Filter can also be used to pass on data related to
the ordering of the results or limiting the number of results.

Here's how such a structure looks like:

+-----------------+---------------------------------------------------------------------------------------------------------------------------+
| filters         | +---+-----------------------------------------------------------------------------------------------------------------+   |
|                 | | 0 | +------------+------------------------------------------------------------------------------------------------+ |   |
|                 | |   | | table      | Table to which the filter applies                                                              | |   |
|                 | |   | +------------+------------------------------------------------------------------------------------------------+ |   |
|                 | |   | | field      | Field to which the filter applies                                                              | |   |
|                 | |   | +------------+------------------------------------------------------------------------------------------------+ |   |
|                 | |   | | conditions | +---+--------------------------------------------------------------------------------------+   | |   |
|                 | |   | |            | | 0 | +----------+-----------------------------------------------------------------------+ |   | |   |
|                 | |   | |            | |   | | operator | Operator to use for the test. Allowed values are: =, !=, >, >=, <, <= | |   | |   |
|                 | |   | |            | |   | +----------+-----------------------------------------------------------------------+ |   | |   |
|                 | |   | |            | |   | | value    | Value to use for the test                                             | |   | |   |
|                 | |   | |            | |   | +----------+-----------------------------------------------------------------------+ |   | |   |
|                 | |   | |            | |   | | negate   | TRUE or FALSE                                                         | |   | |   |
|                 | |   | |            | |   | +----------+-----------------------------------------------------------------------+ |   | |   |
|                 | |   | |            | +---+--------------------------------------------------------------------------------------+   | |   |
|                 | |   | |            | | 1 | ...                                                                                  |   | |   |
|                 | |   | |            | +---+--------------------------------------------------------------------------------------+   | |   |
|                 | |   | +------------+------------------------------------------------------------------------------------------------+ |   |
|                 | |   | | main       | True if the condition should be applied in the main condition, false otherwise                 | |   |
|                 | |   | +------------+------------------------------------------------------------------------------------------------+ |   |
|                 | |   | | void       | True if the condition should be applied at all, false otherwise                                | |   |
|                 | |   | |            | (see the :ref:`Data Filter manual <datafilter:user-filter-configuration-extra>` for            | |   |
|                 | |   | |            | a discussion on the usefulness of this kind of conditions)                                     | |   |
|                 | |   | +------------+------------------------------------------------------------------------------------------------+ |   |
|                 | |   | | string     | Should contain the original filter information, untransformed (this can be used for debugging) | |   |
|                 | |   | +------------+------------------------------------------------------------------------------------------------+ |   |
|                 | +---+-----------------------------------------------------------------------------------------------------------------+   |
|                 | | 1 | ...                                                                                                             |   |
|                 | +---+-----------------------------------------------------------------------------------------------------------------+   |
+-----------------+---------------------------------------------------------------------------------------------------------------------------+
| logicalOperator | Logical operator used to link all filters together (AND/OR)                                                               |
+-----------------+---------------------------------------------------------------------------------------------------------------------------+
| limit           | +---------+-------------------------------------------------------------------------------------------------------------+ |
|                 | | max     | Maximum number of records to retrieve                                                                       | |
|                 | +---------+-------------------------------------------------------------------------------------------------------------+ |
|                 | | offset  | Number of records to shift from 0 as a multiple of :code:`max` (i.e. :code:`shift` is :code:`max * offset`) | |
|                 | +---------+-------------------------------------------------------------------------------------------------------------+ |
|                 | | pointer | Direct pointer to a given record number (i.e. if :code:`pointer = 54`, jump to the 54th record)             | |
|                 | +---------+-------------------------------------------------------------------------------------------------------------+ |
+-----------------+---------------------------------------------------------------------------------------------------------------------------+
| orderby         | +---+---------------------------------------------------------------------------------------------------------------+     |
|                 | | 0 | +--------+--------------------------------------------------------------------------------------------------+ |     |
|                 | |   | | table  | Name of the table to sort                                                                        | |     |
|                 | |   | +--------+--------------------------------------------------------------------------------------------------+ |     |
|                 | |   | | field  | Name of the field to sort on                                                                     | |     |
|                 | |   | +--------+--------------------------------------------------------------------------------------------------+ |     |
|                 | |   | | order  | Direction of the ordering (typically :code:`asc` or :code:`desc`)                                | |     |
|                 | |   | +--------+--------------------------------------------------------------------------------------------------+ |     |
|                 | |   | | engine | Where the ordering should take place, leave blank for delegating decision to the Data Provider.  | |     |
|                 | |   | |        |                                                                                                  | |     |
|                 | |   | |        | Possible values are:                                                                             | |     |
|                 | |   | |        |                                                                                                  | |     |
|                 | |   | |        | source                                                                                           | |     |
|                 | |   | |        |   the ordering should be applied during the request to the data source used                      | |     |
|                 | |   | |        |   by the provider (e.g. the ORDER BY statement for a SQL-based provider).                        | |     |
|                 | |   | |        |                                                                                                  | |     |
|                 | |   | |        | provider                                                                                         | |     |
|                 | |   | |        |   the ordering should be performed by the Data Provider itself, after it has                     | |     |
|                 | |   | |        |   retrieved the data from the source. This is important in particular when querying the          | |     |
|                 | |   | |        |   TYPO3 database with its translation overlays. In such a case it is often necessary to          | |     |
|                 | |   | |        |   sort after the overlays have been applied. A Data Provider such as "Data Query"                | |     |
|                 | |   | |        |   tries to be smart and guess this. It will automatically sort text fields provider-side         | |     |
|                 | |   | |        |   and number or date fields source-side. The "engine" property is then useful to                 | |     |
|                 | |   | |        |   change this behavior.                                                                          | |     |
|                 | |   | +--------+--------------------------------------------------------------------------------------------------+ |     |
|                 | +---+---------------------------------------------------------------------------------------------------------------+     |
|                 | | 1 | ...                                                                                                           |     |
|                 | +---+---------------------------------------------------------------------------------------------------------------+     |
+-----------------+---------------------------------------------------------------------------------------------------------------------------+

Custom properties may be added by extensions (e.g. the Data Query extension adds a "raw SQL" field).


.. _fundamentals-data-filters-structure-special-values:

Special values
^^^^^^^^^^^^^^

A number of special values exist for the values found in conditions.
Any implementation of the Data Filter pattern should be able to handle those values,
if relevant. Special values begin with a backslash (\\).
They are expected to be handled correctly by the Data Filter (if needed)
and to be interpreted by the Data Provider. The table below lists the base special values
that should be recognized and how they should be handled by the Data Provider:

============== ================================================================ ===========================================================
Name           Data Filter                                                      Data Provider
-------------- ---------------------------------------------------------------- -----------------------------------------------------------
:code:`\empty` Depending on the Data Filter implementation, it may not          This value should probably be interpreted as an empty
               be easy to distinguish between an unset value and an             string, or whatever is equivalent for each particular Data
               empty one. The unset value should be ignored whereas             Provider.
               the empty one should be equivalent to an empty string
               (or anything similar given the context). This special value
               should be used to explicitly mean an empty value.
-------------- ---------------------------------------------------------------- -----------------------------------------------------------
:code:`\null`  There's the same problem as with :code:`\empty`, to distinguish  This value must be interpreted as a null or whatever is
               between an unset value and a real test against null.             equivalent for each particular Data Provider.
-------------- ---------------------------------------------------------------- -----------------------------------------------------------
:code:`\all`   In some particular cases, it may be convenient to have a         This value must be interpreted as meaning that all values
               kind of wildcard value that means that the condition is          for the given condition must be accepted. This probably
               actually not really a condition but accepts all values.          means that the condition must simply be ignored by the
               This is the purpose of the :code:`\all` keyword.                 Data Provider, but it will depend on specific
                                                                                implementations (it could be equivalent to :code:`*`
                                                                                in some situations, for example).
============== ================================================================ ===========================================================


.. _fundamentals-data-filters-structure-explanations:

Explanations
^^^^^^^^^^^^

A Data Filter's result is passed on to a Data Provider. It is up to each Data Provider
to interpret the information it receives from the Data Filter. The Data Query, for example,
transforms the Data Filter information into SQL statements. So the words "table" and "field"
above must be considered from a general point of view, where they might not necessarily
mean a database table and a column of that database table.

The same goes for the "main condition" mentioned above. Whatever the Data Provider does,
it has to interpret all the conditions of the filter. When interpreted into SQL,
conditions could either go to the WHERE clause (the "main condition" in this case)
or to the ON clause of the relevant JOINs. The "main" flag is an indication to the Data Provider
that it should apply this particular condition to the "main condition" (e.g. the WHERE clause)
if it makes such a difference at all.

Note that wherever a "table" property exists, it may be empty. It is up to the Data Provider
to know what to do in such a case. For example, it should know which is the main table
it is querying and assume that such a filter applies to that table.
