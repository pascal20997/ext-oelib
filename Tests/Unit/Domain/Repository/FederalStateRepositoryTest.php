<?php
/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * Testcase for the Tx_Oelib_Domain_Repository_FederalStateRepository class.
 *
 * @package TYPO3
 * @subpackage tx_oelib
 *
 * @author Oliver Klee <typo3-coding@oliverklee.de>
 */
class Tx_Oelib_Domain_Repository_FederalStateRepositoryTest extends Tx_Extbase_Tests_Unit_BaseTestCase {
	/**
	 * @var Tx_Oelib_Domain_Repository_FederalStateRepository
	 */
	protected $subject = NULL;

	protected function setUp() {
		/** @var Tx_Extbase_Object_ObjectManagerInterface $objectManager */
		$objectManager = $this->getMock('Tx_Extbase_Object_ObjectManagerInterface');
		$this->subject = new Tx_Oelib_Domain_Repository_FederalStateRepository($objectManager);
	}

	/**
	 * @test
	 */
	public function classCanBeInstantiated() {
		/** @var Tx_Extbase_Object_ObjectManagerInterface $objectManager */
		$objectManager = $this->getMock('Tx_Extbase_Object_ObjectManagerInterface');
		$this->assertNotNull(
			new Tx_Oelib_Domain_Repository_FederalStateRepository($objectManager)
		);
	}

	/**
	 * @test
	 */
	public function initializeObjectSetsRespectStoragePidToFalse() {
		/** @var Tx_Extbase_Object_ObjectManagerInterface|PHPUnit_Framework_MockObject_MockObject $objectManager */
		$objectManager = $this->getMock('Tx_Extbase_Object_ObjectManagerInterface');
		$subject = new Tx_Oelib_Domain_Repository_FederalStateRepository($objectManager);

		$querySettings = $this->getMock('Tx_Extbase_Persistence_Typo3QuerySettings');
		$querySettings->expects($this->once())->method('setRespectStoragePage')->with(FALSE);
		$objectManager->expects($this->once())->method('create')
			->with('Tx_Extbase_Persistence_Typo3QuerySettings')->will($this->returnValue($querySettings));

		$subject->initializeObject();
	}

	/**
	 * @test
	 */
	public function initializeObjectSetsDefaultQuerySettings() {
		$objectManager = $this->getMock('Tx_Extbase_Object_ObjectManagerInterface');
		$subject = $this->getMock(
			'Tx_Oelib_Domain_Repository_FederalStateRepository',
			array('setDefaultQuerySettings'), array($objectManager)
		);

		$querySettings = $this->getMock('Tx_Extbase_Persistence_Typo3QuerySettings');
		$objectManager->expects($this->once())->method('create')
			->with('Tx_Extbase_Persistence_Typo3QuerySettings')->will($this->returnValue($querySettings));

		$subject->expects($this->once())->method('setDefaultQuerySettings')->with($querySettings);

		/** @var Tx_Oelib_Domain_Repository_FederalStateRepository $subject */
		$subject->initializeObject();
	}

	/**
	 * @test
	 *
	 * @expectedException BadMethodCallException
	 */
	public function addThrowsException() {
		$this->subject->add(new Tx_Oelib_Domain_Model_FederalState());
	}

	/**
	 * @test
	 *
	 * @expectedException BadMethodCallException
	 */
	public function removeThrowsException() {
		$this->subject->remove(new Tx_Oelib_Domain_Model_FederalState());
	}

	/**
	 * @test
	 *
	 * @expectedException BadMethodCallException
	 */
	public function replaceThrowsException() {
		$this->subject->replace(new Tx_Oelib_Domain_Model_FederalState(), new Tx_Oelib_Domain_Model_FederalState());
	}

	/**
	 * @test
	 *
	 * @expectedException BadMethodCallException
	 */
	public function updateThrowsException() {
		$this->subject->update(new Tx_Oelib_Domain_Model_FederalState());
	}

	/**
	 * @test
	 *
	 * @expectedException BadMethodCallException
	 */
	public function removeAllThrowsException() {
		$this->subject->removeAll();
	}
}