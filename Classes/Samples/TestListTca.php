<?php

namespace Causal\DirectMailUserfunc\Samples;

/**
 * This is a sample class showing how to define a user function
 * returning a list of recipients. To use it, put 'user_testList_tca->myRecipientList' as
 * itemsProcFunc value when creating a Recipient List of type "User function".
 *
 * @author      Xavier Perseguers <xavier@causal.ch>
 * @license     https://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class TestListTca
{

    /**
     * Returns a list of recipients.
     *
     * @param array $params User parameters
     * @param \DirectMailTeam\DirectMail\Module\RecipientList|\DirectMailTeam\DirectMail\Module\Dmail $pObj Parent object
     */
    public function myRecipientList(array &$params, $pObj): void
    {
        // Add tt_address #4 to the recipient list
        $params['lists']['tt_address'][] = 4;

        // Add frontend user #1 to the recipient list
        $params['lists']['fe_users'][] = 1;

        // Retrieve user parameters
        $userParameters = $params['userParams'];

        $sizeOfRecipientList = isset($userParameters['size']) ? (int)$userParameters['size'] : 2;
        for ($i = 0; $i < $sizeOfRecipientList; $i++) {
            $name = !empty($userParameters['name']) ? $userParameters['name'] : 'John Doo';
            $name .= ' #' . $i;
            $email = !empty($userParameters['email']) ? $userParameters['email'] : 'john.doo@gmail.com';
            list($username, $domain) = explode('@', $email, 2);
            $email = $username . '-' . $i . '@' . $domain;

            $params['lists']['PLAINLIST'][] = ['name' => $name, 'email' => $email];
        }
    }

    /**
     * Returns an array of field definitions for additional parameters.
     *
     * @param string $methodName
     * @return array|null TCA or null if no additional parameters are needed
     */
    public static function getWizardFields(string $methodName): ?array
    {
        $additionalParameters = [
            'columns' => [
                'size' => [
                    'label' => 'LLL:EXT:direct_mail_userfunc/Resources/Private/Language/locallang_db.xlf:myRecipientListTca.size',
                    'config' => [
                        'type' => 'input',
                        'size' => '5',
                        'max' => '5',
                        'eval' => 'int',
                        'default' => 1,
                        'range' => [
                            'lower' => 1,
                        ]
                    ]
                ],
                'name' => [
                    'label' => 'LLL:EXT:direct_mail_userfunc/Resources/Private/Language/locallang_db.xlf:myRecipientListTca.name',
                    'config' => [
                        'type' => 'input',
                        'size' => '20',
                        'eval' => 'trim',
                    ]
                ],
                'email' => [
                    'label' => 'LLL:EXT:direct_mail_userfunc/Resources/Private/Language/locallang_db.xlf:myRecipientListTca.email',
                    'config' => [
                        'type' => 'input',
                        'size' => '20',
                        'eval' => 'trim',
                    ]
                ],
            ],
            'types' => [
                '5' => [
                    'showitem' => 'size,
                        --palette--;LLL:EXT:direct_mail_userfunc/Resources/Private/Language/locallang_db.xlf:myRecipientListTca.palette.person;person'
                ]
            ],
            'palettes' => [
                'person' => [
                    'showitem' => 'name, email',
                ],
            ]
        ];

        return $additionalParameters;
    }
}
