<?php
/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with TYPO3 source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * Various ItemsProcFunc utility methods.
 *
 * @category    Utility
 * @package     direct_mail_userfunc
 * @author      Xavier Perseguers <xavier@causal.ch>
 * @copyright   2013-2015 Causal Sàrl
 * @license     http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class Tx_DirectMailUserfunc_Utility_ItemsProcFunc
{

    /**
     * Returns TRUE if $itemsProcFunc has a method getWizard().
     *
     * @param string $itemsProcFunc
     * @return boolean
     */
    static public function hasWizard($itemsProcFunc)
    {
        list($className, $methodName) = explode('->', $itemsProcFunc);
        $ret = FALSE;
        if (!empty($itemsProcFunc) && static::isMethodValid($itemsProcFunc)) {
            $ret = method_exists($className, 'getWizard');
        }
        return $ret;
    }

    /**
     * Invokes method getWizard() from $itemsProcFunc.
     *
     * @param string $itemsProcFunc
     * @param array $PA
     * @param boolean $autoJS
     * @param t3lib_TCEforms|\TYPO3\CMS\Backend\Form\FormEngine $pObj (deprecated)
     * @return string
     * @throws RuntimeException
     */
    static public function callWizard($itemsProcFunc, array &$PA, &$autoJS, /* t3lib_TCEforms */
                                      $pObj)
    {
        if (!static::hasWizard($itemsProcFunc)) {
            throw new RuntimeException($itemsProcFunc . ' has no method getWizard', 1383559688);
        }

        list($className, $methodName) = explode('->', $itemsProcFunc);
        $wizardJS = trim(call_user_func_array(
            array($className, 'getWizard'),
            array($methodName, &$PA, $pObj, &$autoJS)
        ));
        return $wizardJS;
    }

    /**
     * Returns TRUE if $itemsProcFunc has a method getWizardFields().
     *
     * @param string $itemsProcFunc
     * @return boolean
     */
    static public function hasWizardFields($itemsProcFunc)
    {
        list($className, $methodName) = explode('->', $itemsProcFunc);
        $ret = FALSE;
        if (!empty($itemsProcFunc) && static::isMethodValid($itemsProcFunc)) {
            $ret = method_exists($className, 'getWizardFields');
        }
        return $ret;
    }

    /**
     * Invokes method getWizardFields from $itemsProcFunc.
     *
     * @param string $itemsProcFunc
     * @return array|NULL
     * @throws RuntimeException
     */
    static public function callWizardFields($itemsProcFunc)
    {
        if (!static::hasWizardFields($itemsProcFunc)) {
            throw new RuntimeException($itemsProcFunc . ' has no method getWizardFields', 1383559998);
        }

        list($className, $methodName) = explode('->', $itemsProcFunc);
        $wizardFields = call_user_func_array(
            array($className, 'getWizardFields'),
            array($methodName)
        );
        return $wizardFields;
    }

    /**
     * Checks whether the class part of a given itemsProcFunc definition is valid.
     *
     * @param string $itemsProcFunc
     * @return boolean
     */
    static public function isClassValid($itemsProcFunc)
    {
        list($className, $methodName) = explode('->', $itemsProcFunc);

        if (!empty($className) && class_exists($className)) {
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Checks whether the method part of a given itemsProcFunc definition is valid.
     *
     * @param string $itemsProcFunc
     * @return boolean
     * @api
     */
    static public function isMethodValid($itemsProcFunc)
    {
        if (!static::isClassValid($itemsProcFunc)) {
            return FALSE;
        }

        list($className, $methodName) = explode('->', $itemsProcFunc);

        if (!empty($methodName) && method_exists($className, $methodName)) {
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Encodes user parameters in a database record.
     *
     * @param array $row
     * @param array $values
     * @return void
     */
    static public function encodeUserParameters(array &$row, array $values)
    {
        $row['tx_directmailuserfunc_params'] = json_encode($values);
    }

    /**
     * Decodes user parameters from a database record.
     *
     * @param array $row
     * @return array
     */
    static public function decodeUserParameters(array $row)
    {
        $values = !empty($row['tx_directmailuserfunc_params'])
            ? json_decode($row['tx_directmailuserfunc_params'], TRUE)
            : array();
        if (!is_array($values)) {
            $values = array();
        }

        return $values;
    }

}
