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

namespace Causal\DirectMailUserfunc\Controller;

use Causal\DirectMailUserfunc\Utility\ItemsProcFunc;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * This class encapsulates display of a user wizard.
 *
 * @category    Controller
 * @package     direct_mail_userfunc
 * @author      Xavier Perseguers <xavier@causal.ch>
 * @copyright   2012-2018 Causal Sàrl
 * @license     https://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class Wizard
{

    /**
     * Default constructor.
     */
    public function __construct()
    {
        $GLOBALS['LANG']->includeLLFile('EXT:direct_mail_userfunc/Resources/Private/Language/locallang_tca.xlf');
    }

    /**
     * Returns code to show whether the itemsProcFunc definition is valid.
     *
     * @param array $PA TCA configuration passed by reference
     * @param \TYPO3\CMS\Backend\Form\FormEngine|\TYPO3\CMS\Backend\Form\Element\InputTextElement $pObj Parent object
     * @return string HTML snippet to be put after the itemsProcFunc field
     */
    public function itemsprocfunc_procWizard(array &$PA, $pObj)
    {
        $itemsProcFunc = $PA['row']['tx_directmailuserfunc_itemsprocfunc'];
        if (!$itemsProcFunc) {
            // Show the required icon
            $PA['item'] = static::getIcon('gfx/required_h.gif') . $PA['item'];
        }

        // Show the user function provider selector
        static::addUserFunctionProviders($PA);

        if (!$itemsProcFunc) {
            return;
        } elseif (ItemsProcFunc::isMethodValid($itemsProcFunc)) {

            $this->appendItemContent($PA, static::getIcon('gfx/icon_ok.gif'));
        } elseif (!ItemsProcFunc::isClassValid($itemsProcFunc)) {
            $this->appendItemContent($PA, static::getIcon('gfx/icon_warning.gif') . ' ' . $GLOBALS['LANG']->getLL('wizard.itemsProcFunc.invalidClass'));
        } else {
            $this->appendItemContent($PA, static::getIcon('gfx/icon_warning.gif') . ' ' . $GLOBALS['LANG']->getLL('wizard.itemsProcFunc.invalidMethod'));
        }
    }

    /**
     * Appends some content to the PA's item (next to it).
     *
     * @param array $PA
     * @param string $content
     * @return void
     */
    protected function appendItemContent(array &$PA, $content)
    {
        $PA['item'] = preg_replace('#(<div style="clear:both;"></div>)$#s', $content . '$1', $PA['item']);
    }

    /**
     * Returns code to show a user-handled wizard associated to current
     * itemsProcFunc value.
     *
     * @param array $PA TCA configuration passed by reference
     * @param \TYPO3\CMS\Backend\Form\FormEngine|\TYPO3\CMS\Backend\Form\Element\InputTextElement $pObj Parent object
     * @return string HTML snippet to be put after the params field
     */
    public function params_procWizard(array &$PA, $pObj)
    {
        $itemsProcFunc = $PA['row']['tx_directmailuserfunc_itemsprocfunc'];
        if (!ItemsProcFunc::hasWizard($itemsProcFunc)) {
            return '';
        }

        $autoJS = true;
        $wizardJS = ItemsProcFunc::callWizard($itemsProcFunc, $PA, $autoJS, $pObj);

        if (!$wizardJS) {
            return '';
        }

        $altIcon = $GLOBALS['LANG']->getLL('wizard.parameters.title');
        if ($autoJS) {
            if (substr($wizardJS, -1) !== ';') {
                $wizardJS .= ';';
            }
            $wizardJS .= 'return false;';

            $output = '<a href="#" onclick="' . htmlspecialchars($wizardJS) . '" title="' . $altIcon . '">';
            $output .= static::getIcon('gfx/options.gif');
            $output .= '</a>';
        } else {
            $output = static::getIcon('gfx/options.gif', $altIcon, 'id="params-btn" style="cursor:pointer"');
            $output .= $wizardJS;
        }

        return $output;
    }

    /**
     * Returns a HTML image tag with a given icon (taking t3skin into account).
     *
     * @param string $src Image source
     * @param string $alt Alternate text
     * @param string $params Additional parameters for the img tag
     * @return string
     */
    protected static function getIcon($src, $alt = '', $params = '')
    {
        return '<img ' . \TYPO3\CMS\Backend\Utility\IconUtility::skinImg($GLOBALS['BACKPATH'], $src) .
        ' alt="' . $alt . '" title="' . $alt . '" vspace="4" align="absmiddle" ' . $params . '/>';
    }

    /**
     * Prepends a user function provider selector to the itemsProcFunc field.
     *
     * @param array $PA TCA configuration passed by reference
     * @return void
     */
    protected static function addUserFunctionProviders(array &$PA)
    {
        if (!count($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['direct_mail_userfunc']['userFunc'])) {
            return;
        }

        // Sort list of providers
        $providers = [];
        foreach ($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['direct_mail_userfunc']['userFunc'] as $provider) {
            $itemsProcFunc = $provider['class'] . '->' . $provider['method'];
            $providers[$itemsProcFunc] = static::getLL($provider['label']);
        }
        asort($providers);

        $hasOptionSelected = false;
        $options = [];
        foreach ($providers as $itemsProcFunc => $label) {
            $selected = '';
            if ($PA['row']['tx_directmailuserfunc_itemsprocfunc'] === $itemsProcFunc) {
                $hasOptionSelected = true;
                $selected = ' selected="selected"';
            }
            $options[] = sprintf('<option value="%s"%s>%s</option>', $itemsProcFunc, $selected, $label);
        }

        $updateJS = 'var itemsProcFunc = document.' . $PA['formName'] . '[\'userfunc_provider\'].value;';
        $updateJS .= 'TYPO3.jQuery(\'[data-formengine-input-name="' . $PA['itemName'] . '"]\').val(itemsProcFunc);';
        $updateJS .= implode('', $PA['fieldChangeFunc']);
        // Automatically reload edit form
        $updateJS .= 'if (confirm(TBE_EDITOR.labels.onChangeAlert) && TBE_EDITOR.checkSubmit(-1)){ TBE_EDITOR.submitForm() };';

        $selector = '
            <select name="userfunc_provider" onchange="' . htmlspecialchars($updateJS) . '">
                <option value=""></option>' .
            join('', $options) . '
            </select>
        ';

        $hideInput = $hasOptionSelected && ItemsProcFunc::isMethodValid($PA['row']['tx_directmailuserfunc_itemsprocfunc']);

        // Prepend the provider selector
        $PA['item'] = $GLOBALS['LANG']->getLL('wizard.itemsProcFunc.providers') . $selector .
            ($hideInput ? '<div style="display:none">' : '') . '<br />' . $PA['item'] . ($hideInput ? '</div>' : '');
    }

    /**
     * Returns the label with key $index for current backend language.
     *
     * @param string $label Label/key reference
     * @return string
     */
    public static function getLL($label)
    {
        if (strcmp(substr($label, 0, 8), 'LLL:EXT:')) {
            // Non-localizable string provided
            return $label;
        }

        $label = substr($label, 8);    // Remove 'LLL:EXT:' at the beginning
        $extension = substr($label, 0, strpos($label, '/'));
        $references = explode(':', substr($label, strlen($extension) + 1));
        if (!($extension && count($references))) {
            return $label;
        }

        $file = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($extension) . $references[0];
        $index = $references[1];
        $LOCAL_LANG = GeneralUtility::readLLfile($file, $GLOBALS['LANG']->lang);

        $ret = $label;
        if (strcmp($LOCAL_LANG[$GLOBALS['LANG']->lang][$index][0]['target'], '')) {
            $ret = $LOCAL_LANG[$GLOBALS['LANG']->lang][$index][0]['target'];
        } else {
            $ret = $LOCAL_LANG['default'][$index][0]['target'];
        }

        return $ret;
    }

}
