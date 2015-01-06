<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "oelib".
 *
 * Auto generated 06-01-2015 19:56
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

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
	'author_company' => 'oliverklee.de',
	'version' => '0.8.0',
	'_md5_values_when_last_written' => 'a:244:{s:13:"changelog.txt";s:4:"4c80";s:29:"class.tx_oelib_Autoloader.php";s:4:"6066";s:16:"ext_autoload.php";s:4:"0c5e";s:12:"ext_icon.gif";s:4:"b4bf";s:17:"ext_localconf.php";s:4:"9d3c";s:14:"ext_tables.php";s:4:"84ba";s:14:"ext_tables.sql";s:4:"2cf2";s:11:"LICENSE.txt";s:4:"b234";s:31:"Classes/AbstractHeaderProxy.php";s:4:"de29";s:26:"Classes/AbstractMailer.php";s:4:"de85";s:22:"Classes/Attachment.php";s:4:"04a1";s:31:"Classes/BackEndLoginManager.php";s:4:"c7c8";s:27:"Classes/CommonConstants.php";s:4:"9b14";s:23:"Classes/ConfigCheck.php";s:4:"90c1";s:25:"Classes/Configuration.php";s:4:"a021";s:30:"Classes/ConfigurationProxy.php";s:4:"7bd4";s:33:"Classes/ConfigurationRegistry.php";s:4:"0e42";s:22:"Classes/DataMapper.php";s:4:"fd39";s:14:"Classes/Db.php";s:4:"e9c6";s:28:"Classes/Double3Validator.php";s:4:"c8ea";s:26:"Classes/EmailCollector.php";s:4:"b205";s:23:"Classes/FakeSession.php";s:4:"cff1";s:25:"Classes/FileFunctions.php";s:4:"0db0";s:32:"Classes/FrontEndLoginManager.php";s:4:"0179";s:27:"Classes/HeaderCollector.php";s:4:"cd37";s:30:"Classes/HeaderProxyFactory.php";s:4:"da5a";s:23:"Classes/IdentityMap.php";s:4:"b325";s:16:"Classes/List.php";s:4:"faf7";s:16:"Classes/Mail.php";s:4:"d762";s:25:"Classes/MailerFactory.php";s:4:"0d38";s:26:"Classes/MapperRegistry.php";s:4:"61c7";s:17:"Classes/Model.php";s:4:"a3e8";s:18:"Classes/Object.php";s:4:"b525";s:25:"Classes/ObjectFactory.php";s:4:"979a";s:22:"Classes/PageFinder.php";s:4:"791d";s:24:"Classes/PublicObject.php";s:4:"9f56";s:27:"Classes/RealHeaderProxy.php";s:4:"2c4f";s:22:"Classes/RealMailer.php";s:4:"f57d";s:30:"Classes/Salutationswitcher.php";s:4:"85d7";s:19:"Classes/Session.php";s:4:"62d0";s:20:"Classes/Template.php";s:4:"c745";s:26:"Classes/TemplateHelper.php";s:4:"ea8f";s:28:"Classes/TemplateRegistry.php";s:4:"44c9";s:28:"Classes/TestingFramework.php";s:4:"fb81";s:35:"Classes/TestingFrameworkCleanup.php";s:4:"f800";s:16:"Classes/Time.php";s:4:"1d5a";s:17:"Classes/Timer.php";s:4:"cbd6";s:22:"Classes/Translator.php";s:4:"0704";s:30:"Classes/TranslatorRegistry.php";s:4:"3ca1";s:34:"Classes/Exception/AccessDenied.php";s:4:"9d68";s:30:"Classes/Exception/Database.php";s:4:"abd2";s:38:"Classes/Exception/EmptyQueryResult.php";s:4:"af3c";s:30:"Classes/Exception/NotFound.php";s:4:"3f34";s:39:"Classes/FrontEnd/UserWithoutCookies.php";s:4:"572c";s:32:"Classes/Geocoding/Calculator.php";s:4:"68e6";s:27:"Classes/Geocoding/Dummy.php";s:4:"6bd9";s:28:"Classes/Geocoding/Google.php";s:4:"da89";s:29:"Classes/Interface/Address.php";s:4:"b96a";s:25:"Classes/Interface/Geo.php";s:4:"2c06";s:37:"Classes/Interface/GeocodingLookup.php";s:4:"2a65";s:30:"Classes/Interface/Identity.php";s:4:"3590";s:34:"Classes/Interface/LoginManager.php";s:4:"d4ed";s:30:"Classes/Interface/MailRole.php";s:4:"18d9";s:30:"Classes/Interface/MapPoint.php";s:4:"8119";s:30:"Classes/Interface/Sortable.php";s:4:"9a57";s:30:"Classes/Mapper/BackEndUser.php";s:4:"3138";s:35:"Classes/Mapper/BackEndUserGroup.php";s:4:"02a9";s:26:"Classes/Mapper/Country.php";s:4:"1672";s:27:"Classes/Mapper/Currency.php";s:4:"61e0";s:31:"Classes/Mapper/FederalState.php";s:4:"10fd";s:31:"Classes/Mapper/FrontEndUser.php";s:4:"e66b";s:36:"Classes/Mapper/FrontEndUserGroup.php";s:4:"66eb";s:27:"Classes/Mapper/Language.php";s:4:"3ebf";s:29:"Classes/Model/BackEndUser.php";s:4:"60e8";s:34:"Classes/Model/BackEndUserGroup.php";s:4:"9ef4";s:25:"Classes/Model/Country.php";s:4:"9a74";s:26:"Classes/Model/Currency.php";s:4:"da1a";s:30:"Classes/Model/FederalState.php";s:4:"4c9a";s:30:"Classes/Model/FrontEndUser.php";s:4:"fa3d";s:35:"Classes/Model/FrontEndUserGroup.php";s:4:"f24e";s:26:"Classes/Model/Language.php";s:4:"083f";s:28:"Classes/ViewHelper/Price.php";s:4:"1422";s:44:"Classes/ViewHelpers/GoogleMapsViewHelper.php";s:4:"7bd9";s:43:"Classes/ViewHelpers/UppercaseViewHelper.php";s:4:"bca2";s:27:"Classes/Visibility/Node.php";s:4:"b6d3";s:27:"Classes/Visibility/Tree.php";s:4:"500a";s:26:"Configuration/TCA/Test.php";s:4:"b21a";s:31:"Configuration/TCA/TestChild.php";s:4:"7899";s:38:"Configuration/TypoScript/constants.txt";s:4:"d41d";s:34:"Configuration/TypoScript/setup.txt";s:4:"5e3c";s:23:"Documentation/Index.rst";s:4:"9eff";s:37:"Documentation/Configuration/Index.rst";s:4:"9681";s:52:"Documentation/Configuration/ConfiguringCss/Index.rst";s:4:"7a73";s:53:"Documentation/DeprecatedClassesAndFunctions/Index.rst";s:4:"c5d9";s:35:"Documentation/Development/Index.rst";s:4:"09d8";s:65:"Documentation/Development/ChangesTo3SuprdPartyLibraries/Index.rst";s:4:"cf9a";s:55:"Documentation/Development/CodeStyleGuidelines/Index.rst";s:4:"1bbf";s:73:"Documentation/Development/StrategyWhenACheckinCausesARegression/Index.rst";s:4:"22dd";s:55:"Documentation/Development/WorkflowDescription/Index.rst";s:4:"8222";s:53:"Documentation/GettingInTouchWithDevelopment/Index.rst";s:4:"5e26";s:63:"Documentation/GettingInTouchWithDevelopment/FoundABug/Index.rst";s:4:"788e";s:80:"Documentation/GettingInTouchWithDevelopment/GettingTheExtensionFromGit/Index.rst";s:4:"3c67";s:36:"Documentation/Introduction/Index.rst";s:4:"a703";s:44:"Documentation/Introduction/Credits/Index.rst";s:4:"34af";s:45:"Documentation/Introduction/Examples/Index.rst";s:4:"e420";s:48:"Documentation/Introduction/KeyFeatures/Index.rst";s:4:"569c";s:55:"Documentation/Introduction/SystemRequirements/Index.rst";s:4:"6334";s:49:"Documentation/Introduction/WhatDoesItDo/Index.rst";s:4:"e0ce";s:33:"Documentation/Reference/Index.rst";s:4:"8181";s:67:"Documentation/Reference/SuffixesForLocalizationStringKeys/Index.rst";s:4:"dc08";s:32:"Documentation/Tutorial/Index.rst";s:4:"6757";s:53:"Documentation/Tutorial/MeasuringPerformance/Index.rst";s:4:"09c1";s:71:"Documentation/Tutorial/SendE-mailsAndTestThemInsteadOfSending/Index.rst";s:4:"082c";s:83:"Documentation/Tutorial/StoreHttpHeadersForTestingThemInsteadOfSendingThem/Index.rst";s:4:"13af";s:63:"Documentation/Tutorial/UsingAndPersistingDomainModels/Index.rst";s:4:"eb37";s:62:"Documentation/Tutorial/UsingLocallangxmlInTheBackEnd/Index.rst";s:4:"b714";s:81:"Documentation/Tutorial/UsingTheAutomaticConfigurationCheckForExtensions/Index.rst";s:4:"c325";s:59:"Documentation/Tutorial/UsingTheConfigurationProxy/Index.rst";s:4:"e074";s:56:"Documentation/Tutorial/UsingThePriceViewHelper/Index.rst";s:4:"05e7";s:59:"Documentation/Tutorial/UsingTheSessionAbstraction/Index.rst";s:4:"5d71";s:77:"Documentation/Tutorial/UsingTheTemplateHelperAndSalutationSwitching/Index.rst";s:4:"8663";s:69:"Documentation/Tutorial/UsingTheTestingFrameworkForUnitTests/Index.rst";s:4:"6e7d";s:88:"Documentation/Tutorial/UsingTheVisibilityTreeForShowingAndHidingNestedSubparts/Index.rst";s:4:"e800";s:22:"Packages/composer.json";s:4:"4751";s:22:"Packages/composer.lock";s:4:"8f52";s:28:"Packages/vendor/autoload.php";s:4:"480d";s:46:"Packages/vendor/composer/autoload_classmap.php";s:4:"8645";s:48:"Packages/vendor/composer/autoload_namespaces.php";s:4:"35e1";s:42:"Packages/vendor/composer/autoload_psr4.php";s:4:"97ed";s:42:"Packages/vendor/composer/autoload_real.php";s:4:"f9ae";s:40:"Packages/vendor/composer/ClassLoader.php";s:4:"e175";s:39:"Packages/vendor/composer/installed.json";s:4:"d7ef";s:47:"Packages/vendor/pelago/emogrifier/CHANGELOG.TXT";s:4:"7549";s:47:"Packages/vendor/pelago/emogrifier/composer.json";s:4:"b526";s:41:"Packages/vendor/pelago/emogrifier/LICENSE";s:4:"b7aa";s:43:"Packages/vendor/pelago/emogrifier/README.md";s:4:"d910";s:56:"Packages/vendor/pelago/emogrifier/Classes/Emogrifier.php";s:4:"3c33";s:95:"Packages/vendor/pelago/emogrifier/Configuration/PhpCodeSniffer/Standards/Emogrifier/ruleset.xml";s:4:"9aac";s:63:"Packages/vendor/pelago/emogrifier/Tests/Unit/EmogrifierTest.php";s:4:"602f";s:40:"Resources/Private/Language/locallang.xml";s:4:"0494";s:43:"Resources/Private/Language/locallang_db.xml";s:4:"a70b";s:31:"Resources/Public/Icons/Test.gif";s:4:"bd58";s:44:"TestExtensions/user_oelibtest/ext_emconf.php";s:4:"0abf";s:42:"TestExtensions/user_oelibtest/ext_icon.gif";s:4:"b4bf";s:44:"TestExtensions/user_oelibtest/ext_tables.php";s:4:"e3c3";s:44:"TestExtensions/user_oelibtest/ext_tables.sql";s:4:"a0a5";s:58:"TestExtensions/user_oelibtest/icon_user_oelibtest_test.gif";s:4:"475a";s:46:"TestExtensions/user_oelibtest/locallang_db.xml";s:4:"32f9";s:37:"TestExtensions/user_oelibtest/tca.php";s:4:"bc13";s:45:"TestExtensions/user_oelibtest2/ext_emconf.php";s:4:"51b6";s:43:"TestExtensions/user_oelibtest2/ext_icon.gif";s:4:"b4bf";s:45:"TestExtensions/user_oelibtest2/ext_tables.php";s:4:"fed2";s:45:"TestExtensions/user_oelibtest2/ext_tables.sql";s:4:"e709";s:60:"TestExtensions/user_oelibtest2/icon_user_oelibtest2_test.gif";s:4:"475a";s:47:"TestExtensions/user_oelibtest2/locallang_db.xml";s:4:"717d";s:38:"TestExtensions/user_oelibtest2/tca.php";s:4:"b1a1";s:33:"Tests/Unit/AbstractMailerTest.php";s:4:"ccb3";s:29:"Tests/Unit/AttachmentTest.php";s:4:"d81d";s:29:"Tests/Unit/AutoloaderTest.php";s:4:"4b70";s:38:"Tests/Unit/BackEndLoginManagerTest.php";s:4:"9c68";s:30:"Tests/Unit/ConfigCheckTest.php";s:4:"10b1";s:37:"Tests/Unit/ConfigurationProxyTest.php";s:4:"0e62";s:40:"Tests/Unit/ConfigurationRegistryTest.php";s:4:"b17b";s:32:"Tests/Unit/ConfigurationTest.php";s:4:"be0a";s:29:"Tests/Unit/DataMapperTest.php";s:4:"51b8";s:21:"Tests/Unit/DbTest.php";s:4:"c051";s:35:"Tests/Unit/Double3ValidatorTest.php";s:4:"ad24";s:30:"Tests/Unit/FakeSessionTest.php";s:4:"7c08";s:39:"Tests/Unit/FrontEndLoginManagerTest.php";s:4:"218b";s:37:"Tests/Unit/HeaderProxyFactoryTest.php";s:4:"1a5d";s:30:"Tests/Unit/IdentityMapTest.php";s:4:"fb97";s:23:"Tests/Unit/ListTest.php";s:4:"c579";s:32:"Tests/Unit/MailerFactoryTest.php";s:4:"a7bb";s:23:"Tests/Unit/MailTest.php";s:4:"d5ce";s:33:"Tests/Unit/MapperRegistryTest.php";s:4:"bfda";s:24:"Tests/Unit/ModelTest.php";s:4:"fb69";s:32:"Tests/Unit/ObjectFactoryTest.php";s:4:"c779";s:25:"Tests/Unit/ObjectTest.php";s:4:"0732";s:29:"Tests/Unit/PageFinderTest.php";s:4:"0c4b";s:29:"Tests/Unit/PhpMyAdminTest.php";s:4:"8b54";s:29:"Tests/Unit/RealMailerTest.php";s:4:"d5f4";s:37:"Tests/Unit/SalutationSwitcherTest.php";s:4:"77af";s:26:"Tests/Unit/SessionTest.php";s:4:"8dd3";s:33:"Tests/Unit/TemplateHelperTest.php";s:4:"d2a3";s:35:"Tests/Unit/TemplateRegistryTest.php";s:4:"37cc";s:27:"Tests/Unit/TemplateTest.php";s:4:"1ae7";s:35:"Tests/Unit/TestingFrameworkTest.php";s:4:"a218";s:24:"Tests/Unit/TimerTest.php";s:4:"7cab";s:37:"Tests/Unit/TranslatorRegistryTest.php";s:4:"5ad9";s:29:"Tests/Unit/TranslatorTest.php";s:4:"7773";s:37:"Tests/Unit/Exception/DatabaseTest.php";s:4:"b29b";s:45:"Tests/Unit/Exception/EmptyQueryResultTest.php";s:4:"0b6f";s:70:"Tests/Unit/Fixtures/class.tx_oelib_Tests_Unit_Fixtures_NotIncluded.php";s:4:"077e";s:76:"Tests/Unit/Fixtures/class.Tx_Oelib_Tests_Unit_Fixtures_NotIncludedEither.php";s:4:"bdc0";s:84:"Tests/Unit/Fixtures/class.Tx_oelib_Tests_Unit_Fixtures_NotIncludedFirstUppercase.php";s:4:"05d1";s:91:"Tests/Unit/Fixtures/class.Tx_Oelib_Tests_Unit_Fixtures_NotIncludedUppercaseExtensionKey.php";s:4:"b261";s:47:"Tests/Unit/Fixtures/ColumnLessTestingMapper.php";s:4:"828b";s:42:"Tests/Unit/Fixtures/DummyObjectToCheck.php";s:4:"6b7d";s:29:"Tests/Unit/Fixtures/Empty.php";s:4:"4d13";s:33:"Tests/Unit/Fixtures/locallang.xml";s:4:"c52b";s:46:"Tests/Unit/Fixtures/ModelLessTestingMapper.php";s:4:"e680";s:30:"Tests/Unit/Fixtures/oelib.html";s:4:"59ca";s:37:"Tests/Unit/Fixtures/ReadOnlyModel.php";s:4:"8b83";s:46:"Tests/Unit/Fixtures/TableLessTestingMapper.php";s:4:"eb45";s:28:"Tests/Unit/Fixtures/test.css";s:4:"0acf";s:28:"Tests/Unit/Fixtures/test.png";s:4:"c7b6";s:28:"Tests/Unit/Fixtures/test.txt";s:4:"552e";s:30:"Tests/Unit/Fixtures/test_2.css";s:4:"4a4a";s:42:"Tests/Unit/Fixtures/TestingChildMapper.php";s:4:"5b59";s:41:"Tests/Unit/Fixtures/TestingChildModel.php";s:4:"8a5c";s:34:"Tests/Unit/Fixtures/TestingGeo.php";s:4:"4fb2";s:39:"Tests/Unit/Fixtures/TestingMailRole.php";s:4:"41b4";s:37:"Tests/Unit/Fixtures/TestingMapper.php";s:4:"1e7c";s:39:"Tests/Unit/Fixtures/TestingMapPoint.php";s:4:"603f";s:36:"Tests/Unit/Fixtures/TestingModel.php";s:4:"f0be";s:37:"Tests/Unit/Fixtures/TestingObject.php";s:4:"c7a7";s:49:"Tests/Unit/Fixtures/TestingSalutationSwitcher.php";s:4:"85c3";s:45:"Tests/Unit/Fixtures/TestingTemplateHelper.php";s:4:"b73f";s:36:"Tests/Unit/Fixtures/Xclass/Empty.php";s:4:"fd0c";s:79:"Tests/Unit/Fixtures/pi1/class.Tx_Oelib_Tests_Unit_Fixtures_pi1_NotIncluded1.php";s:4:"8430";s:39:"Tests/Unit/Geocoding/CalculatorTest.php";s:4:"95d6";s:34:"Tests/Unit/Geocoding/DummyTest.php";s:4:"317f";s:35:"Tests/Unit/Geocoding/GoogleTest.php";s:4:"9167";s:42:"Tests/Unit/Mapper/BackEndUserGroupTest.php";s:4:"8eb5";s:37:"Tests/Unit/Mapper/BackEndUserTest.php";s:4:"3d20";s:33:"Tests/Unit/Mapper/CountryTest.php";s:4:"8c51";s:34:"Tests/Unit/Mapper/CurrencyTest.php";s:4:"80a6";s:38:"Tests/Unit/Mapper/FederalStateTest.php";s:4:"edc1";s:43:"Tests/Unit/Mapper/FrontEndUserGroupTest.php";s:4:"3be3";s:38:"Tests/Unit/Mapper/FrontEndUserTest.php";s:4:"684a";s:34:"Tests/Unit/Mapper/LanguageTest.php";s:4:"a6ff";s:41:"Tests/Unit/Model/BackEndUserGroupTest.php";s:4:"41da";s:36:"Tests/Unit/Model/BackEndUserTest.php";s:4:"4e37";s:32:"Tests/Unit/Model/CountryTest.php";s:4:"e5da";s:33:"Tests/Unit/Model/CurrencyTest.php";s:4:"9ce9";s:37:"Tests/Unit/Model/FederalStateTest.php";s:4:"fb56";s:42:"Tests/Unit/Model/FrontEndUserGroupTest.php";s:4:"2475";s:37:"Tests/Unit/Model/FrontEndUserTest.php";s:4:"12df";s:33:"Tests/Unit/Model/LanguageTest.php";s:4:"b96c";s:35:"Tests/Unit/ViewHelper/PriceTest.php";s:4:"cc58";s:51:"Tests/Unit/ViewHelpers/GoogleMapsViewHelperTest.php";s:4:"2c26";s:50:"Tests/Unit/ViewHelpers/UppercaseViewHelperTest.php";s:4:"4b6f";s:34:"Tests/Unit/Visibility/NodeTest.php";s:4:"f80b";s:34:"Tests/Unit/Visibility/TreeTest.php";s:4:"ba32";}',
	'constraints' => array(
		'depends' => array(
			'php' => '5.3.0-5.6.99',
			'typo3' => '4.5.0-6.2.99',
			'static_info_tables' => '2.0.8-',
		),
		'conflicts' => array(
		),
		'suggests' => array(
			'extbase' => '1.3.0-6.2.99',
		),
	),
	'suggests' => array(
	),
);