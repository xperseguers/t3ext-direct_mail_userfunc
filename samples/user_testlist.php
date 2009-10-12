<?php

/**
 * This is a sample class showing how to define a user function
 * returning a list of recipients. To use it, put 'user_testList->myRecipientList' as
 * itemsProcFunc value when creating a Recipient List of type "User function".
 *
 * $Id$
 */
class user_testList {

	/**
	 * Returns a list of recipients.
	 * 
	 * @param array $params
	 * @param $pObj
	 * @return array
	 */
	public function myRecipientList($params, $pObj) {
			// Retrieve user parameters
		$sizeOfRecipientList = $params['userParams'] ? $params['userParams'] : 2; 

		for ($i = 0; $i < $sizeOfRecipientList; $i++) {
			$params['PLAINLIST'][] = array('name' => 'John Doo #' . $i, 'email' => 'john.doo-' . $i . '@hotmail.com');
		}
	}

	/**
	 * Returns a JavaScript wizard that lets user choose additional parameters to be passed
	 * during the itemsProcFunc call. The wizard should store any new parameters back to
	 * $formName[$paramsFieldName] upon closing. 
	 * 
	 * @param string $itemsProcFunc 
	 * @param string $params previously stored parameters
	 * @param string $formName
	 * @param string $paramsFieldName
	 * @return string JavaScript code to be executed upon icon click
	 */
	public function getWizard($itemsProcFunc, $params, $formName, $paramsFieldName) {
		$js = '';

		if ($itemsProcFunc === 'myRecipientList') {
			if (!$params) {
				$params = 2;
			}

				// Show a standard javascript prompt and assign result to the parameters field
				// This information will be saved with form and available in myRecipientList
			$js = '
				var r = prompt("How many items do you want in your list?", "' . $params . '");
				if (r != null) {
					document.' . $formName . '[\'' . $paramsFieldName . '\'].value = parseInt(r);
					alert("Do not forget to save your changes!");
				}
			';
		}

		return $js;
	}

}

?>