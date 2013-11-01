.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _additional-parameters:

Additional parameters
---------------------

When creating a recipient list from type user function, you have the
possibility to specify additional parameters that will be passed as a
single string arguments to the itemsProcFunc. Let's suppose the user
specify this recipient list:

.. figure:: ../../Images/itemsprocfunc.png
	:alt: itemsProcFunc

Method ``myRecipientList`` will get additional parameter "18" and will be
able to process it the way it likes:

.. code-block:: php

	function myRecipientList($params, $pObj) {
	    // Retrieve user parameters (will get "18")
	    $sizeOfRecipientList = $params['userParams'];

	    // snip
	}
