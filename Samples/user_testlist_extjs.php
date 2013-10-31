<?php

/**
 * This is a sample class showing how to define a user function
 * returning a list of recipients. To use it, put 'user_testList_extjs->myRecipientList' as
 * itemsProcFunc value when creating a Recipient List of type "User function".
 *
 * $Id$
 */
class user_testList_extjs {

	/**
	 * Returns a list of recipients.
	 *
	 * @param array $params User parameters
	 * @param t3lib_TCEforms $pObj Parent object
	 * @return array
	 */
	public function myRecipientList($params, $pObj) {
		// Add tt_address #4 to the recipient list
		$params['lists']['tt_address'][] = 4;

		// Add frontend user #1 to the recipient list
		$params['lists']['fe_users'][] = 1;

		// Retrieve user parameters
		$sizeOfRecipientList = $params['userParams'] ? $params['userParams'] : 2;
		for ($i = 0; $i < $sizeOfRecipientList; $i++) {
			$params['lists']['PLAINLIST'][] = array('name' => 'John Doo #' . $i, 'email' => 'john.doo-' . $i . '@hotmail.com');
		}
	}

	/**
	 * Returns a JavaScript wizard that lets user choose additional parameters to be passed
	 * during the itemsProcFunc call. The wizard should store any new parameters back to
	 * $PA[$'formName']['itemName'] upon closing and do not forget to call $PA['fieldChangeFunc']
	 * in order to tell TCEforms that the value is updated.
	 *
	 * @param string $methodName
	 * @param array $PA TCA configuration passed by reference
	 * @param t3lib_TCEforms $pObj Parent object
	 * @param boolean $autoJS Set to TRUE if you wish to fully generate your own code for calling your wizard
	 * @return string JavaScript code to be executed upon icon click
	 */
	public function getWizard($methodName, &$PA, $pObj, &$autoJS) {
		$js = '';

		if ($methodName === 'myRecipientList') {
			$js = '<script type="text/javascript" src="' . t3lib_extMgm::extRelPath('direct_mail_userfunc') . 'Samples/parameters.js' . '"></script>';
			$js .= '<script type="text/javascript"><!--
				var dmuf_parameters = document.' . $PA['formName'] . '[\'' . $PA['itemName'] . '\'];
				function updateParameters(params) {
					dmuf_parameters.value = params;'.
					implode('', $PA['fieldChangeFunc']) .';
				}
				--></script>';
			$autoJS = FALSE;
		}

		return $js;
	}

}
