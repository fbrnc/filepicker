<?php

/**
 * Hook into t3lib_TCEforms::dbFileIcons
 *
 * @author Fabrizio Branca
 * @package TYPO3
 * @subpackage tx_filepicker
 */
class tx_filepicker_hooks_dbfileicons implements t3lib_TCEforms_dbFileIconsHook {

	/**
	 * @var array extension manager configuration
	 */
	protected $emConf;

	/**
	 * Modifies the parameters for selector box form-field for the db/file/select elements (multiple)
	 *
	 * @param	array			$params				An array of additional parameters, eg: "size", "info", "headers" (array with "selector" and "items"), "noBrowser", "thumbnails"
	 * @param	string			$selector			Alternative selector box.
	 * @param	string			$thumbnails			Thumbnail view of images. Only filled if there are images only. This images will be shown under the selectorbox.
	 * @param	array			$icons				Defined icons next to the selector box.
	 * @param	string			$rightbox			Thumbnail view of images. Only filled if there are other types as images. This images will be shown right next to the selectorbox.
	 * @param	string			$fName				Form element name
	 * @param	array			$uidList			The array of item-uids. Have a look at t3lib_TCEforms::dbFileIcons parameter "$itemArray"
	 * @param	array			$additionalParams	Array with additional parameters which are be available at method call. Includes $mode, $allowed, $itemArray, $onFocus, $table, $field, $uid. For more information have a look at PHPDoc-Comment of t3lib_TCEforms::dbFileIcons
	 * @param	t3lib_TCEforms	$parentObject		parent t3lib_TCEforms object
	 * @return	void
	 */
	public function dbFileIcons_postProcess(array &$params, &$selector, &$thumbnails, array &$icons, &$rightbox, &$fName, array &$uidList, array $additionalParams, t3lib_TCEforms $parentObject) {

		if ($params['readOnly'] ||
			$params['noList'] ||
			$params['noBrowser'] ||
			$additionalParams['mode'] != 'file') {
			return;
		}

		$filepickerInit = '
			<script type="text/javascript" src="//api.filepicker.io/v0/filepicker.js"></script>
			<script type="text/javascript">filepicker.setKey("'.$this->getEmConf('apiKey').'");</script>';

		$onClick = "filepicker.getFile(['text/plain','image/jpeg'], {
			'multiple': true,
			'modal': true
		}, function(response) {
			var select = document.getElementsByName('{$fName}_list')[0];
			response.map(function(item) {
				setFormValueFromBrowseWin('$fName', item.url + '|' + item.data.filename, item.data.filename);
			})
		});";

		$icons['R'][] = $filepickerInit . '<a href="#" onclick="'.htmlspecialchars($onClick).'">'.
			'<img' . t3lib_iconWorks::skinImg($GLOBALS['BACK_PATH'], '../typo3conf/ext/filepicker/ext_icon.gif', 'width="16" height="16"') . '>' .
		'</a>';
	}

	/**
	 * Get extension manager configuration
	 *
	 * @param string $key if set return this key instead of complete configuration
	 * @return array
	 * @throws Exception
	 */
	protected function getEmConf($key=null) {
		if (empty($this->emConf)) {
			require(PATH_typo3conf.'localconf.php');  // don't use require_once here!
			$this->emConf = unserialize($TYPO3_CONF_VARS['EXT']['extConf']['filepicker']);
			if (!is_array($this->emConf)) {
				throw new Exception('No extension manager configuration found for EXT:filepicker');
			}
		}
		return $key ? $this->emConf[$key] : $this->emConf;
	}
}

if (defined('TYPO3_MODE') && isset($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/fal/classes/hooks/class.tx_filepicker_hooks_dbfileicons.php'])) {
	include_once($GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/filepicker/classes/hooks/class.tx_filepicker_hooks_dbfileicons.php']);
}

?>