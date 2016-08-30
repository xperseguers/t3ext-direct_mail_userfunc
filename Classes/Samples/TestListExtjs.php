<?php

namespace Causal\DirectMailUserfunc\Samples;

/**
 * This is a sample class showing how to define a user function
 * returning a list of recipients. To use it, put 'user_testList_extjs->myRecipientList' as
 * itemsProcFunc value when creating a Recipient List of type "User function".
 *
 * @author      Xavier Perseguers <xavier@causal.ch>
 * @license     http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class TestListExtjs
{

    /**
     * Returns a list of recipients.
     *
     * @param array $params User parameters
     * @param \DirectMailTeam\DirectMail\Module\RecipientList|\DirectMailTeam\DirectMail\Module\Dmail $pObj Parent object
     * @return array
     */
    public function myRecipientList(array &$params, $pObj)
    {
        // Add tt_address #4 to the recipient list
        $params['lists']['tt_address'][] = 4;

        // Add frontend user #1 to the recipient list
        $params['lists']['fe_users'][] = 1;

        // Retrieve user parameters
        $sizeOfRecipientList = $params['userParams'] ? $params['userParams'] : 2;
        for ($i = 0; $i < $sizeOfRecipientList; $i++) {
            $params['lists']['PLAINLIST'][] = array('name' => 'John Doo #' . $i, 'email' => 'john.doo-' . $i . '@gmail.com');
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
     * @param bool $autoJS Set to true if you wish to fully generate your own code for calling your wizard
     * @return string JavaScript code to be executed upon icon click
     */
    public function getWizard($methodName, array &$PA, &$autoJS)
    {
        $js = '';

        if ($methodName === 'myRecipientList') {
            $js = '<script type="text/javascript" src="' . \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('direct_mail_userfunc') . 'Classes/Samples/parameters.js' . '"></script>';
            $js .= '<script type="text/javascript"><!--
                var dmuf_parameters = document.' . $PA['formName'] . '[\'' . $PA['itemName'] . '\'];
                function updateParameters(params) {
                    dmuf_parameters.value = params;' .
                implode('', $PA['fieldChangeFunc']) . ';
                }
                --></script>';
            $autoJS = false;
        }

        return $js;
    }

}
