<?php
$extensionPath = t3lib_extMgm::extPath('direct_mail_userfunc');
$extensionClassesPath = $extensionPath . 'Classes/';
return array(
	// Compatibility with TYPO3 4.5
	'tx_directmailuserfunc_controller_wizard' => $extensionClassesPath . 'Controller/Wizard.php',
);
