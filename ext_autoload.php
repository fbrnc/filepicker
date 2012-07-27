<?php

$extensionPath = t3lib_extMgm::extPath('filepicker');
return array(
	'tx_filepicker_hooks_dbfileicons' => $extensionPath . 'classes/hooks/class.tx_filepicker_hooks_dbfileicons.php',
	'tx_filepicker_hooks_processdatamap' => $extensionPath . 'classes/hooks/class.tx_filepicker_hooks_processdatamap.php',
);

?>