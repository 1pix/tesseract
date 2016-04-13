.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _developers-guide-api-controller:

Controller
^^^^^^^^^^

Each controller will probably have very different logics. There are however
some minimal requirements represented by two different PHP interfaces.

When setting up relationships between components a service exists to "link back"
from a Consumer to a Provider. Let's take the example of the Template Display Consumer.
It provides an interface for mapping fields retrieved by a related Provider to markers in a HTML template.
To be able to achieve that from within the TYPO3 CMS BE, Template Display must be "put in touch"
with a Provider to which it is related via a controller. The controller service exists for that purpose.

It implements the following interface (:code:`\Tesseract\Tesseract\Component\DataControllerInterface`):

loadData()
  This method takes whatever information is relevant to identify the controller and performs any appropriate action.

getRelatedProvider()
  This method looks for the Data Consumer that is managed by that particular controller instance
  and returns it as a Data Consumer object.

The "other side" of the process is when the controller prepares for output.
A different interface must be implemented for that purprose
(:code:`\Tesseract\Tesseract\Component\DataControllerOutputInterface`):

getPrefixId()
  This method is expected to return a key uniquely identifying the controller.
  In the fronted this would typically take the form of "tx_extensionname" to be used in prefixing GET/POST vars.

addMessage()
  Add a message to the debugging message queue.

getMessageQueue()
  Get all the messages in the debugging message queue.

setDebug()
  Set the debug flag of the controller (boolean value)

getDebug()
  Get the current value of the controller's debug flag

getControllerData()
  Get all the data related to the controller (in the case of "displaycontroller", for example,
  this will be the corresponding tt_content record). Available since "tesseract" version 1.7.0.

getControllerDataValue()
  Get a specific value from the controller data, as specified by the parameter passed.
  Available since "tesseract" version 1.7.0.

getControllerArguments()
  Get all the arguments related to the controller (in the case of "displaycontroller",
  for example, this will be the plugin's piVars). Available since "tesseract" version 1.7.0.

getControllerArgumentValue()
  Get a specific value from the controller arguments, as specified by the parameter passed.
  Available since "tesseract" version 1.7.0.

:code:`\Tesseract\Tesseract\Component\DataControllerOutputInterface::getPrefixId()` is used
– for example – by extension "templatedisplay" while assembling links with query variables.
The Display Controller extension returns "tx_displaycontroller" as a prefix,
so "templatedisplay" will use the common TYPO3 CMS syntax:

.. code-block:: php

	tx_displaycontroller[foo]

when creating a link with query variables. This ensures that the controller
knows how to retrieve variables that are meaningful for itself.
In the case of the "displaycontroller", all such properly constructed variables
will be available in the well-known :code:`piVars` array.

Each controller is expected to manage an internal message queue for storing debugging messages.
Any Tesseract component can add a message to that queue by referring to its controller instance.
Example:

.. code-block:: php

	$this->controller->addMessage(
		  'extension_key',
		  'This is the debug message',
		  'Title of the message (optional)',
		  \TYPO3\CMS\Core\Messaging\FlashMessage::OK,
		  array('foo', 'bar')
	);

The controller should store such messages only if some debugging mode is active.
It is then expected to also display or store these messages in some way to help debugging.

If you design a controller based on the traditional plugin architecture,
you may inherit from base class :code:`\Tesseract\Tesseract\Frontend\PluginControllerBase`.
