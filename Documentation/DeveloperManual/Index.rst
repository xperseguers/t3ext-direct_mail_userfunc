.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _developer-manual:

Developer manual
================

Simplest class and method you may write to dynamically create a
recipient list.

.. code-block:: php

	class user_testList {

	    public function myRecipientList(array &$params, ux_tx_directmail_recipient_list $pObj) {
	        $params['lists']['PLAINLIST'][] = array(
	            'name' => 'John Doo',
	            'email' => 'john.doo@hotmail.com',
	        );
	        $params['lists']['PLAINLIST'][] = array(
	            'name' => 'Foo Bar',
	            'email' => 'foo.bar@yahoo.fr',
	        );
	    }

	}

If you wish to provide records from tables ``tt_address`` or ``fe_users``,
this is easily done with:

.. code-block:: php

	// Add tt_address record with uid 12 to the list
	$params['lists']['tt_address'][] = 12;

	// Add fe_users record with uid = 14 to the list
	$params['lists']['fe_users'][] = 14;

.. note::
	Your class should be properly loaded. This is typically done with an include statement in :file:`typo3conf/localconf.php`
	or with an extension and the corresponding include statement in :file:`ext_localconf.php`.

.. note::
	You class should be prefixed with ``user_`` in order to prevent TYPO3 from issuing a warning. If you create an
	extension for your user functions, we suggest using naming ``user_Tx_YourExt_Controller_SomeClass`` with file
	:file:`SomeClass.php` stored in :file:`yourExt/Classes/Controller/SomeClass.php` in order to respect as much as
	possible Extbase naming convention.


.. toctree::
	:maxdepth: 5
	:titlesonly:
	:glob:

	RegisteringTheUserFunction/Index
	AdditionalParameters/Index
	AdditionalParameters/Wizard
	AdditionalParameters/TCA
	SampleUserFunctions/Index
