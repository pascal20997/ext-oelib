<?php

use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * Test case.
 *
 * @author Oliver Klee <typo3-coding@oliverklee.de>
 * @author Niels Pardon <mail@niels-pardon.de>
 */
class Tx_Oelib_Tests_Unit_TemplateHelperTest extends \Tx_Phpunit_TestCase
{
    /**
     * @var \Tx_Oelib_Tests_Unit_Fixtures_TestingTemplateHelper
     */
    protected $subject = null;
    /**
     * @var \Tx_Oelib_TestingFramework
     */
    protected $testingFramework = null;

    /**
     * @var bool
     */
    protected $deprecationLogEnabledBackup = false;

    protected function setUp()
    {
        $this->deprecationLogEnabledBackup = $GLOBALS['TYPO3_CONF_VARS']['SYS']['enableDeprecationLog'];

        $this->testingFramework = new \Tx_Oelib_TestingFramework('tx_oelib');
        $pageUid = $this->testingFramework->createFrontEndPage(0);
        $this->testingFramework->createFakeFrontEnd($pageUid);
        \Tx_Oelib_ConfigurationProxy::getInstance('oelib')->setAsBoolean('enableConfigCheck', true);

        $this->subject = new \Tx_Oelib_Tests_Unit_Fixtures_TestingTemplateHelper([]);
    }

    protected function tearDown()
    {
        $this->testingFramework->cleanUp();

        $GLOBALS['TYPO3_CONF_VARS']['SYS']['enableDeprecationLog'] = $this->deprecationLogEnabledBackup;
    }

    /////////////////////////////////////////////////////////////////
    // Tests concerning the creation of the template helper object.
    /////////////////////////////////////////////////////////////////

    /**
     * @test
     */
    public function configurationCheckCreationForEnabledConfigurationCheck()
    {
        // This test relies on the config check to be enabled during setUp().
        self::assertNotNull(
            $this->subject->getConfigurationCheck()
        );
    }

    /**
     * @test
     */
    public function configurationCheckCreationForDisabledConfigurationCeck()
    {
        \Tx_Oelib_ConfigurationProxy::getInstance('oelib')
            ->setAsBoolean('enableConfigCheck', false);
        $subject = new \Tx_Oelib_Tests_Unit_Fixtures_TestingTemplateHelper();
        $result = $subject->getConfigurationCheck();

        self::assertNull(
            $result
        );
    }

    /////////////////////////////////////////////////////////////
    // Tests concerning using the template without an HTML file
    /////////////////////////////////////////////////////////////

    /**
     * @test
     */
    public function processTemplateWithoutTemplateFileDoesNotThrowException()
    {
        $this->subject->processTemplate('foo');
    }

    /**
     * @test
     */
    public function processTemplateTwoTimesWillUseTheLastSetTemplate()
    {
        $this->subject->processTemplate('foo');
        $this->subject->processTemplate('bar');

        self::assertSame(
            'bar',
            $this->subject->getSubpart()
        );
    }

    ///////////////////////////////////////////////////////////////////////
    // Tests for the behavior of the template helper without a front end.
    ///////////////////////////////////////////////////////////////////////

    /**
     * @test
     */
    public function initMarksObjectAsInitialized()
    {
        $this->subject->init();

        self::assertTrue(
            $this->subject->isInitialized()
        );
    }

    /**
     * @test
     */
    public function initInitializesContentObjectRenderer()
    {
        $this->subject->init();

        self::assertInstanceOf(ContentObjectRenderer::class, $this->subject->cObj);
    }

    ////////////////////////////////////////////////////////
    // Tests for setting and reading configuration values.
    ////////////////////////////////////////////////////////

    /**
     * @test
     */
    public function setCachedConfigurationValueCreatesConfigurationForNewInstance()
    {
        $this->testingFramework->discardFakeFrontEnd();

        \Tx_Oelib_TemplateHelper::setCachedConfigurationValue('foo', 'bar');

        $subject = new \Tx_Oelib_TemplateHelper();
        $subject->init();

        self::assertSame(
            'bar',
            $subject->getConfValueString('foo')
        );
    }

    /**
     * @test
     */
    public function purgeCachedConfigurationsDropsCachedConfiguration()
    {
        $this->testingFramework->discardFakeFrontEnd();

        \Tx_Oelib_TemplateHelper::setCachedConfigurationValue('foo', 'bar');
        \Tx_Oelib_TemplateHelper::purgeCachedConfigurations();

        $subject = new \Tx_Oelib_TemplateHelper();
        $subject->init();

        self::assertSame(
            '',
            $subject->getConfValueString('foo')
        );
    }

    /**
     * @test
     */
    public function configurationInitiallyIsAnEmptyArray()
    {
        self::assertSame(
            [],
            $this->subject->getConfiguration()
        );
    }

    /**
     * @test
     */
    public function setConfigurationValueFailsWithAnEmptyKey()
    {
        $this->setExpectedException(
            'InvalidArgumentException',
            '$key must not be empty'
        );

        $this->subject->setConfigurationValue('', 'test');
    }

    /**
     * @test
     */
    public function setConfigurationValueWithNonEmptyStringChangesTheConfiguration()
    {
        $this->subject->setConfigurationValue('test', 'This is a test.');
        self::assertSame(
            ['test' => 'This is a test.'],
            $this->subject->getConfiguration()
        );
    }

    /**
     * @test
     */
    public function setConfigurationValueWithEmptyStringChangesTheConfiguration()
    {
        $this->subject->setConfigurationValue('test', '');
        self::assertSame(
            ['test' => ''],
            $this->subject->getConfiguration()
        );
    }

    /**
     * @test
     */
    public function setConfigurationValueStringNotEmpty()
    {
        $this->subject->setConfigurationValue('test', 'This is a test.');
        self::assertSame(
            'This is a test.',
            $this->subject->getConfValueString('test')
        );
    }

    /**
     * @test
     */
    public function getListViewConfigurationValueStringReturnsAString()
    {
        $this->subject->setConfigurationValue(
            'listView.',
            ['test' => 'This is a test.']
        );

        self::assertSame(
            'This is a test.',
            $this->subject->getListViewConfValueString('test')
        );
    }

    /**
     * @test
     */
    public function getListViewConfigurationValueStringReturnsATrimmedString()
    {
        $this->subject->setConfigurationValue(
            'listView.',
            ['test' => ' string ']
        );

        self::assertSame(
            'string',
            $this->subject->getListViewConfValueString('test')
        );
    }

    /**
     * @test
     */
    public function getListViewConfigurationValueStringReturnsEmptyStringWhichWasSet()
    {
        $this->subject->setConfigurationValue(
            'listView.',
            ['test' => '']
        );

        self::assertSame(
            '',
            $this->subject->getListViewConfValueString('test')
        );
    }

    /**
     * @test
     */
    public function getListViewConfigurationValueStringReturnsEmptyStringIfNoValueSet()
    {
        $this->subject->setConfigurationValue(
            'listView.',
            []
        );

        self::assertSame(
            '',
            $this->subject->getListViewConfValueString('test')
        );
    }

    /**
     * @test
     */
    public function getListViewConfigurationValueIntegerReturnsNumber()
    {
        $this->subject->setConfigurationValue(
            'listView.',
            ['test' => '123']
        );

        self::assertSame(
            123,
            $this->subject->getListViewConfValueInteger('test')
        );
    }

    /**
     * @test
     */
    public function getListViewConfigurationValueIntegerReturnsZeroIfTheValueWasEmpty()
    {
        $this->subject->setConfigurationValue(
            'listView.',
            ['test' => '']
        );

        self::assertSame(
            0,
            $this->subject->getListViewConfValueInteger('test')
        );
    }

    /**
     * @test
     */
    public function getListViewConfigurationValueIntegerReturnsZeroIfTheValueWasNoInteger()
    {
        $this->subject->setConfigurationValue(
            'listView.',
            ['test' => 'string']
        );

        self::assertSame(
            0,
            $this->subject->getListViewConfValueInteger('test')
        );
    }

    /**
     * @test
     */
    public function getListViewConfigurationValueIntegerReturnsZeroIfNoValueWasSet()
    {
        $this->subject->setConfigurationValue(
            'listView.',
            []
        );

        self::assertSame(
            0,
            $this->subject->getListViewConfValueInteger('test')
        );
    }

    /**
     * @test
     */
    public function getListViewConfigurationValueBooleanReturnsTrue()
    {
        $this->subject->setConfigurationValue(
            'listView.',
            ['test' => '1']
        );

        self::assertTrue(
            $this->subject->getListViewConfValueBoolean('test')
        );
    }

    /**
     * @test
     */
    public function getListViewConfigurationValueBooleanReturnsTrueIfTheValueWasAPositiveInteger()
    {
        $this->subject->setConfigurationValue(
            'listView.',
            ['test' => '123']
        );

        self::assertTrue(
            $this->subject->getListViewConfValueBoolean('test')
        );
    }

    /**
     * @test
     */
    public function getListViewConfigurationValueBooleanReturnsFalseIfTheValueWasZero()
    {
        $this->subject->setConfigurationValue(
            'listView.',
            ['test' => '0']
        );

        self::assertFalse(
            $this->subject->getListViewConfValueBoolean('test')
        );
    }

    /**
     * @test
     */
    public function getListViewConfigurationValueBooleanReturnsFalseIfTheValueWasAnEmptyString()
    {
        $this->subject->setConfigurationValue(
            'listView.',
            ['test' => '']
        );

        self::assertFalse(
            $this->subject->getListViewConfValueBoolean('test')
        );
    }

    /**
     * @test
     */
    public function getListViewConfigurationValueBooleanReturnsFalseIfTheValueWasNotSet()
    {
        $this->subject->setConfigurationValue(
            'listView.',
            []
        );

        self::assertFalse(
            $this->subject->getListViewConfValueBoolean('test')
        );
    }

    /**
     * @test
     */
    public function getListViewConfigurationValueThrowsAnExeptionIfNoFieldNameWasProvided()
    {
        $this->setExpectedException(
            'InvalidArgumentException',
            '$fieldName must not be empty.'
        );

        $this->subject->getListViewConfValueBoolean('');
    }

    ////////////////////////////////////////////
    // Tests for reading the HTML from a file.
    ////////////////////////////////////////////

