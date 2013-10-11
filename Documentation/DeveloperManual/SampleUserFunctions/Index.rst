.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt
.. include:: Images.txt


.. _sample-user-functions:

Sample User Functions
---------------------

Two wizards are provided in directory ``samples`` of the extension. To
activate them, go to Extension Manager, click on extension Direct Mail
User Functions, tick the corresponding checkbox and click on Update
button:

|enable_samples|

Once activated, you may use ``user_testList->myRecipientList`` as
itemsProcFunc. This user function has a simple user parameter wizard
using standard JavaScript.

Another user function ``user_testList_extjs->myRecipientList`` is available. This is
basically the same user function as the previous one except that the
user parameter wizard is using ExtJS framework.
