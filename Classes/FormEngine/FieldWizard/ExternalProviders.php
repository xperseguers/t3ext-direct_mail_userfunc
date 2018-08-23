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

namespace Causal\DirectMailUserfunc\FormEngine\FieldWizard;

use Causal\DirectMailUserfunc\Utility\ItemsProcFunc;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * This class encapsulates display of a user wizard.
 *
 * @category    FormEngine\FieldWizard
 * @package     direct_mail_userfunc
 * @author      Xavier Perseguers <xavier@causal.ch>
 * @copyright   2012-2018 Causal Sàrl
 * @license     https://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class ExternalProviders
{

    /**
     * Returns code to show whether the itemsProcFunc definition is valid.
     *
     * @param array $PA TCA configuration passed by reference
     * @param \TYPO3\CMS\Backend\Form\FormEngine|\TYPO3\CMS\Backend\Form\Element\InputTextElement $pObj Parent object
     * @return string HTML snippet to be put after the itemsProcFunc field
     */
    public function renderList(array &$PA, $pObj) : string
    {
        // Show the user function provider selector
        $this->addUserFunctionProviders($PA);

        return $PA['item'];
    }

    /**
     * Returns code to show a user-handled wizard associated to current
     * itemsProcFunc value.
     *
     * @param array $PA TCA configuration passed by reference
     * @param \TYPO3\CMS\Backend\Form\FormEngine|\TYPO3\CMS\Backend\Form\Element\InputTextElement $pObj Parent object
     * @return string HTML snippet to be put after the params field
     */
    public function params_procWizard(array &$PA, $pObj) : string
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

        $altIcon = $this->sL('LLL:EXT:direct_mail_userfunc/Resources/Private/Language/locallang_tca.xlf:wizard.parameters.title');
        if ($autoJS) {
            if (substr($wizardJS, -1) !== ';') {
                $wizardJS .= ';';
            }
            $wizardJS .= 'return false;';

            $output = '<a href="#" onclick="' . htmlspecialchars($wizardJS) . '" title="' . $altIcon . '">';
            //$output .= static::getIcon('gfx/options.gif');
            $output .= '</a>';
        } else {
            $output = ''; //static::getIcon('gfx/options.gif', $altIcon, 'id="params-btn" style="cursor:pointer"');
            $output .= $wizardJS;
        }

        return $output;
    }

    /**
     * Prepends a user function provider selector to the itemsProcFunc field.
     *
     * @param array $PA TCA configuration passed by reference
     */
    protected function addUserFunctionProviders(array &$PA)
    {
        if (!count($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['direct_mail_userfunc']['userFunc'])) {
            return;
        }

        // Sort list of providers
        $providers = [];
        foreach ($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['direct_mail_userfunc']['userFunc'] as $provider) {
            $itemsProcFunc = $provider['class'] . '->' . $provider['method'];
            $providers[$itemsProcFunc] = $this->sL($provider['label']);
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
            <select class="form-control" name="userfunc_provider" onchange="' . htmlspecialchars($updateJS) . '">
                <option value=""></option>' .
                implode('', $options) . '
            </select>
        ';

        $hideInput = $hasOptionSelected && ItemsProcFunc::isMethodValid($PA['row']['tx_directmailuserfunc_itemsprocfunc']);

        $out = [];
        $out[] = '<div class="form-control-wrap">';
        $out[] =    '<label class="t3js-formengine-label">';
        $out[] =        $this->sL('LLL:EXT:direct_mail_userfunc/Resources/Private/Language/locallang_tca.xlf:wizard.itemsProcFunc.providers');
        $out[] =    '</label>';
        $out[] =    '<div class="form-control-wrap">';
        $out[] =        $selector;
        $out[] =        ($hideInput ? '<div style="display:none">' : '') . $PA['item'] . ($hideInput ? '</div>' : '');
        $out[] =    '</div>';
        $out[] = '</div>';

        $PA['item'] = implode(LF, $out);
    }

    /**
     * @param string $input
     * @return string
     */
    protected function sL(string $input) : string
    {
        if (!strcmp(substr($input, 0, 8), 'LLL:EXT:')) {
            $input = $GLOBALS['LANG']->sL($input);
        }

        return htmlspecialchars($input);
    }

}