    /**
     * @test
     */
    public function getCompleteTemplateFromFile()
    {
        $this->subject->setConfigurationValue('templateFile', 'EXT:oelib/Tests/Unit/Fixtures/oelib.html');
        $this->subject->getTemplateCode(true);

        self::assertSame(
            'Hello world!' . LF,
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    ///////////////////////////////
    // Tests for getting subparts.
    ///////////////////////////////

    /**
     * @test
     */
    public function noSubpartsAndEmptySubpartName()
    {
        self::assertSame(
            '',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function notExistingSubpartName()
    {
        self::assertSame(
            '',
            $this->subject->getSubpart('FOOBAR')
        );
        self::assertContains(
            'The subpart',
            $this->subject->getWrappedConfigCheckMessage()
        );
        self::assertContains(
            'is missing',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function getCompleteTemplateReturnsCompleteTemplateContent()
    {
        $templateCode = 'This is a test including' . LF . 'a linefeed.' . LF;
        $this->subject->processTemplate(
            $templateCode
        );
        self::assertSame(
            $templateCode,
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function getCompleteTemplateCanContainUtf8Umlauts()
    {
        $this->subject->processTemplate('äöüßÄÖÜßéèáàóò');

        self::assertSame(
            'äöüßÄÖÜßéèáàóò',
            $this->subject->getSubpart()
        );
    }

    /**
     * @test
     */
    public function getCompleteTemplateCanContainIso88591Umlauts()
    {
        // 228 = ä, 223 = ß (in ISO8859-1)
        $this->subject->processTemplate(chr(228) . chr(223));

        self::assertSame(
            chr(228) . chr(223),
            $this->subject->getSubpart()
        );
    }

    /**
     * @test
     */
    public function getCompleteTemplateWithComment()
    {
        $templateCode = 'This is a test including a comment. '
            . '<!-- This is a comment. -->'
            . 'And some more text.';
        $this->subject->processTemplate(
            $templateCode
        );
        self::assertSame(
            $templateCode,
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function getSimpleSubpart()
    {
        $subpartContent = 'Subpart content';
        $templateCode = 'Text before the subpart'
            . '<!-- ###MY_SUBPART### -->'
            . $subpartContent
            . '<!-- ###MY_SUBPART### -->'
            . 'Text after the subpart.';
        $this->subject->processTemplate(
            $templateCode
        );
        self::assertSame(
            $subpartContent,
            $this->subject->getSubpart('MY_SUBPART')
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function getSubpartFromTemplateCanContainUtf8Umlauts()
    {
        $this->subject->processTemplate(
            '<!-- ###MY_SUBPART### -->' .
            'äöüßÄÖÜßéèáàóò' .
            '<!-- ###MY_SUBPART### -->'
        );

        self::assertSame(
            'äöüßÄÖÜßéèáàóò',
            $this->subject->getSubpart('MY_SUBPART')
        );
    }

    /**
     * @test
     */
    public function getSubpartFromTemplateCanContainIso88591Umlauts()
    {
        // 228 = ä, 223 = ß (in ISO8859-1)
        $this->subject->processTemplate(
            '<!-- ###MY_SUBPART### -->' .
            chr(228) . chr(223) .
            '<!-- ###MY_SUBPART### -->'
        );

        self::assertSame(
            chr(228) . chr(223),
            $this->subject->getSubpart('MY_SUBPART')
        );
    }

    /**
     * @test
     */
    public function getOneOfTwoSimpleSubparts()
    {
        $subpartContent = 'Subpart content';
        $templateCode = 'Text before the subpart'
            . '<!-- ###MY_SUBPART### -->'
            . $subpartContent
            . '<!-- ###MY_SUBPART### -->'
            . 'Text inbetween.'
            . '<!-- ###ANOTHER_SUBPART### -->'
            . 'More text.'
            . '<!-- ###ANOTHER_SUBPART### -->'
            . 'Text after the subpart.';
        $this->subject->processTemplate(
            $templateCode
        );
        self::assertSame(
            $subpartContent,
            $this->subject->getSubpart('MY_SUBPART')
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function getSimpleSubpartWithLinefeed()
    {
        $subpartContent = LF . 'Subpart content' . LF;
        $templateCode = 'Text before the subpart' . LF
            . '<!-- ###MY_SUBPART### -->'
            . $subpartContent
            . '<!-- ###MY_SUBPART### -->' . LF
            . 'Text after the subpart.' . LF;
        $this->subject->processTemplate(
            $templateCode
        );
        self::assertSame(
            $subpartContent,
            $this->subject->getSubpart('MY_SUBPART')
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function getDoubleOccurringSubpart()
    {
        $subpartContent = 'Subpart content';
        $templateCode = 'Text before the subpart'
            . '<!-- ###MY_SUBPART### -->'
            . $subpartContent
            . '<!-- ###MY_SUBPART### -->'
            . 'Text inbetween.'
            . '<!-- ###MY_SUBPART### -->'
            . 'More text.'
            . '<!-- ###MY_SUBPART### -->'
            . 'Text after the subpart.';
        $this->subject->processTemplate(
            $templateCode
        );
        self::assertSame(
            $subpartContent,
            $this->subject->getSubpart('MY_SUBPART')
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function getSubpartWithNestedInnerSubparts()
    {
        $subpartContent = 'Subpart content ';
        $templateCode = 'Text before the subpart'
            . '<!-- ###MY_SUBPART### -->'
            . 'outer start, '
            . '<!-- ###OUTER_SUBPART### -->'
            . 'inner start, '
            . '<!-- ###INNER_SUBPART### -->'
            . $subpartContent
            . '<!-- ###INNER_SUBPART### -->'
            . 'inner end, '
            . '<!-- ###OUTER_SUBPART### -->'
            . 'outer end '
            . '<!-- ###MY_SUBPART### -->'
            . 'Text after the subpart.';
        $this->subject->processTemplate(
            $templateCode
        );
        self::assertSame(
            'outer start, inner start, ' . $subpartContent . 'inner end, outer end ',
            $this->subject->getSubpart('MY_SUBPART')
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function getEmptyExistingSubpart()
    {
        $this->subject->processTemplate(
            '<!-- ###MY_SUBPART### -->'
                . '<!-- ###MY_SUBPART### -->'
        );
        self::assertSame(
            '',
            $this->subject->getSubpart('MY_SUBPART')
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function getHiddenSubpart()
    {
        $this->subject->processTemplate(
            '<!-- ###MY_SUBPART### -->'
                . 'Some text. '
                . '<!-- ###MY_SUBPART### -->'
        );
        $this->subject->hideSubparts('MY_SUBPART');

        self::assertSame(
            '',
            $this->subject->getSubpart('MY_SUBPART')
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function hideSubpartsArrayAndGetHiddenSubpartReturnsEmptySubpartContent()
    {
        $this->subject->processTemplate(
            '<!-- ###MY_SUBPART### -->' .
                'Some text. ' .
                '<!-- ###MY_SUBPART### -->'
        );
        $this->subject->hideSubpartsArray(['MY_SUBPART']);

        self::assertSame(
            '',
            $this->subject->getSubpart('MY_SUBPART')
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function getSubpartWithLabelsReturnsVerbatimSubpartWithoutLabels()
    {
        $subpartContent = 'Subpart content';
        $templateCode = 'Text before the subpart'
            . '<!-- ###MY_SUBPART### -->'
            . $subpartContent
            . '<!-- ###MY_SUBPART### -->'
            . 'Text after the subpart.';

        $this->subject->processTemplate($templateCode);

        self::assertSame(
            $subpartContent,
            $this->subject->getSubpartWithLabels('MY_SUBPART')
        );
    }

    /**
     * @test
     */
    public function getSubpartWithLabelsReplacesLabelMarkersWithLabels()
    {
        $templateCode = 'Text before the subpart'
            . '<!-- ###MY_SUBPART### -->before ###LABEL_FOO### after<!-- ###MY_SUBPART### -->'
            . 'Text after the subpart.';

        $this->subject->processTemplate($templateCode);

        self::assertSame(
            'before foo after',
            $this->subject->getSubpartWithLabels('MY_SUBPART')
        );
    }

    //////////////////////////////////
    // Tests for filling in markers.
    //////////////////////////////////

    /**
     * @test
     */
    public function getInexistentMarkerWillReturnAnEmptyString()
    {
        $this->subject->processTemplate(
            'foo'
        );
        self::assertSame(
            '',
            $this->subject->getMarker('bar')
        );
    }

    /**
     * @test
     */
    public function setAndGetInexistentMarkerSucceeds()
    {
        $this->subject->processTemplate(
            'foo'
        );

        $this->subject->setMarker('bar', 'test');
        self::assertSame(
            'test',
            $this->subject->getMarker('bar')
        );
    }

    /**
     * @test
     */
    public function setAndGetExistingMarkerSucceeds()
    {
        $this->subject->processTemplate(
            '###BAR###'
        );

        $this->subject->setMarker('bar', 'test');
        self::assertSame(
            'test',
            $this->subject->getMarker('bar')
        );
    }

    /**
     * @test
     */
    public function setMarkerAndGetMarkerCanHaveUtf8UmlautsInMarkerContent()
    {
        $this->subject->processTemplate(
            '###BAR###'
        );
        $this->subject->setMarker('bar', 'äöüßÄÖÜßéèáàóò');

        self::assertSame(
            'äöüßÄÖÜßéèáàóò',
            $this->subject->getMarker('bar')
        );
    }

    /**
     * @test
     */
    public function setMarkerAndGetMarkerCanHaveIso88591UmlautsInMarkerContent()
    {
        $this->subject->processTemplate(
            '###BAR###'
        );
        // 228 = ä, 223 = ß (in ISO8859-1)
        $this->subject->setMarker('bar', chr(228) . chr(223));

        self::assertSame(
            chr(228) . chr(223),
            $this->subject->getMarker('bar')
        );
    }

    /**
     * @test
     */
    public function setLowercaseMarkerInCompleteTemplate()
    {
        $this->subject->processTemplate(
            'This is some template code. ###MARKER### More text.'
        );
        $this->subject->setMarker('marker', 'foo');
        self::assertSame(
            'This is some template code. foo More text.',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function setUppercaseMarkerInCompleteTemplate()
    {
        $this->subject->processTemplate(
            'This is some template code. ###MARKER### More text.'
        );
        $this->subject->setMarker('MARKER', 'foo');
        self::assertSame(
            'This is some template code. foo More text.',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function setLowercaseMarkerInSubpart()
    {
        $this->subject->processTemplate(
            '<!-- ###MY_SUBPART### -->'
                . 'This is some template code. ###MARKER### More text.'
                . '<!-- ###MY_SUBPART### -->'
        );
        $this->subject->setMarker('marker', 'foo');
        self::assertSame(
            'This is some template code. foo More text.',
            $this->subject->getSubpart('MY_SUBPART')
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function setUppercaseMarkerInSubpart()
    {
        $this->subject->processTemplate(
            '<!-- ###MY_SUBPART### -->'
                . 'This is some template code. ###MARKER### More text.'
                . '<!-- ###MY_SUBPART### -->'
        );
        $this->subject->setMarker('MARKER', 'foo');
        self::assertSame(
            'This is some template code. foo More text.',
            $this->subject->getSubpart('MY_SUBPART')
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function setDoubleMarkerInSubpart()
    {
        $this->subject->processTemplate(
            '<!-- ###MY_SUBPART### -->'
                . '###MARKER### This is some template code. ###MARKER### More text.'
                . '<!-- ###MY_SUBPART### -->'
        );
        $this->subject->setMarker('marker', 'foo');
        self::assertSame(
            'foo This is some template code. foo More text.',
            $this->subject->getSubpart('MY_SUBPART')
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function setMarkerInCompleteTemplateTwoTimes()
    {
        $this->subject->processTemplate(
            'This is some template code. ###MARKER### More text.'
        );

        $this->subject->setMarker('marker', 'foo');
        self::assertSame(
            'This is some template code. foo More text.',
            $this->subject->getSubpart()
        );

        $this->subject->setMarker('marker', 'bar');
        self::assertSame(
            'This is some template code. bar More text.',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function setMarkerInSubpartTwoTimes()
    {
        $this->subject->processTemplate(
            '<!-- ###MY_SUBPART### -->'
                . 'This is some template code. ###MARKER### More text.'
                . '<!-- ###MY_SUBPART### -->'
        );

        $this->subject->setMarker('marker', 'foo');
        self::assertSame(
            'This is some template code. foo More text.',
            $this->subject->getSubpart('MY_SUBPART')
        );

        $this->subject->setMarker('marker', 'bar');
        self::assertSame(
            'This is some template code. bar More text.',
            $this->subject->getSubpart('MY_SUBPART')
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function markerNamesArePrefixesBothUsed()
    {
        $this->subject->processTemplate(
            '###MY_MARKER### ###MY_MARKER_TOO###'
        );

        $this->subject->setMarker('my_marker', 'foo');
        $this->subject->setMarker('my_marker_too', 'bar');
        self::assertSame(
            'foo bar',
            $this->subject->getSubpart('')
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function markerNamesAreSuffixesBothUsed()
    {
        $this->subject->processTemplate(
            '###MY_MARKER### ###ALSO_MY_MARKER###'
        );

        $this->subject->setMarker('my_marker', 'foo');
        $this->subject->setMarker('also_my_marker', 'bar');
        self::assertSame(
            'foo bar',
            $this->subject->getSubpart('')
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function markerNamesArePrefixesFirstUsed()
    {
        $this->subject->processTemplate(
            '###MY_MARKER### ###MY_MARKER_TOO###'
        );

        $this->subject->setMarker('my_marker', 'foo');
        self::assertSame(
            'foo ###MY_MARKER_TOO###',
            $this->subject->getSubpart('')
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function markerNamesAreSuffixesFirstUsed()
    {
        $this->subject->processTemplate(
            '###MY_MARKER### ###ALSO_MY_MARKER###'
        );

        $this->subject->setMarker('my_marker', 'foo');
        self::assertSame(
            'foo ###ALSO_MY_MARKER###',
            $this->subject->getSubpart('')
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function markerNamesArePrefixesSecondUsed()
    {
        $this->subject->processTemplate(
            '###MY_MARKER### ###MY_MARKER_TOO###'
        );

        $this->subject->setMarker('my_marker_too', 'bar');
        self::assertSame(
            '###MY_MARKER### bar',
            $this->subject->getSubpart('')
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function markerNamesAreSuffixesSecondUsed()
    {
        $this->subject->processTemplate(
            '###MY_MARKER### ###ALSO_MY_MARKER###'
        );

        $this->subject->setMarker('also_my_marker', 'bar');
        self::assertSame(
            '###MY_MARKER### bar',
            $this->subject->getSubpart('')
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function markerNamesArePrefixesBothUsedWithSubpart()
    {
        $this->subject->processTemplate(
            '<!-- ###MY_SUBPART### -->'
            . '###MY_MARKER### ###MY_MARKER_TOO###'
            . '<!-- ###MY_SUBPART### -->'
        );

        $this->subject->setMarker('my_marker', 'foo');
        $this->subject->setMarker('my_marker_too', 'bar');
        self::assertSame(
            'foo bar',
            $this->subject->getSubpart('MY_SUBPART')
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function markerNamesAreSuffixesBothUsedWithSubpart()
    {
        $this->subject->processTemplate(
            '<!-- ###MY_SUBPART### -->'
            . '###MY_MARKER### ###ALSO_MY_MARKER###'
            . '<!-- ###MY_SUBPART### -->'
        );

        $this->subject->setMarker('my_marker', 'foo');
        $this->subject->setMarker('also_my_marker', 'bar');
        self::assertSame(
            'foo bar',
            $this->subject->getSubpart('MY_SUBPART')
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    ///////////////////////////////////////////////////////////////
    // Tests for replacing subparts with their content on output.
    ///////////////////////////////////////////////////////////////

    /**
     * @test
     */
    public function getUnchangedSubpartInCompleteTemplate()
    {
        $this->subject->processTemplate(
            'This is some template code.'
                . '<!-- ###INNER_SUBPART### -->'
                . 'This is some subpart code.'
                . '<!-- ###INNER_SUBPART### -->'
                . 'More text.'
        );
        self::assertSame(
            'This is some template code.'
                . 'This is some subpart code.'
                . 'More text.',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function getUnchangedDoubleSubpartInCompleteTemplate()
    {
        $this->subject->processTemplate(
            'This is some template code.'
                . '<!-- ###INNER_SUBPART### -->'
                . 'This is some subpart code.'
                . '<!-- ###INNER_SUBPART### -->'
                . 'More text.'
                . '<!-- ###INNER_SUBPART### -->'
                . 'This is other subpart code.'
                . '<!-- ###INNER_SUBPART### -->'
                . 'Even more text.'
        );
        self::assertSame(
            'This is some template code.'
                . 'This is some subpart code.'
                . 'More text.'
                . 'This is some subpart code.'
                . 'Even more text.',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function getUnchangedSubpartInRequestedSubpart()
    {
        $this->subject->processTemplate(
            '<!-- ###MY_SUBPART### -->'
                . 'This is some template code.'
                . '<!-- ###INNER_SUBPART### -->'
                . 'This is some subpart code.'
                . '<!-- ###INNER_SUBPART### -->'
                . 'More text.'
                . '<!-- ###MY_SUBPART### -->'
        );
        self::assertSame(
            'This is some template code.'
                . 'This is some subpart code.'
                . 'More text.',
            $this->subject->getSubpart('MY_SUBPART')
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function getUnchangedDoubleSubpartInRequestedSubpart()
    {
        $this->subject->processTemplate(
            '<!-- ###MY_SUBPART### -->'
                . 'This is some template code.'
                . '<!-- ###INNER_SUBPART### -->'
                . 'This is some subpart code.'
                . '<!-- ###INNER_SUBPART### -->'
                . 'More text.'
                . '<!-- ###INNER_SUBPART### -->'
                . 'This is other subpart code.'
                . '<!-- ###INNER_SUBPART### -->'
                . 'Even more text.'
                . '<!-- ###MY_SUBPART### -->'
        );
        self::assertSame(
            'This is some template code.'
                . 'This is some subpart code.'
                . 'More text.'
                . 'This is some subpart code.'
                . 'Even more text.',
            $this->subject->getSubpart('MY_SUBPART')
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    ///////////////////////////////////////////////////////////////
    // Tests for retrieving subparts with names that are prefixes
    // or suffixes of other subpart names.
    ///////////////////////////////////////////////////////////////

    /**
     * @test
     */
    public function subpartNamesArePrefixesGetCompleteTemplate()
    {
        $this->subject->processTemplate(
            '<!-- ###MY_SUBPART### -->'
                . 'foo'
                . '<!-- ###MY_SUBPART### -->'
                . ' Some more text. '
                . '<!-- ###MY_SUBPART_TOO### -->'
                . 'bar'
                . '<!-- ###MY_SUBPART_TOO### -->'
        );
        self::assertSame(
            'foo Some more text. bar',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function subpartNamesAreSuffixesGetCompleteTemplate()
    {
        $this->subject->processTemplate(
            '<!-- ###MY_SUBPART### -->'
                . 'foo'
                . '<!-- ###MY_SUBPART### -->'
                . ' Some more text. '
                . '<!-- ###ALSO_MY_SUBPART### -->'
                . 'bar'
                . '<!-- ###ALSO_MY_SUBPART### -->'
        );
        self::assertSame(
            'foo Some more text. bar',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function subpartNamesArePrefixesGetFirstSubpart()
    {
        $this->subject->processTemplate(
            '<!-- ###MY_SUBPART### -->'
                . 'foo'
                . '<!-- ###MY_SUBPART### -->'
                . ' Some more text. '
                . '<!-- ###MY_SUBPART_TOO### -->'
                . 'bar'
                . '<!-- ###MY_SUBPART_TOO### -->'
        );
        self::assertSame(
            'foo',
            $this->subject->getSubpart('MY_SUBPART')
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function subpartNamesAreSuffixesGetFirstSubpart()
    {
        $this->subject->processTemplate(
            '<!-- ###MY_SUBPART### -->'
                . 'foo'
                . '<!-- ###MY_SUBPART### -->'
                . ' Some more text. '
                . '<!-- ###ALSO_MY_SUBPART### -->'
                . 'bar'
                . '<!-- ###ALSO_MY_SUBPART### -->'
        );
        self::assertSame(
            'foo',
            $this->subject->getSubpart('MY_SUBPART')
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function subpartNamesArePrefixesGetSecondSubpart()
    {
        $this->subject->processTemplate(
            '<!-- ###MY_SUBPART### -->'
                . 'foo'
                . '<!-- ###MY_SUBPART### -->'
                . ' Some more text. '
                . '<!-- ###MY_SUBPART_TOO### -->'
                . 'bar'
                . '<!-- ###MY_SUBPART_TOO### -->'
        );
        self::assertSame(
            'bar',
            $this->subject->getSubpart('MY_SUBPART_TOO')
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function subpartNamesAreSuffixesGetSecondSubpart()
    {
        $this->subject->processTemplate(
            '<!-- ###MY_SUBPART### -->'
                . 'foo'
                . '<!-- ###MY_SUBPART### -->'
                . ' Some more text. '
                . '<!-- ###ALSO_MY_SUBPART### -->'
                . 'bar'
                . '<!-- ###ALSO_MY_SUBPART### -->'
        );
        self::assertSame(
            'bar',
            $this->subject->getSubpart('ALSO_MY_SUBPART')
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    ////////////////////////////////////////////
    // Tests for hiding and unhiding subparts.
    ////////////////////////////////////////////

    /**
     * @test
     */
    public function hideSubpartInCompleteTemplate()
    {
        $this->subject->processTemplate(
            'Some text. '
                . '<!-- ###MY_SUBPART### -->'
                . 'More text. '
                . '<!-- ###MY_SUBPART### -->'
                . 'Even more text.'
        );
        $this->subject->hideSubparts('MY_SUBPART');
        self::assertSame(
            'Some text. '
                . 'Even more text.',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function hideOverwrittenSubpartInCompleteTemplate()
    {
        $this->subject->processTemplate(
            'Some text. '
                . '<!-- ###MY_SUBPART### -->'
                . '<!-- ###MY_SUBPART### -->'
                . 'Even more text.'
        );
        $this->subject->setSubpart('MY_SUBPART', 'More text. ');
        $this->subject->hideSubparts('MY_SUBPART');
        self::assertSame(
            'Some text. '
                . 'Even more text.',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function unhideSubpartInCompleteTemplate()
    {
        $this->subject->processTemplate(
            'Some text. '
                . '<!-- ###MY_SUBPART### -->'
                . 'More text. '
                . '<!-- ###MY_SUBPART### -->'
                . 'Even more text.'
        );
        $this->subject->unhideSubparts('MY_SUBPART');
        self::assertSame(
            'Some text. '
                . 'More text. '
                . 'Even more text.',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function hideAndUnhideSubpartInCompleteTemplate()
    {
        $this->subject->processTemplate(
            'Some text. '
                . '<!-- ###MY_SUBPART### -->'
                . 'More text. '
                . '<!-- ###MY_SUBPART### -->'
                . 'Even more text.'
        );
        $this->subject->hideSubparts('MY_SUBPART');
        $this->subject->unhideSubparts('MY_SUBPART');
        self::assertSame(
            'Some text. '
                . 'More text. '
                . 'Even more text.',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function hideSubpartInSubpart()
    {
        $this->subject->processTemplate(
            '<!-- ###OUTER_SUBPART### -->'
                . 'Some text. '
                . '<!-- ###MY_SUBPART### -->'
                . 'More text. '
                . '<!-- ###MY_SUBPART### -->'
                . 'Even more text.'
                . '<!-- ###OUTER_SUBPART### -->'
        );
        $this->subject->hideSubparts('MY_SUBPART');
        self::assertSame(
            'Some text. '
                . 'Even more text.',
            $this->subject->getSubpart('OUTER_SUBPART')
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function twoSubpartInNestedSubpart()
    {
        $this->subject->processTemplate(
            '<!-- ###SINGLE_VIEW###  -->'
                . '<!-- ###FIELD_WRAPPER_TITLE### -->'
                . '<h3 class="seminars-item-title">Title'
                . '<!-- ###FIELD_WRAPPER_SUBTITLE### -->'
                . '<span class="seminars-item-subtitle"> - ###SUBTITLE###</span>'
                . '<!-- ###FIELD_WRAPPER_SUBTITLE### -->'
                . '</h3>'
                        . '<!-- ###FIELD_WRAPPER_TITLE### -->'
                        . '<!-- ###SINGLE_VIEW###  -->'
        );
        $this->subject->hideSubparts('FIELD_WRAPPER_SUBTITLE');
        self::assertSame(
            '<h3 class="seminars-item-title">Title'
                . '</h3>',
            $this->subject->getSubpart('SINGLE_VIEW')
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function unhideSubpartInSubpart()
    {
        $this->subject->processTemplate(
            '<!-- ###OUTER_SUBPART### -->'
                . 'Some text. '
                . '<!-- ###MY_SUBPART### -->'
                . 'More text. '
                . '<!-- ###MY_SUBPART### -->'
                . 'Even more text.'
                . '<!-- ###OUTER_SUBPART### -->'
        );
        $this->subject->unhideSubparts('MY_SUBPART');
        self::assertSame(
            'Some text. '
                . 'More text. '
                . 'Even more text.',
            $this->subject->getSubpart('OUTER_SUBPART')
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function hideAndUnhideSubpartInSubpart()
    {
        $this->subject->processTemplate(
            '<!-- ###OUTER_SUBPART### -->'
                . 'Some text. '
                . '<!-- ###MY_SUBPART### -->'
                . 'More text. '
                . '<!-- ###MY_SUBPART### -->'
                . 'Even more text.'
                . '<!-- ###OUTER_SUBPART### -->'
        );
        $this->subject->hideSubparts('MY_SUBPART');
        $this->subject->unhideSubparts('MY_SUBPART');
        self::assertSame(
            'Some text. '
                . 'More text. '
                . 'Even more text.',
            $this->subject->getSubpart('OUTER_SUBPART')
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function hideTwoSubpartsSeparately()
    {
        $this->subject->processTemplate(
            'Some text. '
                . '<!-- ###MY_SUBPART_1### -->'
                . 'More text here.'
                . '<!-- ###MY_SUBPART_1### -->'
                . '<!-- ###MY_SUBPART_2### -->'
                . 'More text there. '
                . '<!-- ###MY_SUBPART_2### -->'
                . 'Even more text.'
        );
        $this->subject->hideSubparts('MY_SUBPART_1');
        $this->subject->hideSubparts('MY_SUBPART_2');
        self::assertSame(
            'Some text. '
                . 'Even more text.',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function hideTwoSubpartsWithoutSpaceAfterComma()
    {
        $this->subject->processTemplate(
            'Some text. '
                . '<!-- ###MY_SUBPART_1### -->'
                . 'More text here.'
                . '<!-- ###MY_SUBPART_1### -->'
                . '<!-- ###MY_SUBPART_2### -->'
                . 'More text there. '
                . '<!-- ###MY_SUBPART_2### -->'
                . 'Even more text.'
        );
        $this->subject->hideSubparts('MY_SUBPART_1,MY_SUBPART_2');
        self::assertSame(
            'Some text. '
                . 'Even more text.',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function hideTwoSubpartsInReverseOrder()
    {
        $this->subject->processTemplate(
            'Some text. '
                . '<!-- ###MY_SUBPART_1### -->'
                . 'More text here.'
                . '<!-- ###MY_SUBPART_1### -->'
                . '<!-- ###MY_SUBPART_2### -->'
                . 'More text there. '
                . '<!-- ###MY_SUBPART_2### -->'
                . 'Even more text.'
        );
        $this->subject->hideSubparts('MY_SUBPART_2,MY_SUBPART_1');
        self::assertSame(
            'Some text. '
                . 'Even more text.',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function hideTwoSubpartsWithSpaceAfterComma()
    {
        $this->subject->processTemplate(
            'Some text. '
                . '<!-- ###MY_SUBPART_1### -->'
                . 'More text here.'
                . '<!-- ###MY_SUBPART_1### -->'
                . '<!-- ###MY_SUBPART_2### -->'
                . 'More text there. '
                . '<!-- ###MY_SUBPART_2### -->'
                . 'Even more text.'
        );
        $this->subject->hideSubparts('MY_SUBPART_1, MY_SUBPART_2');
        self::assertSame(
            'Some text. '
                . 'Even more text.',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function hideAndUnhideTwoSubpartsSeparately()
    {
        $this->subject->processTemplate(
            'Some text. '
                . '<!-- ###MY_SUBPART_1### -->'
                . 'More text here.'
                . '<!-- ###MY_SUBPART_1### -->'
                . '<!-- ###MY_SUBPART_2### -->'
                . 'More text there. '
                . '<!-- ###MY_SUBPART_2### -->'
                . 'Even more text.'
        );
        $this->subject->hideSubparts('MY_SUBPART_1');
        $this->subject->hideSubparts('MY_SUBPART_2');
        $this->subject->unhideSubparts('MY_SUBPART_1');
        $this->subject->unhideSubparts('MY_SUBPART_2');
        self::assertSame(
            'Some text. '
                . 'More text here.'
                . 'More text there. '
                . 'Even more text.',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function hideAndUnhideTwoSubpartsInSameOrder()
    {
        $this->subject->processTemplate(
            'Some text. '
                . '<!-- ###MY_SUBPART_1### -->'
                . 'More text here.'
                . '<!-- ###MY_SUBPART_1### -->'
                . '<!-- ###MY_SUBPART_2### -->'
                . 'More text there. '
                . '<!-- ###MY_SUBPART_2### -->'
                . 'Even more text.'
        );
        $this->subject->hideSubparts('MY_SUBPART_1,MY_SUBPART_2');
        $this->subject->unhideSubparts('MY_SUBPART_1,MY_SUBPART_2');
        self::assertSame(
            'Some text. '
                . 'More text here.'
                . 'More text there. '
                . 'Even more text.',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function hideAndUnhideTwoSubpartsInReverseOrder()
    {
        $this->subject->processTemplate(
            'Some text. '
                . '<!-- ###MY_SUBPART_1### -->'
                . 'More text here.'
                . '<!-- ###MY_SUBPART_1### -->'
                . '<!-- ###MY_SUBPART_2### -->'
                . 'More text there. '
                . '<!-- ###MY_SUBPART_2### -->'
                . 'Even more text.'
        );
        $this->subject->hideSubparts('MY_SUBPART_1,MY_SUBPART_2');
        $this->subject->unhideSubparts('MY_SUBPART_2,MY_SUBPART_1');
        self::assertSame(
            'Some text. '
                . 'More text here.'
                . 'More text there. '
                . 'Even more text.',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function hideTwoSubpartsUnhideFirst()
    {
        $this->subject->processTemplate(
            'Some text. '
                . '<!-- ###MY_SUBPART_1### -->'
                . 'More text here.'
                . '<!-- ###MY_SUBPART_1### -->'
                . '<!-- ###MY_SUBPART_2### -->'
                . 'More text there. '
                . '<!-- ###MY_SUBPART_2### -->'
                . 'Even more text.'
        );
        $this->subject->hideSubparts('MY_SUBPART_1,MY_SUBPART_2');
        $this->subject->unhideSubparts('MY_SUBPART_1');
        self::assertSame(
            'Some text. '
                . 'More text here.'
                . 'Even more text.',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function hideTwoSubpartsUnhideSecond()
    {
        $this->subject->processTemplate(
            'Some text. '
                . '<!-- ###MY_SUBPART_1### -->'
                . 'More text here.'
                . '<!-- ###MY_SUBPART_1### -->'
                . '<!-- ###MY_SUBPART_2### -->'
                . 'More text there. '
                . '<!-- ###MY_SUBPART_2### -->'
                . 'Even more text.'
        );
        $this->subject->hideSubparts('MY_SUBPART_1,MY_SUBPART_2');
        $this->subject->unhideSubparts('MY_SUBPART_2');
        self::assertSame(
            'Some text. '
                . 'More text there. '
                . 'Even more text.',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function unhidePermanentlyHiddenSubpart()
    {
        $this->subject->processTemplate(
            'Some text. '
                . '<!-- ###MY_SUBPART### -->'
                . 'More text here. '
                . '<!-- ###MY_SUBPART### -->'
                . 'Even more text.'
        );
        $this->subject->hideSubparts('MY_SUBPART');
        $this->subject->unhideSubparts('MY_SUBPART', 'MY_SUBPART');
        self::assertSame(
            'Some text. '
                . 'Even more text.',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function unhideOneOfTwoPermanentlyHiddenSubparts()
    {
        $this->subject->processTemplate(
            'Some text. '
                . '<!-- ###MY_SUBPART### -->'
                . 'More text here. '
                . '<!-- ###MY_SUBPART### -->'
                . 'Even more text.'
        );
        $this->subject->hideSubparts('MY_SUBPART');
        $this->subject->unhideSubparts('MY_SUBPART', 'MY_SUBPART,MY_OTHER_SUBPART');
        self::assertSame(
            'Some text. '
                . 'Even more text.',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function unhideSubpartAndPermanentlyHideAnother()
    {
        $this->subject->processTemplate(
            'Some text. '
                . '<!-- ###MY_SUBPART### -->'
                . 'More text here. '
                . '<!-- ###MY_SUBPART### -->'
                . 'Even more text.'
        );
        $this->subject->hideSubparts('MY_SUBPART');
        $this->subject->unhideSubparts('MY_SUBPART', 'MY_OTHER_SUBPART');
        self::assertSame(
            'Some text. '
                . 'More text here. '
                . 'Even more text.',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function unhidePermanentlyHiddenSubpartWithPrefix()
    {
        $this->subject->processTemplate(
            '<!-- ###SUBPART### -->'
                . 'Some text. '
                . '<!-- ###SUBPART### -->'
                . '<!-- ###MY_SUBPART### -->'
                . 'More text here. '
                . '<!-- ###MY_SUBPART### -->'
                . 'Even more text.'
        );
        $this->subject->hideSubparts('MY_SUBPART');
        $this->subject->unhideSubparts('SUBPART', 'SUBPART', 'MY');
        self::assertSame(
            'Some text. '
                . 'Even more text.',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function unhideOneOfTwoPermanentlyHiddenSubpartsWithPrefix()
    {
        $this->subject->processTemplate(
            '<!-- ###SUBPART### -->'
                . 'Some text. '
                . '<!-- ###SUBPART### -->'
                . '<!-- ###MY_SUBPART### -->'
                . 'More text here. '
                . '<!-- ###MY_SUBPART### -->'
                . 'Even more text.'
        );
        $this->subject->hideSubparts('MY_SUBPART');
        $this->subject->unhideSubparts('SUBPART', 'SUBPART,OTHER_SUBPART', 'MY');
        self::assertSame(
            'Some text. '
                . 'Even more text.',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function unhideSubpartAndPermanentlyHideAnotherWithPrefix()
    {
        $this->subject->processTemplate(
            '<!-- ###SUBPART### -->'
                . 'Some text. '
                . '<!-- ###SUBPART### -->'
                . '<!-- ###MY_SUBPART### -->'
                . 'More text here. '
                . '<!-- ###MY_SUBPART### -->'
                . 'Even more text.'
        );
        $this->subject->hideSubparts('MY_SUBPART');
        $this->subject->unhideSubparts('SUBPART', 'OTHER_SUBPART', 'MY');
        self::assertSame(
            'Some text. '
                . 'More text here. '
                . 'Even more text.',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function subpartIsInvisibleIfTheSubpartNameIsEmpty()
    {
        $this->subject->processTemplate(
            '<!-- ###MY_SUBPART### -->'
                . '<!-- ###MY_SUBPART### -->'
        );
        self::assertFalse(
            $this->subject->isSubpartVisible('')
        );
    }

    /**
     * @test
     */
    public function nonexistentSubpartIsInvisible()
    {
        $this->subject->processTemplate(
            '<!-- ###MY_SUBPART### -->'
                . '<!-- ###MY_SUBPART### -->'
        );
        self::assertFalse(
            $this->subject->isSubpartVisible('FOO')
        );
    }

    /**
     * @test
     */
    public function subpartIsVisibleByDefault()
    {
        $this->subject->processTemplate(
            '<!-- ###MY_SUBPART### -->'
                . '<!-- ###MY_SUBPART### -->'
        );
        self::assertTrue(
            $this->subject->isSubpartVisible('MY_SUBPART')
        );
    }

    /**
     * @test
     */
    public function subpartIsNotVisibleAfterHiding()
    {
        $this->subject->processTemplate(
            '<!-- ###MY_SUBPART### -->'
                . '<!-- ###MY_SUBPART### -->'
        );
        $this->subject->hideSubparts('MY_SUBPART');
        self::assertFalse(
            $this->subject->isSubpartVisible('MY_SUBPART')
        );
    }

    /**
     * @test
     */
    public function subpartIsVisibleAfterHidingAndUnhiding()
    {
        $this->subject->processTemplate(
            '<!-- ###MY_SUBPART### -->'
                . '<!-- ###MY_SUBPART### -->'
        );
        $this->subject->hideSubparts('MY_SUBPART');
        $this->subject->unhideSubparts('MY_SUBPART');
        self::assertTrue(
            $this->subject->isSubpartVisible('MY_SUBPART')
        );
    }

    /**
     * @test
     */
    public function getSubpartReturnsContentOfVisibleSubpartThatWasFilledWhenHidden()
    {
        $this->subject->processTemplate(
            '<!-- ###MY_SUBPART### -->' .
                '<!-- ###MY_SUBPART### -->'
        );
        $this->subject->hideSubparts('MY_SUBPART');
        $this->subject->setSubpart('MY_SUBPART', 'foo');
        $this->subject->unhideSubparts('MY_SUBPART');
        self::assertSame(
            'foo',
            $this->subject->getSubpart('MY_SUBPART')
        );
    }

    /**
     * @test
     */
    public function hideSubpartsArrayWithCompleteTemplateHidesSubpart()
    {
        $this->subject->processTemplate(
            'Some text. ' .
                '<!-- ###MY_SUBPART### -->' .
                'More text. ' .
                '<!-- ###MY_SUBPART### -->' .
                'Even more text.'
        );
        $this->subject->hideSubpartsArray(['MY_SUBPART']);
        self::assertSame(
            'Some text. ' .
            'Even more text.',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function hideSubpartsArrayWithCompleteTemplateHidesOverwrittenSubpart()
    {
        $this->subject->processTemplate(
            'Some text. ' .
                '<!-- ###MY_SUBPART### -->' .
                '<!-- ###MY_SUBPART### -->' .
                'Even more text.'
        );
        $this->subject->setSubpart('MY_SUBPART', 'More text. ');
        $this->subject->hideSubpartsArray(['MY_SUBPART']);
        self::assertSame(
            'Some text. ' .
                'Even more text.',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function unhideSubpartsArrayWithCompleteTemplateUnhidesSubpart()
    {
        $this->subject->processTemplate(
            'Some text. ' .
                '<!-- ###MY_SUBPART### -->' .
                'More text. ' .
                '<!-- ###MY_SUBPART### -->' .
                'Even more text.'
        );
        $this->subject->unhideSubpartsArray(['MY_SUBPART']);
        self::assertSame(
            'Some text. ' .
                'More text. ' .
                'Even more text.',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function hideAndUnhideSubpartsArrayWithCompleteTemplateHidesAndUnhidesSubpart()
    {
        $this->subject->processTemplate(
            'Some text. ' .
                '<!-- ###MY_SUBPART### -->' .
                'More text. ' .
                '<!-- ###MY_SUBPART### -->' .
                'Even more text.'
        );
        $this->subject->hideSubpartsArray(['MY_SUBPART']);
        $this->subject->unhideSubpartsArray(['MY_SUBPART']);
        self::assertSame(
            'Some text. ' .
                'More text. ' .
                'Even more text.',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function hideSubpartsArrayHidesSubpartInSubpart()
    {
        $this->subject->processTemplate(
            '<!-- ###OUTER_SUBPART### -->' .
                'Some text. ' .
                '<!-- ###MY_SUBPART### -->' .
                'More text. ' .
                '<!-- ###MY_SUBPART### -->' .
                'Even more text.' .
                '<!-- ###OUTER_SUBPART### -->'
        );
        $this->subject->hideSubpartsArray(['MY_SUBPART']);
        self::assertSame(
            'Some text. ' .
                'Even more text.',
            $this->subject->getSubpart('OUTER_SUBPART')
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function hideSubpartsArrayHidesSubpartInNestedSubpart()
    {
        $this->subject->processTemplate(
            '<!-- ###SINGLE_VIEW###  -->' .
                '<!-- ###FIELD_WRAPPER_TITLE### -->' .
                '<h3 class="seminars-item-title">Title' .
                '<!-- ###FIELD_WRAPPER_SUBTITLE### -->' .
                '<span class="seminars-item-subtitle"> - ###SUBTITLE###</span>' .
                '<!-- ###FIELD_WRAPPER_SUBTITLE### -->' .
                '</h3>' .
                '<!-- ###FIELD_WRAPPER_TITLE### -->' .
                '<!-- ###SINGLE_VIEW###  -->'
        );
        $this->subject->hideSubpartsArray(['FIELD_WRAPPER_SUBTITLE']);
        self::assertSame(
            '<h3 class="seminars-item-title">Title' .
                '</h3>',
            $this->subject->getSubpart('SINGLE_VIEW')
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function unhideSubpartsArrayUnhidesSubpartInSubpart()
    {
        $this->subject->processTemplate(
            '<!-- ###OUTER_SUBPART### -->' .
                'Some text. ' .
                '<!-- ###MY_SUBPART### -->' .
                'More text. ' .
                '<!-- ###MY_SUBPART### -->' .
                'Even more text.' .
                '<!-- ###OUTER_SUBPART### -->'
        );
        $this->subject->unhideSubpartsArray(['MY_SUBPART']);
        self::assertSame(
            'Some text. ' .
                'More text. ' .
                'Even more text.',
            $this->subject->getSubpart('OUTER_SUBPART')
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function hideAndUnhideSubpartsArrayHidesAndUnhidesSubpartInSubpart()
    {
        $this->subject->processTemplate(
            '<!-- ###OUTER_SUBPART### -->' .
                'Some text. ' .
                '<!-- ###MY_SUBPART### -->' .
                'More text. ' .
                '<!-- ###MY_SUBPART### -->' .
                'Even more text.' .
                '<!-- ###OUTER_SUBPART### -->'
        );
        $this->subject->hideSubpartsArray(['MY_SUBPART']);
        $this->subject->unhideSubpartsArray(['MY_SUBPART']);
        self::assertSame(
            'Some text. ' .
                'More text. ' .
                'Even more text.',
            $this->subject->getSubpart('OUTER_SUBPART')
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function hideSubpartsArrayHidesTwoSubpartsSeparately()
    {
        $this->subject->processTemplate(
            'Some text. ' .
                '<!-- ###MY_SUBPART_1### -->' .
                'More text here.' .
                '<!-- ###MY_SUBPART_1### -->' .
                '<!-- ###MY_SUBPART_2### -->' .
                'More text there. ' .
                '<!-- ###MY_SUBPART_2### -->' .
                'Even more text.'
        );
        $this->subject->hideSubpartsArray(['MY_SUBPART_1']);
        $this->subject->hideSubpartsArray(['MY_SUBPART_2']);
        self::assertSame(
            'Some text. ' .
                'Even more text.',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function hideSubpartsArrayHidesTwoSubparts()
    {
        $this->subject->processTemplate(
            'Some text. ' .
                '<!-- ###MY_SUBPART_1### -->' .
                'More text here.' .
                '<!-- ###MY_SUBPART_1### -->' .
                '<!-- ###MY_SUBPART_2### -->' .
                'More text there. ' .
                '<!-- ###MY_SUBPART_2### -->' .
                'Even more text.'
        );
        $this->subject->hideSubpartsArray(['MY_SUBPART_1', 'MY_SUBPART_2']);
        self::assertSame(
            'Some text. ' .
                'Even more text.',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function hideSubpartsArrayHidesTwoSubpartsInReverseOrder()
    {
        $this->subject->processTemplate(
            'Some text. ' .
                '<!-- ###MY_SUBPART_1### -->' .
                'More text here.' .
                '<!-- ###MY_SUBPART_1### -->' .
                '<!-- ###MY_SUBPART_2### -->' .
                'More text there. ' .
                '<!-- ###MY_SUBPART_2### -->' .
                'Even more text.'
        );
        $this->subject->hideSubpartsArray(['MY_SUBPART_2', 'MY_SUBPART_1']);
        self::assertSame(
            'Some text. ' .
                'Even more text.',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function hideAndUnhideSubpartsArrayHidesAndUnhidesTwoSubpartsSeparately()
    {
        $this->subject->processTemplate(
            'Some text. ' .
                '<!-- ###MY_SUBPART_1### -->' .
                'More text here.' .
                '<!-- ###MY_SUBPART_1### -->' .
                '<!-- ###MY_SUBPART_2### -->' .
                'More text there. ' .
                '<!-- ###MY_SUBPART_2### -->' .
                'Even more text.'
        );
        $this->subject->hideSubpartsArray(['MY_SUBPART_1']);
        $this->subject->hideSubpartsArray(['MY_SUBPART_2']);
        $this->subject->unhideSubpartsArray(['MY_SUBPART_1']);
        $this->subject->unhideSubpartsArray(['MY_SUBPART_2']);
        self::assertSame(
            'Some text. ' .
                'More text here.' .
                'More text there. ' .
                'Even more text.',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function hideAndUnhideSubpartsArrayHidesAndUnhidesTwoSubpartsInSameOrder()
    {
        $this->subject->processTemplate(
            'Some text. ' .
                '<!-- ###MY_SUBPART_1### -->' .
                'More text here.' .
                '<!-- ###MY_SUBPART_1### -->' .
                '<!-- ###MY_SUBPART_2### -->' .
                'More text there. ' .
                '<!-- ###MY_SUBPART_2### -->' .
                'Even more text.'
        );
        $this->subject->hideSubpartsArray(['MY_SUBPART_1', 'MY_SUBPART_2']);
        $this->subject->unhideSubpartsArray(['MY_SUBPART_1', 'MY_SUBPART_2']);
        self::assertSame(
            'Some text. ' .
                'More text here.' .
                'More text there. ' .
                'Even more text.',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function hideAndUnhideSubpartsArrayHidesAndUnhidesTwoSubpartsInReverseOrder()
    {
        $this->subject->processTemplate(
            'Some text. ' .
                '<!-- ###MY_SUBPART_1### -->' .
                'More text here.' .
                '<!-- ###MY_SUBPART_1### -->' .
                '<!-- ###MY_SUBPART_2### -->' .
                'More text there. ' .
                '<!-- ###MY_SUBPART_2### -->' .
                'Even more text.'
        );
        $this->subject->hideSubpartsArray(['MY_SUBPART_1', 'MY_SUBPART_2']);
        $this->subject->unhideSubpartsArray(['MY_SUBPART_2', 'MY_SUBPART_1']);
        self::assertSame(
            'Some text. ' .
                'More text here.' .
                'More text there. ' .
                'Even more text.',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function hideAndUnhideSubpartsArrayHidesTwoSubpartsAndUnhidesTheFirst()
    {
        $this->subject->processTemplate(
            'Some text. ' .
                '<!-- ###MY_SUBPART_1### -->' .
                'More text here.' .
                '<!-- ###MY_SUBPART_1### -->' .
                '<!-- ###MY_SUBPART_2### -->' .
                'More text there. ' .
                '<!-- ###MY_SUBPART_2### -->' .
                'Even more text.'
        );
        $this->subject->hideSubpartsArray(['MY_SUBPART_1', 'MY_SUBPART_2']);
        $this->subject->unhideSubpartsArray(['MY_SUBPART_1']);
        self::assertSame(
            'Some text. ' .
                'More text here.' .
                'Even more text.',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function hideAndUnhideSubpartsArrayHidesTwoSubpartsAndUnhidesTheSecond()
    {
        $this->subject->processTemplate(
            'Some text. ' .
                '<!-- ###MY_SUBPART_1### -->' .
                'More text here.' .
                '<!-- ###MY_SUBPART_1### -->' .
                '<!-- ###MY_SUBPART_2### -->' .
                'More text there. ' .
                '<!-- ###MY_SUBPART_2### -->' .
                'Even more text.'
        );
        $this->subject->hideSubpartsArray(['MY_SUBPART_1', 'MY_SUBPART_2']);
        $this->subject->unhideSubpartsArray(['MY_SUBPART_2']);
        self::assertSame(
            'Some text. ' .
                'More text there. ' .
                'Even more text.',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function hideAndUnhideSubpartsArrayHidesPermanentlyHiddenSubpart()
    {
        $this->subject->processTemplate(
            'Some text. ' .
                '<!-- ###MY_SUBPART### -->' .
                'More text here. ' .
                '<!-- ###MY_SUBPART### -->' .
                'Even more text.'
        );
        $this->subject->hideSubpartsArray(['MY_SUBPART']);
        $this->subject->unhideSubpartsArray(
            ['MY_SUBPART'],
            ['MY_SUBPART']
        );
        self::assertSame(
            'Some text. ' .
                'Even more text.',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function hideAndUnhideSubpartsArrayHidesOneOfTwoPermanentlyHiddenSubparts()
    {
        $this->subject->processTemplate(
            'Some text. ' .
                '<!-- ###MY_SUBPART### -->' .
                'More text here. ' .
                '<!-- ###MY_SUBPART### -->' .
                'Even more text.'
        );
        $this->subject->hideSubpartsArray(['MY_SUBPART']);
        $this->subject->unhideSubpartsArray(
            ['MY_SUBPART'],
            ['MY_SUBPART', 'MY_OTHER_SUBPART']
        );
        self::assertSame(
            'Some text. ' .
                'Even more text.',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function hideAndUnhideSubpartsArrayUnhidesSubpartAndPermanentlyHidesAnother()
    {
        $this->subject->processTemplate(
            'Some text. ' .
                '<!-- ###MY_SUBPART### -->' .
                'More text here. ' .
                '<!-- ###MY_SUBPART### -->' .
                'Even more text.'
        );
        $this->subject->hideSubpartsArray(['MY_SUBPART']);
        $this->subject->unhideSubpartsArray(
            ['MY_SUBPART'],
            ['MY_OTHER_SUBPART']
        );
        self::assertSame(
            'Some text. ' .
                'More text here. ' .
                'Even more text.',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function hideAndUnhideSubpartsArrayHidesPermanentlyHiddenSubpartWithPrefix()
    {
        $this->subject->processTemplate(
            '<!-- ###SUBPART### -->' .
                'Some text. ' .
                '<!-- ###SUBPART### -->' .
                '<!-- ###MY_SUBPART### -->' .
                'More text here. ' .
                '<!-- ###MY_SUBPART### -->' .
                'Even more text.'
        );
        $this->subject->hideSubpartsArray(['MY_SUBPART']);
        $this->subject->unhideSubpartsArray(
            ['SUBPART'],
            ['SUBPART'],
            'MY'
        );
        self::assertSame(
            'Some text. ' .
                'Even more text.',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function hideAndUnhideSubpartsArrayHidesOneOfTwoPermanentlyHiddenSubpartsWithPrefix()
    {
        $this->subject->processTemplate(
            '<!-- ###SUBPART### -->' .
                'Some text. ' .
                '<!-- ###SUBPART### -->' .
                '<!-- ###MY_SUBPART### -->' .
                'More text here. ' .
                '<!-- ###MY_SUBPART### -->' .
                'Even more text.'
        );
        $this->subject->hideSubpartsArray(['MY_SUBPART']);
        $this->subject->unhideSubpartsArray(
            ['SUBPART'],
            ['SUBPART', 'OTHER_SUBPART'],
            'MY'
        );
        self::assertSame(
            'Some text. ' .
                'Even more text.',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function hideAndUnhideSubpartsArrayUnhidesSubpartAndPermanentlyHidesAnotherWithPrefix()
    {
        $this->subject->processTemplate(
            '<!-- ###SUBPART### -->' .
                'Some text. ' .
                '<!-- ###SUBPART### -->' .
                '<!-- ###MY_SUBPART### -->' .
                'More text here. ' .
                '<!-- ###MY_SUBPART### -->' .
                'Even more text.'
        );
        $this->subject->hideSubpartsArray(['MY_SUBPART']);
        $this->subject->unhideSubpartsArray(
            ['SUBPART'],
            ['OTHER_SUBPART'],
            'MY'
        );
        self::assertSame(
            'Some text. ' .
                'More text here. ' .
                'Even more text.',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function hideSubpartsArrayResultsInNotVisibleSubpart()
    {
        $this->subject->processTemplate(
            '<!-- ###MY_SUBPART### -->' .
                '<!-- ###MY_SUBPART### -->'
        );
        $this->subject->hideSubpartsArray(['MY_SUBPART']);
        self::assertFalse(
            $this->subject->isSubpartVisible('MY_SUBPART')
        );
    }

    /**
     * @test
     */
    public function hideAndUnhideSubpartsArrayResultsInVisibleSubpart()
    {
        $this->subject->processTemplate(
            '<!-- ###MY_SUBPART### -->' .
                '<!-- ###MY_SUBPART### -->'
        );
        $this->subject->hideSubpartsArray(['MY_SUBPART']);
        $this->subject->unhideSubpartsArray(['MY_SUBPART']);
        self::assertTrue(
            $this->subject->isSubpartVisible('MY_SUBPART')
        );
    }

    /**
     * @test
     */
    public function hideAndUnhideSubpartsArrayWithFilledSubpartWhenHiddenReturnsContentOfUnhiddenSubpart()
    {
        $this->subject->processTemplate(
            '<!-- ###MY_SUBPART### -->' .
                '<!-- ###MY_SUBPART### -->'
        );
        $this->subject->hideSubpartsArray(['MY_SUBPART']);
        $this->subject->setSubpart('MY_SUBPART', 'foo');
        $this->subject->unhideSubpartsArray(['MY_SUBPART']);
        self::assertSame(
            'foo',
            $this->subject->getSubpart('MY_SUBPART')
        );
    }

    ////////////////////////////////
    // Tests for setting subparts.
    ////////////////////////////////

    /**
     * @test
     */
    public function setSubpartNotEmptyGetCompleteTemplate()
    {
        $this->subject->processTemplate(
            'Some text. '
                . '<!-- ###MY_SUBPART### -->'
                . 'More text.'
                . '<!-- ###MY_SUBPART### -->'
                . ' Even more text.'
        );
        $this->subject->setSubpart('MY_SUBPART', 'foo');
        self::assertSame(
            'Some text. '
                . 'foo'
                . ' Even more text.',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function setSubpartNotEmptyGetSubpart()
    {
        $this->subject->processTemplate(
            'Some text. '
                . '<!-- ###MY_SUBPART### -->'
                . 'More text.'
                . '<!-- ###MY_SUBPART### -->'
                . ' Even more text.'
        );
        $this->subject->setSubpart('MY_SUBPART', 'foo');
        self::assertSame(
            'foo',
            $this->subject->getSubpart('MY_SUBPART')
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function setNewSubpartNotEmptyGetSubpart()
    {
        $this->subject->processTemplate(
            'Some text.'
        );
        $this->subject->setSubpart('MY_SUBPART', 'foo');
        self::assertSame(
            'foo',
            $this->subject->getSubpart('MY_SUBPART')
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function setNewSubpartWithNameWithSpaceCreatesWarning()
    {
        $this->subject->processTemplate(
            'Some text.'
        );
        $this->subject->setSubpart('MY SUBPART', 'foo');
        self::assertSame(
            '',
            $this->subject->getSubpart('MY SUBPART')
        );
        self::assertNotSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function setNewSubpartWithNameWithUtf8UmlautCreatesWarning()
    {
        $this->subject->processTemplate(
            'Some text.'
        );
        $this->subject->setSubpart('MY_SÜBPART', 'foo');
        self::assertSame(
            '',
            $this->subject->getSubpart('MY_SÜBPART')
        );
        self::assertNotSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function setNewSubpartWithNameWithUnderscoreSuffixCreatesWarning()
    {
        $this->subject->processTemplate(
            'Some text.'
        );
        $this->subject->setSubpart('MY_SUBPART_', 'foo');
        self::assertSame(
            '',
            $this->subject->getSubpart('MY_SUBPART_')
        );
        self::assertNotSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function setNewSubpartWithNameStartingWithUnderscoreCreatesWarning()
    {
        $this->subject->processTemplate(
            'Some text.'
        );
        $this->subject->setSubpart('_MY_SUBPART', 'foo');
        self::assertSame(
            '',
            $this->subject->getSubpart('_MY_SUBPART')
        );
        self::assertNotSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function setNewSubpartWithNameStartingWithNumberCreatesWarning()
    {
        $this->subject->processTemplate(
            'Some text.'
        );
        $this->subject->setSubpart('1_MY_SUBPART', 'foo');
        self::assertSame(
            '',
            $this->subject->getSubpart('1_MY_SUBPART')
        );
        self::assertNotSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function setSubpartNotEmptyGetOuterSubpart()
    {
        $this->subject->processTemplate(
            '<!-- ###OUTER_SUBPART### -->'
                . 'Some text. '
                . '<!-- ###MY_SUBPART### -->'
                . 'More text.'
                . '<!-- ###MY_SUBPART### -->'
                . ' Even more text.'
                . '<!-- ###OUTER_SUBPART### -->'
        );
        $this->subject->setSubpart('MY_SUBPART', 'foo');
        self::assertSame(
            'Some text. foo Even more text.',
            $this->subject->getSubpart('OUTER_SUBPART')
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function setSubpartToEmptyGetCompleteTemplate()
    {
        $this->subject->processTemplate(
            'Some text. '
                . '<!-- ###MY_SUBPART### -->'
                . 'More text.'
                . '<!-- ###MY_SUBPART### -->'
                . ' Even more text.'
        );
        $this->subject->setSubpart('MY_SUBPART', '');
        self::assertSame(
            'Some text. '
                . ' Even more text.',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function setSubpartToEmptyGetSubpart()
    {
        $this->subject->processTemplate(
            'Some text. '
                . '<!-- ###MY_SUBPART### -->'
                . 'More text.'
                . '<!-- ###MY_SUBPART### -->'
                . ' Even more text.'
        );
        $this->subject->setSubpart('MY_SUBPART', '');
        self::assertSame(
            '',
            $this->subject->getSubpart('MY_SUBPART')
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function setSubpartToEmptyGetOuterSubpart()
    {
        $this->subject->processTemplate(
            '<!-- ###OUTER_SUBPART### -->'
                . 'Some text. '
                . '<!-- ###MY_SUBPART### -->'
                . 'More text.'
                . '<!-- ###MY_SUBPART### -->'
                . ' Even more text.'
                . '<!-- ###OUTER_SUBPART### -->'
        );
        $this->subject->setSubpart('MY_SUBPART', '');
        self::assertSame(
            'Some text.  Even more text.',
            $this->subject->getSubpart('OUTER_SUBPART')
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function setSubpartAndGetSubpartCanHaveUtf8UmlautsInSubpartContent()
    {
        $this->subject->processTemplate(
            '<!-- ###MY_SUBPART### -->' .
            '<!-- ###MY_SUBPART### -->'
        );
        $this->subject->setSubpart('MY_SUBPART', 'äöüßÄÖÜßéèáàóò');

        self::assertSame(
            'äöüßÄÖÜßéèáàóò',
            $this->subject->getSubpart('MY_SUBPART')
        );
    }

    /**
     * @test
     */
    public function setSubpartAndGetSubpartCanHaveIso88591UmlautsInSubpartContent()
    {
        $this->subject->processTemplate(
            '<!-- ###MY_SUBPART### -->' .
            '<!-- ###MY_SUBPART### -->'
        );
        // 228 = ä, 223 = ß (in ISO8859-1)
        $this->subject->setSubpart('MY_SUBPART', chr(228) . chr(223));

        self::assertSame(
            chr(228) . chr(223),
            $this->subject->getSubpart('MY_SUBPART')
        );
    }

    //////////////////////////////////////////////////////
    // Tests for setting markers within nested subparts.
    //////////////////////////////////////////////////////

    /**
     * @test
     */
    public function setMarkerInSubpartWithinCompleteTemplate()
    {
        $this->subject->processTemplate(
            'Some text. '
                . '<!-- ###MY_SUBPART### -->'
                . 'This is some template code. ###MARKER### More text.'
                . '<!-- ###MY_SUBPART### -->'
                . ' Even more text.'
        );
        $this->subject->setMarker('marker', 'foo');
        self::assertSame(
            'Some text. '
                . 'This is some template code. foo More text.'
                . ' Even more text.',
            $this->subject->getSubpart('')
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function setMarkerInSubpartWithinOtherSubpart()
    {
        $this->subject->processTemplate(
            '<!-- ###OUTER_SUBPART### -->'
                . 'Some text. '
                . '<!-- ###MY_SUBPART### -->'
                . 'This is some template code. ###MARKER### More text.'
                . '<!-- ###MY_SUBPART### -->'
                . ' Even more text.'
                . '<!-- ###OUTER_SUBPART### -->'
        );
        $this->subject->setMarker('marker', 'foo');
        self::assertSame(
            'Some text. '
                . 'This is some template code. foo More text.'
                . ' Even more text.',
            $this->subject->getSubpart('OUTER_SUBPART')
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function setMarkerInOverwrittenSubpartWithinCompleteTemplate()
    {
        $this->subject->processTemplate(
            'Some text. '
                . '<!-- ###MY_SUBPART### -->'
                . '<!-- ###MY_SUBPART### -->'
                . ' Even more text.'
        );
        $this->subject->setSubpart(
            'MY_SUBPART',
            'This is some template code. ###MARKER### More text.'
        );
        $this->subject->setMarker('marker', 'foo');
        self::assertSame(
            'Some text. '
                . 'This is some template code. foo More text.'
                . ' Even more text.',
            $this->subject->getSubpart('')
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function setMarkerInOverwrittenSubpartWithinOtherSubpart()
    {
        $this->subject->processTemplate(
            '<!-- ###OUTER_SUBPART### -->'
                . 'Some text. '
                . '<!-- ###MY_SUBPART### -->'
                . '<!-- ###MY_SUBPART### -->'
                . ' Even more text.'
                . '<!-- ###OUTER_SUBPART### -->'
        );
        $this->subject->setSubpart(
            'MY_SUBPART',
            'This is some template code. ###MARKER### More text.'
        );
        $this->subject->setMarker('marker', 'foo');
        self::assertSame(
            'Some text. '
                . 'This is some template code. foo More text.'
                . ' Even more text.',
            $this->subject->getSubpart('OUTER_SUBPART')
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function setMarkerWithinNestedInnerSubpart()
    {
        $templateCode = 'Text before the subpart'
            . '<!-- ###MY_SUBPART### -->'
            . 'outer start, '
            . '<!-- ###OUTER_SUBPART### -->'
            . 'inner start, '
            . '<!-- ###INNER_SUBPART### -->'
            . '###MARKER###'
            . '<!-- ###INNER_SUBPART### -->'
            . 'inner end, '
            . '<!-- ###OUTER_SUBPART### -->'
            . 'outer end '
            . '<!-- ###MY_SUBPART### -->'
            . 'Text after the subpart.';
        $this->subject->processTemplate(
            $templateCode
        );
        $this->subject->setMarker('marker', 'foo ');

        self::assertSame(
            'outer start, inner start, foo inner end, outer end ',
            $this->subject->getSubpart('MY_SUBPART')
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    ////////////////////////////////////////////////////////////
    // Tests for using the prefix to marker and subpart names.
    ////////////////////////////////////////////////////////////

    /**
     * @test
     */
    public function setMarkerWithPrefix()
    {
        $this->subject->processTemplate(
            'This is some template code. '
                . '###FIRST_MARKER### ###MARKER### More text.'
        );
        $this->subject->setMarker('marker', 'foo', 'first');
        self::assertSame(
            'This is some template code. foo ###MARKER### More text.',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function setSubpartWithPrefix()
    {
        $this->subject->processTemplate(
            'Some text. '
                . '<!-- ###FIRST_MY_SUBPART### -->'
                . 'More text here. '
                . '<!-- ###FIRST_MY_SUBPART### -->'
                . '<!-- ###MY_SUBPART### -->'
                . 'More text there. '
                . '<!-- ###MY_SUBPART### -->'
                . 'Even more text.'
        );
        $this->subject->setSubpart('MY_SUBPART', 'foo', 'FIRST');
        self::assertSame(
            'Some text. '
                . 'foo'
                . 'More text there. '
                . 'Even more text.',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function hideSubpartWithPrefix()
    {
        $this->subject->processTemplate(
            'Some text. '
                . '<!-- ###FIRST_MY_SUBPART### -->'
                . 'More text here. '
                . '<!-- ###FIRST_MY_SUBPART### -->'
                . '<!-- ###MY_SUBPART### -->'
                . 'More text there. '
                . '<!-- ###MY_SUBPART### -->'
                . 'Even more text.'
        );
        $this->subject->hideSubparts('MY_SUBPART', 'FIRST');
        self::assertSame(
            'Some text. '
                . 'More text there. '
                . 'Even more text.',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function hideAndUnhideSubpartWithPrefix()
    {
        $this->subject->processTemplate(
            'Some text. '
                . '<!-- ###FIRST_MY_SUBPART### -->'
                . 'More text here. '
                . '<!-- ###FIRST_MY_SUBPART### -->'
                . '<!-- ###MY_SUBPART### -->'
                . 'More text there. '
                . '<!-- ###MY_SUBPART### -->'
                . 'Even more text.'
        );
        $this->subject->hideSubparts('FIRST_MY_SUBPART');
        $this->subject->unhideSubparts('MY_SUBPART', '', 'FIRST');
        self::assertSame(
            'Some text. '
                . 'More text here. '
                . 'More text there. '
                . 'Even more text.',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function hideTwoSubpartsWithPrefix()
    {
        $this->subject->processTemplate(
            'Some text. '
                . '<!-- ###FIRST_MY_SUBPART_1### -->'
                . 'More text here. '
                . '<!-- ###FIRST_MY_SUBPART_1### -->'
                . '<!-- ###FIRST_MY_SUBPART_2### -->'
                . 'More text there. '
                . '<!-- ###FIRST_MY_SUBPART_2### -->'
                . 'Even more text.'
        );
        $this->subject->hideSubparts('1,2', 'FIRST_MY_SUBPART');
        self::assertSame(
            'Some text. '
                . 'Even more text.',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function hideAndUnhideTwoSubpartsWithPrefix()
    {
        $this->subject->processTemplate(
            'Some text. '
                . '<!-- ###FIRST_MY_SUBPART_1### -->'
                . 'More text here. '
                . '<!-- ###FIRST_MY_SUBPART_1### -->'
                . '<!-- ###FIRST_MY_SUBPART_2### -->'
                . 'More text there. '
                . '<!-- ###FIRST_MY_SUBPART_2### -->'
                . 'Even more text.'
        );
        $this->subject->hideSubparts('FIRST_MY_SUBPART_1');
        $this->subject->hideSubparts('FIRST_MY_SUBPART_2');
        $this->subject->unhideSubparts('1,2', '', 'FIRST_MY_SUBPART');
        self::assertSame(
            'Some text. '
                . 'More text here. '
                . 'More text there. '
                . 'Even more text.',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function hideSubpartsArrayHidesSubpartWithPrefix()
    {
        $this->subject->processTemplate(
            'Some text. ' .
                '<!-- ###FIRST_MY_SUBPART### -->' .
                'More text here. ' .
                '<!-- ###FIRST_MY_SUBPART### -->' .
                '<!-- ###MY_SUBPART### -->' .
                'More text there. ' .
                '<!-- ###MY_SUBPART### -->' .
                'Even more text.'
        );
        $this->subject->hideSubpartsArray(['MY_SUBPART'], 'FIRST');
        self::assertSame(
            'Some text. ' .
                'More text there. ' .
                'Even more text.',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function hideSubpartsArrayHidesTwoSubpartsWithPrefix()
    {
        $this->subject->processTemplate(
            'Some text. ' .
                '<!-- ###FIRST_MY_SUBPART_1### -->' .
                'More text here. ' .
                '<!-- ###FIRST_MY_SUBPART_1### -->' .
                '<!-- ###FIRST_MY_SUBPART_2### -->' .
                'More text there. ' .
                '<!-- ###FIRST_MY_SUBPART_2### -->' .
                'Even more text.'
        );
        $this->subject->hideSubpartsArray(
            ['1', '2'],
            'FIRST_MY_SUBPART'
        );
        self::assertSame(
            'Some text. ' .
                'Even more text.',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function hideAndUnhideSubpartsArrayHidesAndUnhidesSubpartWithPrefix()
    {
        $this->subject->processTemplate(
            'Some text. ' .
                '<!-- ###FIRST_MY_SUBPART### -->' .
                'More text here. ' .
                '<!-- ###FIRST_MY_SUBPART### -->' .
                '<!-- ###MY_SUBPART### -->' .
                'More text there. ' .
                '<!-- ###MY_SUBPART### -->' .
                'Even more text.'
        );
        $this->subject->hideSubpartsArray(['FIRST_MY_SUBPART']);
        $this->subject->unhideSubpartsArray(['MY_SUBPART'], [''], 'FIRST');
        self::assertSame(
            'Some text. ' .
                'More text here. ' .
                'More text there. ' .
                'Even more text.',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function hideAndUnhideSubpartsArrayHidesAndUnhidesTwoSubpartsWithPrefix()
    {
        $this->subject->processTemplate(
            'Some text. ' .
                '<!-- ###FIRST_MY_SUBPART_1### -->' .
                'More text here. ' .
                '<!-- ###FIRST_MY_SUBPART_1### -->' .
                '<!-- ###FIRST_MY_SUBPART_2### -->' .
                'More text there. ' .
                '<!-- ###FIRST_MY_SUBPART_2### -->' .
                'Even more text.'
        );
        $this->subject->hideSubpartsArray(['FIRST_MY_SUBPART_1']);
        $this->subject->hideSubpartsArray(['FIRST_MY_SUBPART_2']);
        $this->subject->unhideSubpartsArray(
            ['1', '2'],
            [''],
            'FIRST_MY_SUBPART'
        );
        self::assertSame(
            'Some text. ' .
                'More text here. ' .
                'More text there. ' .
                'Even more text.',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    ////////////////////////////////////////////
    // Tests for automatically setting labels.
    ////////////////////////////////////////////

    /**
     * @test
     */
    public function setLabels()
    {
        $this->subject->processTemplate(
            'a ###LABEL_FOO### b'
        );
        $this->subject->setLabels();
        self::assertSame(
            'a foo b',
            $this->subject->getSubpart()
        );
    }

    /**
     * @test
     */
    public function setLabelsNoSalutation()
    {
        $this->subject->processTemplate(
            'a ###LABEL_BAR### b'
        );
        $this->subject->setLabels();
        self::assertSame(
            'a bar (no salutation) b',
            $this->subject->getSubpart()
        );
    }

    /**
     * @test
     */
    public function setLabelsFormal()
    {
        $this->subject->setSalutationMode('formal');
        $this->subject->processTemplate(
            'a ###LABEL_BAR### b'
        );
        $this->subject->setLabels();
        self::assertSame(
            'a bar (formal) b',
            $this->subject->getSubpart()
        );
    }

    /**
     * @test
     */
    public function setLabelsInformal()
    {
        $this->subject->setSalutationMode('informal');
        $this->subject->processTemplate(
            'a ###LABEL_BAR### b'
        );
        $this->subject->setLabels();
        self::assertSame(
            'a bar (informal) b',
            $this->subject->getSubpart()
        );
    }

    /**
     * @test
     */
    public function setLabelsWithOneBeingThePrefixOfAnother()
    {
        $this->subject->processTemplate(
            '###LABEL_FOO###, ###LABEL_FOO2###'
        );
        $this->subject->setLabels();
        self::assertSame(
            'foo, foo two',
            $this->subject->getSubpart()
        );
    }

    /////////////////////////////////////////////////////////////////////
    // Test for conditional filling and hiding of markers and subparts.
    /////////////////////////////////////////////////////////////////////

    /**
     * @test
     */
    public function setMarkerIfNotZeroWithPositiveInteger()
    {
        $this->subject->processTemplate(
            '###MARKER###'
        );

        self::assertTrue(
            $this->subject->setMarkerIfNotZero('marker', 42)
        );
        self::assertSame(
            '42',
            $this->subject->getSubpart()
        );
    }

    /**
     * @test
     */
    public function setMarkerIfNotZeroWithNegativeInteger()
    {
        $this->subject->processTemplate(
            '###MARKER###'
        );

        self::assertTrue(
            $this->subject->setMarkerIfNotZero('marker', -42)
        );
        self::assertSame(
            '-42',
            $this->subject->getSubpart()
        );
    }

    /**
     * @test
     */
    public function setMarkerIfNotZeroWithZero()
    {
        $this->subject->processTemplate(
            '###MARKER###'
        );

        self::assertFalse(
            $this->subject->setMarkerIfNotZero('marker', 0)
        );
        self::assertSame(
            '###MARKER###',
            $this->subject->getSubpart()
        );
    }

    /**
     * @test
     */
    public function setMarkerIfNotZeroWithPositiveIntegerWithPrefix()
    {
        $this->subject->processTemplate(
            '###MY_MARKER###'
        );

        self::assertTrue(
            $this->subject->setMarkerIfNotZero('marker', 42, 'MY')
        );
        self::assertSame(
            '42',
            $this->subject->getSubpart()
        );
    }

    /**
     * @test
     */
    public function setMarkerIfNotZeroWithNegativeIntegerWithPrefix()
    {
        $this->subject->processTemplate(
            '###MY_MARKER###'
        );

        self::assertTrue(
            $this->subject->setMarkerIfNotZero('marker', -42, 'MY')
        );
        self::assertSame(
            '-42',
            $this->subject->getSubpart()
        );
    }

    /**
     * @test
     */
    public function setMarkerIfNotZeroWithZeroWithPrefix()
    {
        $this->subject->processTemplate(
            '###MY_MARKER###'
        );

        self::assertFalse(
            $this->subject->setMarkerIfNotZero('marker', 0, 'MY')
        );
        self::assertSame(
            '###MY_MARKER###',
            $this->subject->getSubpart()
        );
    }

    /**
     * @test
     */
    public function setMarkerIfNotEmptyWithNotEmpty()
    {
        $this->subject->processTemplate(
            '###MARKER###'
        );

        self::assertTrue(
            $this->subject->setMarkerIfNotEmpty('marker', 'foo')
        );
        self::assertSame(
            'foo',
            $this->subject->getSubpart()
        );
    }

    /**
     * @test
     */
    public function setMarkerIfNotEmptyWithEmpty()
    {
        $this->subject->processTemplate(
            '###MARKER###'
        );

        self::assertFalse(
            $this->subject->setMarkerIfNotEmpty('marker', '')
        );
        self::assertSame(
            '###MARKER###',
            $this->subject->getSubpart()
        );
    }

    /**
     * @test
     */
    public function setMarkerIfNotEmptyWithNotEmptyWithPrefix()
    {
        $this->subject->processTemplate(
            '###MY_MARKER###'
        );

        self::assertTrue(
            $this->subject->setMarkerIfNotEmpty('marker', 'foo', 'MY')
        );
        self::assertSame(
            'foo',
            $this->subject->getSubpart()
        );
    }

    /**
     * @test
     */
    public function setMarkerIfNotEmptyWithEmptyWithPrefix()
    {
        $this->subject->processTemplate(
            '###MY_MARKER###'
        );

        self::assertFalse(
            $this->subject->setMarkerIfNotEmpty('marker', '', 'MY')
        );
        self::assertSame(
            '###MY_MARKER###',
            $this->subject->getSubpart()
        );
    }

    /**
     * @test
     */
    public function setOrDeleteMarkerWithTrue()
    {
        $this->subject->processTemplate(
            '<!-- ###WRAPPER_MARKER### -->'
                . '###MARKER###'
                . '<!-- ###WRAPPER_MARKER### -->'
        );

        self::assertTrue(
            $this->subject->setOrDeleteMarker(
                'marker',
                true,
                'foo',
                '',
                'WRAPPER'
            )
        );
        self::assertSame(
            'foo',
            $this->subject->getSubpart()
        );
    }

    /**
     * @test
     */
    public function setOrDeleteMarkerWithFalse()
    {
        $this->subject->processTemplate(
            '<!-- ###WRAPPER_MARKER### -->'
                . '###MARKER###'
                . '<!-- ###WRAPPER_MARKER### -->'
        );

        self::assertFalse(
            $this->subject->setOrDeleteMarker(
                'marker',
                false,
                'foo',
                '',
                'WRAPPER'
            )
        );
        self::assertSame(
            '',
            $this->subject->getSubpart()
        );
    }

    /**
     * @test
     */
    public function setOrDeleteMarkerWithTrueWithMarkerPrefix()
    {
        $this->subject->processTemplate(
            '<!-- ###WRAPPER_MARKER### -->'
                . '###MY_MARKER###'
                . '<!-- ###WRAPPER_MARKER### -->'
        );

        self::assertTrue(
            $this->subject->setOrDeleteMarker(
                'marker',
                true,
                'foo',
                'MY',
                'WRAPPER'
            )
        );
        self::assertSame(
            'foo',
            $this->subject->getSubpart()
        );
    }

    /**
     * @test
     */
    public function setOrDeleteMarkerWithFalseWithMarkerPrefix()
    {
        $this->subject->processTemplate(
            '<!-- ###WRAPPER_MARKER### -->'
                . '###MY_MARKER###'
                . '<!-- ###WRAPPER_MARKER### -->'
        );

        self::assertFalse(
            $this->subject->setOrDeleteMarker(
                'marker',
                false,
                'foo',
                'MY',
                'WRAPPER'
            )
        );
        self::assertSame(
            '',
            $this->subject->getSubpart()
        );
    }

    /**
     * @test
     */
    public function setOrDeleteMarkerIfNotZeroWithZero()
    {
        $this->subject->processTemplate(
            '<!-- ###WRAPPER_MARKER### -->'
                . '###MARKER###'
                . '<!-- ###WRAPPER_MARKER### -->'
        );

        self::assertFalse(
            $this->subject->setOrDeleteMarkerIfNotZero(
                'marker',
                0,
                '',
                'WRAPPER'
            )
        );
        self::assertSame(
            '',
            $this->subject->getSubpart()
        );
    }

    /**
     * @test
     */
    public function setOrDeleteMarkerIfNotZeroWithPositiveIntegers()
    {
        $this->subject->processTemplate(
            '<!-- ###WRAPPER_MARKER### -->'
                . '###MARKER###'
                . '<!-- ###WRAPPER_MARKER### -->'
        );

        self::assertTrue(
            $this->subject->setOrDeleteMarkerIfNotZero(
                'marker',
                42,
                '',
                'WRAPPER'
            )
        );
        self::assertSame(
            '42',
            $this->subject->getSubpart()
        );
    }

    /**
     * @test
     */
    public function setOrDeleteMarkerIfNotZeroWithNegativeIntegers()
    {
        $this->subject->processTemplate(
            '<!-- ###WRAPPER_MARKER### -->'
                . '###MARKER###'
                . '<!-- ###WRAPPER_MARKER### -->'
        );

        self::assertTrue(
            $this->subject->setOrDeleteMarkerIfNotZero(
                'marker',
                -42,
                '',
                'WRAPPER'
            )
        );
        self::assertSame(
            '-42',
            $this->subject->getSubpart()
        );
    }

    /**
     * @test
     */
    public function setOrDeleteMarkerIfNotZeroWithZeroWithMarkerPrefix()
    {
        $this->subject->processTemplate(
            '<!-- ###WRAPPER_MARKER### -->'
                . '###MY_MARKER###'
                . '<!-- ###WRAPPER_MARKER### -->'
        );

        self::assertFalse(
            $this->subject->setOrDeleteMarkerIfNotZero(
                'marker',
                0,
                'MY',
                'WRAPPER'
            )
        );
        self::assertSame(
            '',
            $this->subject->getSubpart()
        );
    }

    /**
     * @test
     */
    public function setOrDeleteMarkerIfNotZeroWithPositiveIntegerWithMarkerPrefix()
    {
        $this->subject->processTemplate(
            '<!-- ###WRAPPER_MARKER### -->'
                . '###MY_MARKER###'
                . '<!-- ###WRAPPER_MARKER### -->'
        );

        self::assertTrue(
            $this->subject->setOrDeleteMarkerIfNotZero(
                'marker',
                42,
                'MY',
                'WRAPPER'
            )
        );
        self::assertSame(
            '42',
            $this->subject->getSubpart()
        );
    }

    /**
     * @test
     */
    public function setOrDeleteMarkerIfNotZeroWithNegativeIntegerWithMarkerPrefix()
    {
        $this->subject->processTemplate(
            '<!-- ###WRAPPER_MARKER### -->'
                . '###MY_MARKER###'
                . '<!-- ###WRAPPER_MARKER### -->'
        );

        self::assertTrue(
            $this->subject->setOrDeleteMarkerIfNotZero(
                'marker',
                -42,
                'MY',
                'WRAPPER'
            )
        );
        self::assertSame(
            '-42',
            $this->subject->getSubpart()
        );
    }

    /**
     * @test
     */
    public function setOrDeleteMarkerIfNotEmptyWithEmpty()
    {
        $this->subject->processTemplate(
            '<!-- ###WRAPPER_MARKER### -->'
                . '###MARKER###'
                . '<!-- ###WRAPPER_MARKER### -->'
        );

        self::assertFalse(
            $this->subject->setOrDeleteMarkerIfNotEmpty(
                'marker',
                '',
                '',
                'WRAPPER'
            )
        );
        self::assertSame(
            '',
            $this->subject->getSubpart()
        );
    }

    /**
     * @test
     */
    public function setOrDeleteMarkerIfNotEmptyWithNotEmpty()
    {
        $this->subject->processTemplate(
            '<!-- ###WRAPPER_MARKER### -->'
                . '###MARKER###'
                . '<!-- ###WRAPPER_MARKER### -->'
        );

        self::assertTrue(
            $this->subject->setOrDeleteMarkerIfNotEmpty(
                'marker',
                'foo',
                '',
                'WRAPPER'
            )
        );
        self::assertSame(
            'foo',
            $this->subject->getSubpart()
        );
    }

    /**
     * @test
     */
    public function setOrDeleteMarkerIfNotEmptyWithEmptyWithMarkerPrefix()
    {
        $this->subject->processTemplate(
            '<!-- ###WRAPPER_MARKER### -->'
                . '###MY_MARKER###'
                . '<!-- ###WRAPPER_MARKER### -->'
        );

        self::assertFalse(
            $this->subject->setOrDeleteMarkerIfNotEmpty(
                'marker',
                '',
                'MY',
                'WRAPPER'
            )
        );
        self::assertSame(
            '',
            $this->subject->getSubpart()
        );
    }

    /**
     * @test
     */
    public function setOrDeleteMarkerIfNotEmptyWithNotEmptyWithMarkerPrefix()
    {
        $this->subject->processTemplate(
            '<!-- ###WRAPPER_MARKER### -->'
                . '###MY_MARKER###'
                . '<!-- ###WRAPPER_MARKER### -->'
        );

        self::assertTrue(
            $this->subject->setOrDeleteMarkerIfNotEmpty(
                'marker',
                'foo',
                'MY',
                'WRAPPER'
            )
        );
        self::assertSame(
            'foo',
            $this->subject->getSubpart()
        );
    }

    ///////////////////////////////////////////////////
    // Test concerning unclosed markers and subparts.
    ///////////////////////////////////////////////////

    /**
     * @test
     */
    public function unclosedMarkersAreIgnored()
    {
        $this->subject->processTemplate(
            '<!-- ###MY_SUBPART### -->'
                . '###MY_MARKER_1### '
                . '###MY_MARKER_2 '
                . '###MY_MARKER_3# '
                . '###MY_MARKER_4## '
                . '###MY_MARKER_5###'
                . '<!-- ###MY_SUBPART### -->'
        );
        $this->subject->setMarker('my_marker_1', 'test 1');
        $this->subject->setMarker('my_marker_2', 'test 2');
        $this->subject->setMarker('my_marker_3', 'test 3');
        $this->subject->setMarker('my_marker_4', 'test 4');
        $this->subject->setMarker('my_marker_5', 'test 5');

        self::assertSame(
            'test 1 '
                . '###MY_MARKER_2 '
                . '###MY_MARKER_3# '
                . '###MY_MARKER_4## '
                . 'test 5',
            $this->subject->getSubpart()
        );
        self::assertSame(
            'test 1 '
                . '###MY_MARKER_2 '
                . '###MY_MARKER_3# '
                . '###MY_MARKER_4## '
                . 'test 5',
            $this->subject->getSubpart('MY_SUBPART')
        );
    }

    /**
     * @test
     */
    public function unclosedSubpartsAreIgnored()
    {
        $this->subject->processTemplate(
            'Text before. '
                . '<!-- ###UNCLOSED_SUBPART_1### -->'
                . '<!-- ###OUTER_SUBPART### -->'
                . '<!-- ###UNCLOSED_SUBPART_2### -->'
                . '<!-- ###INNER_SUBPART### -->'
                . '<!-- ###UNCLOSED_SUBPART_3### -->'
                . 'Inner text. '
                . '<!-- ###UNCLOSED_SUBPART_4### -->'
                . '<!-- ###INNER_SUBPART### -->'
                . '<!-- ###UNCLOSED_SUBPART_5### -->'
                . '<!-- ###OUTER_SUBPART### -->'
                . '<!-- ###UNCLOSED_SUBPART_6### -->'
                . 'Text after.'
        );

        self::assertSame(
            'Text before. '
                . '<!-- ###UNCLOSED_SUBPART_1### -->'
                . '<!-- ###UNCLOSED_SUBPART_2### -->'
                . '<!-- ###UNCLOSED_SUBPART_3### -->'
                . 'Inner text. '
                . '<!-- ###UNCLOSED_SUBPART_4### -->'
                . '<!-- ###UNCLOSED_SUBPART_5### -->'
                . '<!-- ###UNCLOSED_SUBPART_6### -->'
                . 'Text after.',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '<!-- ###UNCLOSED_SUBPART_2### -->'
                . '<!-- ###UNCLOSED_SUBPART_3### -->'
                . 'Inner text. '
                . '<!-- ###UNCLOSED_SUBPART_4### -->'
                . '<!-- ###UNCLOSED_SUBPART_5### -->',
            $this->subject->getSubpart('OUTER_SUBPART')
        );
    }

    /**
     * @test
     */
    public function unclosedSubpartMarkersAreIgnored()
    {
        $this->subject->processTemplate(
            'Text before. '
                . '<!-- ###UNCLOSED_SUBPART_1###'
                . '<!-- ###OUTER_SUBPART### -->'
                . '<!-- ###UNCLOSED_SUBPART_2 -->'
                . '<!-- ###INNER_SUBPART### -->'
                . '<!-- ###UNCLOSED_SUBPART_3### --'
                . 'Inner text. '
                . '<!-- UNCLOSED_SUBPART_4### -->'
                . '<!-- ###INNER_SUBPART### -->'
                . ' ###UNCLOSED_SUBPART_5### -->'
                . '<!-- ###OUTER_SUBPART### -->'
                . '<!-- ###UNCLOSED_SUBPART_6### -->'
                . 'Text after.'
        );

        self::assertSame(
            'Text before. '
                . '<!-- ###UNCLOSED_SUBPART_1###'
                . '<!-- ###UNCLOSED_SUBPART_2 -->'
                . '<!-- ###UNCLOSED_SUBPART_3### --'
                . 'Inner text. '
                . '<!-- UNCLOSED_SUBPART_4### -->'
                . ' ###UNCLOSED_SUBPART_5### -->'
                . '<!-- ###UNCLOSED_SUBPART_6### -->'
                . 'Text after.',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '<!-- ###UNCLOSED_SUBPART_2 -->'
                . '<!-- ###UNCLOSED_SUBPART_3### --'
                . 'Inner text. '
                . '<!-- UNCLOSED_SUBPART_4### -->'
                . ' ###UNCLOSED_SUBPART_5### -->',
            $this->subject->getSubpart('OUTER_SUBPART')
        );
    }

    /**
     * @test
     */
    public function invalidMarkerNamesAreIgnored()
    {
        $this->subject->processTemplate(
            '<!-- ###MY_SUBPART### -->'
                . '###MARKER 1### '
                . '###MARKER-2### '
                . '###marker_3### '
                . '###MÄRKER_4### '
                . '<!-- ###MY_SUBPART### -->'
        );
        $this->subject->setMarker('marker 1', 'foo');
        $this->subject->setMarker('marker-2', 'foo');
        $this->subject->setMarker('marker_3', 'foo');
        $this->subject->setMarker('märker_4', 'foo');

        self::assertSame(
            '###MARKER 1### '
                . '###MARKER-2### '
                . '###marker_3### '
                . '###MÄRKER_4### ',
            $this->subject->getSubpart()
        );
        self::assertSame(
            '###MARKER 1### '
                . '###MARKER-2### '
                . '###marker_3### '
                . '###MÄRKER_4### ',
            $this->subject->getSubpart('MY_SUBPART')
        );
    }

    ///////////////////////////////////////////////////
    // Tests for getting subparts with invalid names.
    ///////////////////////////////////////////////////

    /**
     * @test
     */
    public function subpartWithNameWithSpaceIsIgnored()
    {
        $this->subject->processTemplate(
            '<!-- ###MY SUBPART### -->'
                . 'Some text.'
                . '<!-- ###MY SUBPART### -->'
        );
        self::assertSame(
            '',
            $this->subject->getSubpart('MY SUBPART')
        );
        self::assertNotSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function subpartWithNameWithUtf8UmlautIsIgnored()
    {
        $this->subject->processTemplate(
            '<!-- ###MY_SÜBPART### -->'
                . 'Some text.'
                . '<!-- ###MY_SÜBPART### -->'
        );
        self::assertSame(
            '',
            $this->subject->getSubpart('MY_SÜBPART')
        );
        self::assertNotSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function subpartWithNameWithUnderscoreSuffixIsIgnored()
    {
        $this->subject->processTemplate(
            '<!-- ###MY_SUBPART_### -->'
                . 'Some text.'
                . '<!-- ###MY_SUBPART_### -->'
        );
        self::assertSame(
            '',
            $this->subject->getSubpart('MY_SUBPART_')
        );
        self::assertNotSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function subpartWithNameStartingWithUnderscoreIsIgnored()
    {
        $this->subject->processTemplate(
            '<!-- ###_MY_SUBPART### -->'
                . 'Some text.'
                . '<!-- ###_MY_SUBPART### -->'
        );
        self::assertSame(
            '',
            $this->subject->getSubpart('_MY_SUBPART')
        );
        self::assertNotSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function subpartWithNameStartingWithNumberIsIgnored()
    {
        $this->subject->processTemplate(
            '<!-- ###1_MY_SUBPART### -->'
                . 'Some text.'
                . '<!-- ###1_MY_SUBPART### -->'
        );
        self::assertSame(
            '',
            $this->subject->getSubpart('1_MY_SUBPART')
        );
        self::assertNotSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function subpartWithLowercaseNameIsIgnoredWithUsingLowercase()
    {
        $this->subject->processTemplate(
            '<!-- ###my_subpart### -->'
                . 'Some text.'
                . '<!-- ###my_subpart### -->'
        );
        self::assertSame(
            '',
            $this->subject->getSubpart('my_subpart')
        );
        self::assertNotSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    /**
     * @test
     */
    public function subpartWithLowercaseNameIsIgnoredWithUsingUppercase()
    {
        $this->subject->processTemplate(
            '<!-- ###my_subpart### -->'
                . 'Some text.'
                . '<!-- ###my_subpart### -->'
        );
        self::assertSame(
            '',
            $this->subject->getSubpart('MY_SUBPART')
        );
        self::assertNotSame(
            '',
            $this->subject->getWrappedConfigCheckMessage()
        );
    }

    ///////////////////////////////////
    // Tests concerning TS templates.
    ///////////////////////////////////

    /**
     * @test
     */
    public function pageSetupInitiallyIsEmpty()
    {
        $pageId = $this->testingFramework->createFrontEndPage();
        self::assertSame(
            [],
            $this->subject->retrievePageConfig($pageId)
        );
    }

    /*
     * Tests for ensureIntegerPiVars
     */

    /**
     * @test
     */
    public function ensureIntegerPiVarsDefinesAPiVarsArrayWithShowUidPointerAndModeIfPiVarsWasUndefined()
    {
        unset($this->subject->piVars);
        $this->subject->ensureIntegerPiVars();

        self::assertSame(
            ['showUid' => 0, 'pointer' => 0, 'mode' => 0],
            $this->subject->piVars
        );
    }

    /**
     * @test
     */
    public function ensureIntegerPiVarsDefinesProvidedAdditionalParameterIfPiVarsWasUndefined()
    {
        $this->subject->piVars = [];
        $this->subject->ensureIntegerPiVars(['additionalParameter']);

        self::assertSame(
            ['showUid' => 0, 'pointer' => 0, 'mode' => 0, 'additionalParameter' => 0],
            $this->subject->piVars
        );
    }

    /**
     * @test
     */
    public function ensureIntegerPiVarsIntvalsAnAlreadyDefinedAdditionalParameter()
    {
        $this->subject->piVars = [];
        $this->subject->piVars['additionalParameter'] = 1.1;
        $this->subject->ensureIntegerPiVars(['additionalParameter']);

        self::assertSame(
            [
                'additionalParameter' => 1,
                'showUid' => 0,
                'pointer' => 0,
                'mode' => 0,
            ],
            $this->subject->piVars
        );
    }

    /**
     * @test
     */
    public function ensureIntegerPiVarsDoesNotIntvalsDefinedPiVarWhichIsNotInTheListOfPiVarsToSecure()
    {
        $this->subject->piVars = [];
        $this->subject->piVars['non-integer'] = 'foo';
        $this->subject->ensureIntegerPiVars();

        self::assertSame(
            ['non-integer' => 'foo', 'showUid' => 0, 'pointer' => 0, 'mode' => 0],
            $this->subject->piVars
        );
    }

    /**
     * @test
     */
    public function ensureIntegerPiVarsIntvalsAlreadyDefinedShowUid()
    {
        $this->subject->piVars = [];
        $this->subject->piVars['showUid'] = 1.1;
        $this->subject->ensureIntegerPiVars();

        self::assertSame(
            ['showUid' => 1, 'pointer' => 0, 'mode' => 0],
            $this->subject->piVars
        );
    }

    /////////////////////////////////////////
    // Tests concerning ensureContentObject
    /////////////////////////////////////////

    /**
     * @test
     */
    public function ensureContentObjectForExistingContentObjectLeavesItUntouched()
    {
        $contentObject = new ContentObjectRenderer();
        $this->subject->cObj = $contentObject;

        $this->subject->ensureContentObject();

        self::assertSame(
            $contentObject,
            $this->subject->cObj
        );
    }

    /**
     * @test
     */
    public function ensureContentObjectForMissingContentObjectWithFrontEndUsesContentObjectFromFrontEnd()
    {
        $this->subject->cObj = null;

        $this->subject->ensureContentObject();

        /** @var TypoScriptFrontendController $frontEndController */
        $frontEndController = $GLOBALS['TSFE'];
        self::assertSame(
            $frontEndController->cObj,
            $this->subject->cObj
        );
    }

    //////////////////////////////////////////////
    // Tests concerning ensureIntegerArrayValues
    //////////////////////////////////////////////

    /**
     * @test
     */
    public function ensureIntegerArrayValuesForEmptyArrayGivenDoesNotAddAnyPiVars()
    {
        $originalPiVars = $this->subject->piVars;
        $this->subject->ensureIntegerArrayValues([]);

        self::assertSame(
            $originalPiVars,
            $this->subject->piVars
        );
    }

    /**
     * @test
     */
    public function ensureIntegerArrayValuesForNotSetPiVarGivenDoesNotAddThisPiVar()
    {
        $originalPiVars = $this->subject->piVars;
        $this->subject->ensureIntegerArrayValues(['foo']);

        self::assertSame(
            $originalPiVars,
            $this->subject->piVars
        );
    }

    /**
     * @test
     */
    public function ensureIntegerArrayValuesForPiVarNotArrayDoesNotModifyThisPiVar()
    {
        $this->subject->piVars['foo'] = 'Hallo';
        $this->subject->ensureIntegerArrayValues(['foo']);

        self::assertSame(
            'Hallo',
            $this->subject->piVars['foo']
        );
    }

    /**
     * @test
     */
    public function ensureIntegerArrayValuesForValidIntegerInArrayDoesNotModifyThisArrayElement()
    {
        $this->subject->piVars['foo'] = [10];
        $this->subject->ensureIntegerArrayValues(['foo']);

        self::assertSame(
            10,
            $this->subject->piVars['foo'][0]
        );
    }

    /**
     * @test
     */
    public function ensureIntegerArrayValuesForStringInArrayRemovesThisArrayElement()
    {
        $this->subject->piVars['foo'] = ['Hallo'];
        $this->subject->ensureIntegerArrayValues(['foo']);

        self::assertEmpty(
            $this->subject->piVars['foo']
        );
    }

    /**
     * @test
     */
    public function ensureIntegerArrayValuesForIntegerFollowedByStringInArrayRemovesStringFromArrayElement()
    {
        $this->subject->piVars['foo'] = ['2;blubb'];
        $this->subject->ensureIntegerArrayValues(['foo']);

        self::assertSame(
            2,
            $this->subject->piVars['foo'][0]
        );
    }

    /**
     * @test
     */
    public function ensureIntegerArrayValuesForSingleInArrayRemovesNumbersAfterDecimalPoint()
    {
        $this->subject->piVars['foo'] = [2.3];
        $this->subject->ensureIntegerArrayValues(['foo']);

        self::assertSame(
            2,
            $this->subject->piVars['foo'][0]
        );
    }

    /**
     * @test
     */
    public function ensureIntegerArrayValuesForZeroInArrayRemovesThisArrayElement()
    {
        $this->subject->piVars['foo'] = [0];
        $this->subject->ensureIntegerArrayValues(['foo']);

        self::assertEmpty(
            $this->subject->piVars['foo']
        );
    }

    /**
     * @test
     */
    public function ensureIntegerArrayValuesMultiplePiKeysGivenValidatesElementsOfAllPiVars()
    {
        $this->subject->piVars['foo'] = ['2;blubb'];
        $this->subject->piVars['bar'] = ['42'];

        $this->subject->ensureIntegerArrayValues(['foo', 'bar']);

        self::assertSame(
            2,
            $this->subject->piVars['foo'][0]
        );
        self::assertSame(
            42,
            $this->subject->piVars['bar'][0]
        );
    }
}
