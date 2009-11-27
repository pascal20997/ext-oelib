<?php
/***************************************************************
* Copyright notice
*
* (c) 2009 Bernd Schönbach <bernd@oliverklee.de>
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

/**
 * Testcase for the tx_oelib_Mapper_BackEndUserGroup class in the 'oelib' extension.
 *
 * @package TYPO3
 * @subpackage tx_oelib
 *
 * @author Bernd Schönbach <bernd@oliverklee.de>
 * @author Oliver Klee <typo3-coding@oliverklee.de>
 */
class tx_oelib_Mapper_BackEndUserGroup_testcase extends tx_phpunit_testcase {
	/**
	 * @var tx_oelib_testingFramework for creating dummy records
	 */
	private $testingFramework;
	/**
	 * @var tx_oelib_Mapper_BackEndUserGroup the object to test
	 */
	private $fixture;

	public function setUp() {
		$this->testingFramework = new tx_oelib_testingFramework('tx_oelib');

		$this->fixture = tx_oelib_MapperRegistry::get('tx_oelib_Mapper_BackEndUserGroup');
	}

	public function tearDown() {
		$this->testingFramework->cleanUp();

		$this->fixture->__destruct();
		unset($this->fixture, $this->testingFramework);
	}


	/////////////////////////////////////////
	// Tests concerning the basic functions
	/////////////////////////////////////////

	public function test_Find_ReturnsBackEndUserGroupInstance() {
		$uid = $this->fixture->getNewGhost()->getUid();

		$this->assertTrue(
			$this->fixture->find($uid)
				instanceof tx_oelib_Model_BackEndUserGroup
		);
	}

	public function test_load_ForExistingUserGroup_CanLoadUserGroupData() {
		$userGroup = $this->fixture->find(
			$this->testingFramework->createBackEndUserGroup(
				array('title' => 'foo')
			)
		);

		$this->fixture->load($userGroup);

		$this->assertEquals(
			'foo',
			$userGroup->getTitle()
		);
	}


	///////////////////////////////////
	// Tests concerning the relations
	///////////////////////////////////

	/**
	 * @test
	 */
	public function subgroupRelationIsUserGroupList() {
		$subgroup = $this->fixture->getNewGhost();
		$group = $this->fixture->getLoadedTestingModel(
			array('subgroup' => $subgroup->getUid())
		);

		$this->assertTrue(
			$this->fixture->find($group->getUid())->getSubgroups()->first()
				instanceof tx_oelib_Model_BackEndUserGroup
		);
	}
}
?>