<?php

########################################################################
# Extension Manager/Repository config file for ext "filepicker".
#
# Auto generated 26-07-2012 23:18
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Filepicker.io',
	'description' => 'Uploading files using Filepicker.io',
	'category' => 'misc',
	'author' => 'Fabrizio Branca',
	'author_email' => 'typo3@fabrizio-branca.de',
	'shy' => 0,
	'dependencies' => 'cms',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'beta',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => 'typo3temp/tx_filepicker/',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'author_company' => '',
	'version' => '0.0.1',
	'constraints' => array(
		'depends' => array(
			'cms' => '',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:6:{s:16:"ext_autoload.php";s:4:"ad4c";s:21:"ext_conf_template.txt";s:4:"c83a";s:12:"ext_icon.gif";s:4:"0547";s:17:"ext_localconf.php";s:4:"be18";s:55:"classes/hooks/class.tx_filepicker_hooks_dbfileicons.php";s:4:"a651";s:58:"classes/hooks/class.tx_filepicker_hooks_processdatamap.php";s:4:"98d0";}',
	'suggests' => array(
	),
);

?>