<?php

########################################################################
# Extension Manager/Repository config file for ext "oelib".
#
# Auto generated 22-09-2011 12:52
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'One is Enough Library',
	'description' => 'This extension provides useful stuff for extension development: helper functions for unit testing, templating, automatic configuration checks and performance benchmarking.',
	'category' => 'services',
	'author' => 'Oliver Klee',
	'author_email' => 'typo3-coding@oliverklee.de',
	'shy' => 0,
	'dependencies' => 'static_info_tables',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'module' => '',
	'state' => 'beta',
	'internal' => '',
	'uploadfolder' => 1,
	'createDirs' => '',
	'modify_tables' => 'be_users,be_groups,fe_groups,fe_users,pages,sys_template,tt_content',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'author_company' => '',
	'version' => '0.7.61',
	'_md5_values_when_last_written' => 'a:168:{s:13:"changelog.txt";s:4:"a847";s:29:"class.tx_oelib_Attachment.php";s:4:"f260";s:29:"class.tx_oelib_Autoloader.php";s:4:"761b";s:38:"class.tx_oelib_BackEndLoginManager.php";s:4:"2529";s:32:"class.tx_oelib_Configuration.php";s:4:"6ae9";s:40:"class.tx_oelib_ConfigurationRegistry.php";s:4:"d199";s:29:"class.tx_oelib_DataMapper.php";s:4:"6956";s:35:"class.tx_oelib_Double3Validator.php";s:4:"2826";s:30:"class.tx_oelib_FakeSession.php";s:4:"1030";s:32:"class.tx_oelib_FileFunctions.php";s:4:"e273";s:39:"class.tx_oelib_FrontEndLoginManager.php";s:4:"ee42";s:30:"class.tx_oelib_IdentityMap.php";s:4:"e809";s:23:"class.tx_oelib_List.php";s:4:"83a4";s:23:"class.tx_oelib_Mail.php";s:4:"8b99";s:33:"class.tx_oelib_MapperRegistry.php";s:4:"794d";s:24:"class.tx_oelib_Model.php";s:4:"0304";s:25:"class.tx_oelib_Object.php";s:4:"f6f1";s:32:"class.tx_oelib_ObjectFactory.php";s:4:"048d";s:29:"class.tx_oelib_PageFinder.php";s:4:"0681";s:31:"class.tx_oelib_PublicObject.php";s:4:"a9d1";s:26:"class.tx_oelib_Session.php";s:4:"9f6f";s:27:"class.tx_oelib_Template.php";s:4:"a32a";s:35:"class.tx_oelib_TemplateRegistry.php";s:4:"e256";s:42:"class.tx_oelib_TestingFrameworkCleanup.php";s:4:"e8e8";s:24:"class.tx_oelib_Timer.php";s:4:"7142";s:29:"class.tx_oelib_Translator.php";s:4:"6db2";s:37:"class.tx_oelib_TranslatorRegistry.php";s:4:"ca84";s:38:"class.tx_oelib_abstractHeaderProxy.php";s:4:"70a3";s:33:"class.tx_oelib_abstractMailer.php";s:4:"79f5";s:30:"class.tx_oelib_configcheck.php";s:4:"d6d9";s:37:"class.tx_oelib_configurationProxy.php";s:4:"1656";s:21:"class.tx_oelib_db.php";s:4:"9897";s:33:"class.tx_oelib_emailCollector.php";s:4:"89aa";s:34:"class.tx_oelib_headerCollector.php";s:4:"51c9";s:37:"class.tx_oelib_headerProxyFactory.php";s:4:"f752";s:32:"class.tx_oelib_mailerFactory.php";s:4:"daba";s:34:"class.tx_oelib_realHeaderProxy.php";s:4:"633a";s:29:"class.tx_oelib_realMailer.php";s:4:"d474";s:37:"class.tx_oelib_salutationswitcher.php";s:4:"d993";s:33:"class.tx_oelib_templatehelper.php";s:4:"0b17";s:35:"class.tx_oelib_testingFramework.php";s:4:"2819";s:16:"ext_autoload.php";s:4:"184a";s:12:"ext_icon.gif";s:4:"b4bf";s:17:"ext_localconf.php";s:4:"1e13";s:14:"ext_tables.php";s:4:"4384";s:14:"ext_tables.sql";s:4:"aa25";s:22:"icon_tx_oelib_test.gif";s:4:"bd58";s:16:"locallang_db.xml";s:4:"a70b";s:7:"tca.php";s:4:"6a0e";s:8:"todo.txt";s:4:"d400";s:28:"tx_oelib_commonConstants.php";s:4:"0182";s:51:"Exception/class.tx_oelib_Exception_AccessDenied.php";s:4:"369f";s:47:"Exception/class.tx_oelib_Exception_Database.php";s:4:"cf4d";s:55:"Exception/class.tx_oelib_Exception_EmptyQueryResult.php";s:4:"3ecd";s:47:"Exception/class.tx_oelib_Exception_NotFound.php";s:4:"693e";s:24:"Geocoding/Calculator.php";s:4:"b18c";s:44:"Geocoding/class.tx_oelib_Geocoding_Dummy.php";s:4:"d9be";s:45:"Geocoding/class.tx_oelib_Geocoding_Google.php";s:4:"1ecc";s:22:"Interface/Sortable.php";s:4:"f484";s:46:"Interface/class.tx_oelib_Interface_Address.php";s:4:"6250";s:42:"Interface/class.tx_oelib_Interface_Geo.php";s:4:"c72e";s:51:"Interface/class.tx_oelib_Interface_LoginManager.php";s:4:"ab27";s:47:"Interface/class.tx_oelib_Interface_MailRole.php";s:4:"dd45";s:44:"Mapper/class.tx_oelib_Mapper_BackEndUser.php";s:4:"831c";s:49:"Mapper/class.tx_oelib_Mapper_BackEndUserGroup.php";s:4:"779e";s:40:"Mapper/class.tx_oelib_Mapper_Country.php";s:4:"09b2";s:41:"Mapper/class.tx_oelib_Mapper_Currency.php";s:4:"d001";s:45:"Mapper/class.tx_oelib_Mapper_FrontEndUser.php";s:4:"b6f3";s:50:"Mapper/class.tx_oelib_Mapper_FrontEndUserGroup.php";s:4:"c900";s:41:"Mapper/class.tx_oelib_Mapper_Language.php";s:4:"15c4";s:42:"Model/class.tx_oelib_Model_BackEndUser.php";s:4:"68c0";s:47:"Model/class.tx_oelib_Model_BackEndUserGroup.php";s:4:"067f";s:38:"Model/class.tx_oelib_Model_Country.php";s:4:"c12e";s:39:"Model/class.tx_oelib_Model_Currency.php";s:4:"066b";s:43:"Model/class.tx_oelib_Model_FrontEndUser.php";s:4:"a01d";s:48:"Model/class.tx_oelib_Model_FrontEndUserGroup.php";s:4:"eacc";s:39:"Model/class.tx_oelib_Model_Language.php";s:4:"17dc";s:40:"Resources/Private/Language/locallang.xml";s:4:"0494";s:46:"ViewHelper/class.tx_oelib_ViewHelper_Price.php";s:4:"b417";s:45:"Visibility/class.tx_oelib_Visibility_Node.php";s:4:"2a7b";s:45:"Visibility/class.tx_oelib_Visibility_Tree.php";s:4:"cdba";s:21:"contrib/PEAR/PEAR.php";s:4:"9e9a";s:22:"contrib/PEAR/PEAR5.php";s:4:"2107";s:26:"contrib/PEAR/Mail/mime.php";s:4:"94a3";s:30:"contrib/PEAR/Mail/mimePart.php";s:4:"c575";s:30:"contrib/emogrifier/LICENSE.TXT";s:4:"8403";s:33:"contrib/emogrifier/emogrifier.php";s:4:"f03e";s:14:"doc/manual.sxw";s:4:"4d4d";s:24:"tests/AttachmentTest.php";s:4:"79de";s:24:"tests/AutoloaderTest.php";s:4:"146d";s:33:"tests/BackEndLoginManagerTest.php";s:4:"8ab0";s:35:"tests/ConfigurationRegistryTest.php";s:4:"1782";s:27:"tests/ConfigurationTest.php";s:4:"c523";s:24:"tests/DataMapperTest.php";s:4:"cd14";s:30:"tests/Double3ValidatorTest.php";s:4:"6b4d";s:32:"tests/Exception_DatabaseTest.php";s:4:"ee92";s:25:"tests/FakeSessionTest.php";s:4:"c849";s:34:"tests/FrontEndLoginManagerTest.php";s:4:"ab14";s:25:"tests/configcheckTest.php";s:4:"a5e6";s:32:"tests/configurationProxyTest.php";s:4:"47a7";s:16:"tests/dbTest.php";s:4:"2a1b";s:39:"tests/tx_oelib_IdentityMap_testcase.php";s:4:"38e1";s:32:"tests/tx_oelib_List_testcase.php";s:4:"0f98";s:32:"tests/tx_oelib_Mail_testcase.php";s:4:"b7fd";s:42:"tests/tx_oelib_MapperRegistry_testcase.php";s:4:"61ce";s:33:"tests/tx_oelib_Model_testcase.php";s:4:"2dcf";s:41:"tests/tx_oelib_ObjectFactory_testcase.php";s:4:"650b";s:34:"tests/tx_oelib_Object_testcase.php";s:4:"6369";s:38:"tests/tx_oelib_PageFinder_testcase.php";s:4:"2b39";s:35:"tests/tx_oelib_Session_testcase.php";s:4:"3730";s:44:"tests/tx_oelib_TemplateRegistry_testcase.php";s:4:"28ad";s:36:"tests/tx_oelib_Template_testcase.php";s:4:"40ab";s:33:"tests/tx_oelib_Timer_testcase.php";s:4:"fc27";s:46:"tests/tx_oelib_TranslatorRegistry_testcase.php";s:4:"d886";s:38:"tests/tx_oelib_Translator_testcase.php";s:4:"142f";s:46:"tests/tx_oelib_headerProxyFactory_testcase.php";s:4:"d534";s:41:"tests/tx_oelib_mailerFactory_testcase.php";s:4:"e0d9";s:38:"tests/tx_oelib_phpmyadmin_testcase.php";s:4:"947c";s:51:"tests/tx_oelib_salutationswitcherchild_testcase.php";s:4:"7cd1";s:47:"tests/tx_oelib_templatehelperchild_testcase.php";s:4:"86de";s:44:"tests/tx_oelib_testingFramework_testcase.php";s:4:"44b2";s:40:"tests/Exception/EmptyQueryResultTest.php";s:4:"4b05";s:34:"tests/Geocoding/CalculatorTest.php";s:4:"6eab";s:29:"tests/Geocoding/DummyTest.php";s:4:"18b8";s:30:"tests/Geocoding/GoogleTest.php";s:4:"6c88";s:37:"tests/Mapper/BackEndUserGroupTest.php";s:4:"af12";s:32:"tests/Mapper/BackEndUserTest.php";s:4:"73b0";s:28:"tests/Mapper/CountryTest.php";s:4:"aca6";s:29:"tests/Mapper/CurrencyTest.php";s:4:"61ec";s:38:"tests/Mapper/FrontEndUserGroupTest.php";s:4:"f0c0";s:33:"tests/Mapper/FrontEndUserTest.php";s:4:"7aa2";s:29:"tests/Mapper/LanguageTest.php";s:4:"fd11";s:36:"tests/Model/BackEndUserGroupTest.php";s:4:"b19e";s:31:"tests/Model/BackEndUserTest.php";s:4:"96b0";s:27:"tests/Model/CountryTest.php";s:4:"70f3";s:28:"tests/Model/CurrencyTest.php";s:4:"de48";s:37:"tests/Model/FrontEndUserGroupTest.php";s:4:"1392";s:32:"tests/Model/FrontEndUserTest.php";s:4:"a9e4";s:28:"tests/Model/LanguageTest.php";s:4:"9446";s:30:"tests/ViewHelper/PriceTest.php";s:4:"80c0";s:29:"tests/Visibility/NodeTest.php";s:4:"aa3c";s:29:"tests/Visibility/TreeTest.php";s:4:"f0f2";s:52:"tests/fixtures/class.tx_oelib_dummyObjectToCheck.php";s:4:"5f39";s:57:"tests/fixtures/class.tx_oelib_salutationswitcherchild.php";s:4:"7f92";s:53:"tests/fixtures/class.tx_oelib_templatehelperchild.php";s:4:"d62f";s:47:"tests/fixtures/class.tx_oelib_testingObject.php";s:4:"623b";s:72:"tests/fixtures/class.tx_oelib_tests_fixtures_ColumnLessTestingMapper.php";s:4:"9ef3";s:54:"tests/fixtures/class.tx_oelib_tests_fixtures_Empty.php";s:4:"c6b4";s:71:"tests/fixtures/class.tx_oelib_tests_fixtures_ModelLessTestingMapper.php";s:4:"7b42";s:60:"tests/fixtures/class.tx_oelib_tests_fixtures_NotIncluded.php";s:4:"b8c6";s:66:"tests/fixtures/class.tx_oelib_tests_fixtures_NotIncludedEither.php";s:4:"48d7";s:62:"tests/fixtures/class.tx_oelib_tests_fixtures_ReadOnlyModel.php";s:4:"a0e5";s:71:"tests/fixtures/class.tx_oelib_tests_fixtures_TableLessTestingMapper.php";s:4:"7763";s:67:"tests/fixtures/class.tx_oelib_tests_fixtures_TestingChildMapper.php";s:4:"19bf";s:66:"tests/fixtures/class.tx_oelib_tests_fixtures_TestingChildModel.php";s:4:"3793";s:59:"tests/fixtures/class.tx_oelib_tests_fixtures_TestingGeo.php";s:4:"9c90";s:64:"tests/fixtures/class.tx_oelib_tests_fixtures_TestingMailRole.php";s:4:"2a96";s:62:"tests/fixtures/class.tx_oelib_tests_fixtures_TestingMapper.php";s:4:"e1c4";s:61:"tests/fixtures/class.tx_oelib_tests_fixtures_TestingModel.php";s:4:"6b91";s:28:"tests/fixtures/locallang.xml";s:4:"c52b";s:25:"tests/fixtures/oelib.html";s:4:"59ca";s:23:"tests/fixtures/test.css";s:4:"0acf";s:23:"tests/fixtures/test.png";s:4:"c7b6";s:25:"tests/fixtures/test_2.css";s:4:"4a4a";s:33:"tests/fixtures/user_oelibtest.t3x";s:4:"e80d";s:34:"tests/fixtures/user_oelibtest2.t3x";s:4:"56c7";s:69:"tests/fixtures/pi1/class.tx_oelib_tests_fixtures_pi1_NotIncluded1.php";s:4:"34d7";s:64:"tests/fixtures/xclass/class.ux_tx_oelib_tests_fixtures_Empty.php";s:4:"530f";}',
	'constraints' => array(
		'depends' => array(
			'php' => '5.2.0-0.0.0',
			'typo3' => '4.3.0-0.0.0',
			'static_info_tables' => '2.0.8-',
		),
		'conflicts' => array(
		),
		'suggests' => array(
			'extbase' => '1.3.0-0.0.0',
			'fluid' => '1.3.0-0.0.0',
		),
	),
	'suggests' => array(
		'extbase' => '1.3.0-0.0.0',
		'fluid' => '1.3.0-0.0.0',
	),
);

?>