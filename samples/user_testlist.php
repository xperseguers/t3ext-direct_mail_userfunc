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
	 * @param $params
	 * @param $pObj
	 * @return array
	 */
	function myRecipientList($params, $pObj) {
		//$pageTS = $params['TSconfig'];
		$params['PLAINLIST'][] = array('name' => 'John Doo', 'email' => 'john.doo@hotmail.com');
		$params['PLAINLIST'][] = array('name' => 'Foo Bar', 'email' => 'foo.bar@yahoo.fr');
	}

}

?>