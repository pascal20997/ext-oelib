<?php

/**
 * Test case.
 *
 * @author Oliver Klee <typo3-coding@oliverklee.de>
 */
class Tx_Oelib_Tests_Unit_ViewHelpers_UppercaseViewHelperTest extends \Tx_Phpunit_TestCase
{
    /**
     * @test
     */
    public function renderConvertsToUppercase()
    {
        $subject = $this->getMock(\Tx_Oelib_ViewHelpers_UppercaseViewHelper::class, ['renderChildren']);
        $subject->expects(self::once())->method('renderChildren')->will(self::returnValue('foo bar'));

        /* @var \Tx_Oelib_ViewHelpers_UppercaseViewHelper $subject */
        self::assertSame(
            'FOO BAR',
            $subject->render()
        );
    }

    /**
     * @test
     */
    public function renderCanConvertUmlautsToUppercase()
    {
        $subject = $this->getMock(\Tx_Oelib_ViewHelpers_UppercaseViewHelper::class, ['renderChildren']);
        $subject->expects(self::once())->method('renderChildren')->will(self::returnValue('äöü'));

        /* @var \Tx_Oelib_ViewHelpers_UppercaseViewHelper $subject */
        self::assertSame(
            'ÄÖÜ',
            $subject->render()
        );
    }

    /**
     * @test
     */
    public function renderCanConvertAccentedCharactersToUppercase()
    {
        $subject = $this->getMock(\Tx_Oelib_ViewHelpers_UppercaseViewHelper::class, ['renderChildren']);
        $subject->expects(self::once())->method('renderChildren')->will(self::returnValue('áàéè'));

        /* @var \Tx_Oelib_ViewHelpers_UppercaseViewHelper $subject */
        self::assertSame(
            'ÁÀÉÈ',
            $subject->render()
        );
    }
}
