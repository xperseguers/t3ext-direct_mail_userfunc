.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


.. _tca-additional-parameters:

Using TCA for additional parameters
-----------------------------------

The simple JavaScript wizard presented in previous section is fine as long as you want to store a single additional
parameter, e.g., a number or some string. But when you wish to store some complex settings such as various options or
business record references, you will have to create an ExtJS-based wizard which involves quite some work and still has
the drawback that you are on your own to serialize/deserialize your configuration options in the additional parameters
text area. Besides, the serialized configuration is shown in clear in the text area.

Fortunately there is an alternative. This extension lets you define custom TCA to be used for additional parameters.
Once defined, this custom TCA will *replace* the text area with any field you want:

.. figure:: ../../Images/tca.png
	:alt: TCA-based wizard

Upon saving, this extension will take care of automatically and transparently serializing your custom fields and their
corresponding values into the standard ``tx_directmailuserfunc_params`` database field (the one that is mapped to the
standard text area) as JSON. Please note however that you will have to unserialize it manually within your itemsProcFunc
method, just as when dealing with JavaScript additional parameter wizards.

In order to replace the text area, you have to write a method ``getWizardFields`` in your class that returns an array
of table configuration (TCA):

.. code-block:: php

	public function getWizardFields($methodName, $pObj) {
	    return array(
	        'columns' => array(
	            'field1' => array(
	                // snip
	            ),
	            'field2' => array(
	                // snip
	            ),
	        ),
	        'types' => array(
	            '5' => array(
	                'showitem' => 'field1, field2, ...'
	            )
	        ),
	        // If needed:
	        'palettes' => array(
	            // snip
	        ),
	    );
	}

Please refer to :ref:`['columns'] section in TCA reference <t3tca:columns>` for information on how to define your custom
fields.

.. note::
	Type number "5" corresponds to a list of recipients defined as a user function, what we are dealing with here.

.. hint::
	Method ``getWizardFields`` may return ``NULL`` instead of an array. This has the effect of simply hiding the
	additional parameters text area.
