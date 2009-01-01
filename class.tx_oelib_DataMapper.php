<?php
/***************************************************************
* Copyright notice
*
* (c) 2008-2009 Oliver Klee <typo3-coding@oliverklee.de>
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

require_once(t3lib_extMgm::extPath('oelib') . 'class.tx_oelib_Autoloader.php');
require_once(t3lib_extMgm::extPath('oelib') . 'tx_oelib_commonConstants.php');

/**
 * Class 'tx_oelib_DataMapper' for the 'oelib' extension.
 *
 * This class represents a mapper that maps database record to model instances.
 *
 * @package TYPO3
 * @subpackage tx_oelib
 *
 * @author Oliver Klee <typo3-coding@oliverklee.de>
 */
abstract class tx_oelib_DataMapper {
	/**
	 * @var string the name of the database table for this mapper,
	 *             must not be empty in subclasses
	 */
	protected $tableName = '';

	/**
	 * @var string a comma-separated list of DB column names to retrieve
	 *             or "*" for all columns, must not be empty
	 */
	protected $columns = '*';

	/**
	 * @var string the model class name for this mapper, must not be empty
	 */
	protected $modelClassName = '';

	/**
	 * @var tx_oelib_IdentityMap a map that holds the models that already
	 *                           have been retrieved
	 */
	protected $map = null;

	/**
	 * The constructor.
	 */
	public function __construct() {
		if ($this->tableName == '') {
			throw new Exception(
				get_class($this) . '::tableName must not be empty.'
			);
		}
		if ($this->columns == '') {
			throw new Exception(
				get_class($this) . '::columns must not be empty.'
			);
		}
		if ($this->modelClassName == '') {
			throw new Exception(
				get_class($this) . '::modelClassName must not be empty.'
			);
		}

		$this->map = t3lib_div::makeInstance('tx_oelib_IdentityMap');
	}

	/**
	 * Frees as much memory that has been used by this object as possible.
	 */
	public function __destruct() {
		if ($this->map) {
			$this->map->__destruct();
			unset($this->map);
		}
	}

	/**
	 * Retrieves a record from the DB by UID and creates a model from it. If
	 * the model already is cached in memory, the cached instance is returned.
	 *
	 * @throws tx_oelib_Exception_NotFound if there is no record in the DB
	 *                                     with that particular UID
	 *
	 * @param integer the UID of the record to retrieve, must be > 0
	 *
	 * @return tx_oelib_Model the stored model with the UID $uid
	 */
	public function find($uid) {
		try {
			$result = $this->map->get($uid);
		} catch (tx_oelib_Exception_NotFound $exception) {
			$result = $this->load($uid);
		}

		return $result;
	}

	/**
	 * Retrieves a record from the DB without consulting this mapper's map,
	 * and then stores it in the map.
	 *
	 * @throws tx_oelib_Exception_NotFound if there is no record in the DB
	 *                                     with that particular UID
	 *
	 * @param integer the UID of the record to retrieve, must be > 0
	 *
	 * @return tx_oelib_Model the stored model with the UID $uid
	 */
	protected function load($uid) {
		$queryResult = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
			$this->columns,
			$this->tableName,
			'uid = ' . $uid . tx_oelib_db::enableFields($this->tableName)
		);
		if (!$queryResult) {
			throw new Exception(DATABASE_QUERY_ERROR);
		}

		$data = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($queryResult);
		$GLOBALS['TYPO3_DB']->sql_free_result($queryResult);

		if (!$data) {
			throw new tx_oelib_Exception_NotFound(
				'The record with the UID ' . $uid . ' could not be retrieved ' .
					'from the table ' . $this->tableName . '.'
			);
		}

		$model = $this->createAndFillModel($data);
		$this->map->add($model);

		return $model;
	}

	/**
	 * Creates a model of the correct type for this mapper and fills it with
	 * the data provided as $data.
	 *
	 * @param array the data with which the model should be filled, may be empty
	 *
	 * @return tx_oelib_Model the filled model
	 */
	protected function createAndFillModel(array $data) {
		$model = t3lib_div::makeInstance($this->modelClassName);
		$model->setData($data);

		return $model;
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/oelib/class.tx_oelib_DataMapper.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/oelib/class.tx_oelib_DataMapper.php']);
}
?>