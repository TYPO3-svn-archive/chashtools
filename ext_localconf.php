<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

$TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_div.php']['cHashParamsHook']['chashtools'] =
	'EXT:chashtools/class.tx_chashtools_modifyCacheHashHook.php:tx_chashtools_modifyCacheHashHook->process';
?>
