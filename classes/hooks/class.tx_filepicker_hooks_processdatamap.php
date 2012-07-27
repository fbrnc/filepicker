<?php

/**
 * Hook into t3lib_TCEmain process datamap
 *
 * @author Fabrizio Branca
 * @package TYPO3
 * @subpackage tx_filepicker
 */
class tx_filepicker_hooks_processdatamap {

	public static $downloadedFiles = array();

	/**
	 * Looping through the datamap finding all group/file fields
	 * and download all files selected using Filepicker.io to the local filesystem
	 *
	 * @param t3lib_TCEmain $parentObject
	 */
	public function processDatamap_beforeStart(t3lib_TCEmain $parentObject) {
		foreach($parentObject->datamap as $table => $conf) {
			t3lib_div::loadTCA($table);
			foreach($conf as $id => $fields) {
				foreach ($fields as $field => $value) {
					if (isset($GLOBALS['TCA'][$table]['columns'][$field])) {
						$tcaFieldConf = $GLOBALS['TCA'][$table]['columns'][$field]['config'];
						if ($tcaFieldConf['type'] == 'group') {
							if ($tcaFieldConf['internal_type'] == 'file' || $tcaFieldConf['internal_type'] == 'file_reference') {
								$values = t3lib_div::trimExplode(',', $value, TRUE);
								foreach ($values as $key => $value) {
									if (strpos($value, '|') === FALSE) {
										// this is a file that hasn't been selected using Filepicker.io
										continue;
									}
									list($url, $filename) = t3lib_div::trimExplode('|', $value);
									$result = $this->downloadFile($url, $filename);
									if ($result !== FALSE) {
										$values[$key] = $result;
									} else {
										t3lib_div::sysLog('Failed downloading file "'.$value.'"', 'filepicker', 3);
									}
								}
								$parentObject->datamap[$table][$id][$field] = implode(',', $values);
							}
						}
					}
				}
			}
		}
	}

	/**
	 * Delete all temporary downloads
	 *
	 * @return void
	 */
	public function processDatamap_afterAllOperations() {
		foreach(self::$downloadedFiles as $downloadedFile) {
			if (is_file($downloadedFile)) {
				$result = t3lib_div::unlink_tempfile($downloadedFile);
				if (!$result) {
					t3lib_div::sysLog('Could not delete tempfile "'.$downloadedFile.'"', 'filepicker', 3);
				}
			}
		}
	}

	/**
	 * Download file from given url to tempfile with a given name.
	 * FALSE on error. Filename on success
	 *
	 * @param $url
	 * @param $filename
	 * @return bool|string
	 */
	protected function downloadFile($url, $filename) {
		if (!t3lib_div::verifyFilenameAgainstDenyPattern($filename)) {
			return FALSE;
		}
		if (!t3lib_div::validPathStr($filename)) {
			return FALSE;
		}
		$content = t3lib_div::getUrl($url);
		$localFilename = PATH_site. 'typo3temp/tx_filepicker/' . $filename;
		$result = t3lib_div::writeFileToTypo3tempDir($localFilename, $content);
		if (!is_null($result)) {
			return FALSE;
		}
		self::$downloadedFiles[] = $localFilename;
		return $localFilename;
	}

}