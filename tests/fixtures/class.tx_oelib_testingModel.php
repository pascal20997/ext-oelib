<?php
/***************************************************************
* Copyright notice
*
* (c) 2008 Oliver Klee <typo3-coding@oliverklee.de>
* All rights reserved
*
* This script is part of the TYPO3 project. The TYPO3 project is
* free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation; either version 2 of the License, or
* (at your option) any later version.
*
* The GNU General Public License can be found at
* http://www.gnu.org/copyleft/gpl.html.
*
* This script is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

require_once(t3lib_extMgm::extPath('oelib') . 'class.tx_oelib_model.php');

/**
 * Class 'tx_oelib_testingModel' for the 'oelib' extension.
 *
 * This class represents a domain model for testing purposes.
 *
 * @package TYPO3
 * @subpackage tx_oelib
 *
 * @author Oliver Klee <typo3-coding@oliverklee.de>
 */
final class tx_oelib_testingModel extends tx_oelib_model {
	/**
	 * Sets the "title" data item for this model.
	 *
	 * @param string the value to set, may be empty
	 */
	public function setTitle($value) {
		$this->setAsString('title', $value);
	}

	/**
	 * Gets the "title" data item.
	 *
	 * @return string the value of the "title" data item, may be empty
	 */
	public function getTitle() {
		return $this->getAsString('title');
	}

	/**
	 * Sets this models UID.
	 *
	 * This function is for testing purposes only.
	 *
	 * @param integer the UID to set, must be >= 0
	 */
	public function setUid($uid) {
		$this->setAsInteger('uid', $uid);
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/oelib/class.tx_oelib_testingModel.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/oelib/class.tx_oelib_testingModel.php']);
}
?>