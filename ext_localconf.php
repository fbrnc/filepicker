<?php

$TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_tceforms.php']['dbFileIcons']['filepicker'] = 'tx_filepicker_hooks_dbfileicons';

$TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass']['filepicker'] =
	'EXT:filepicker/classes/hooks/class.tx_filepicker_hooks_processdatamap.php:tx_filepicker_hooks_processdatamap';