<?php
/**
 * PHP 5.5 referencing expressions in foreach sniff test file.
 *
 * @package PHPCompatibility
 */

namespace PHPCompatibility\Tests\Sniffs\ControlStructures;

use PHPCompatibility\Tests\BaseSniffTest;

/**
 * PHP 5.5 referencing expressions in foreach sniff test file.
 *
 * @group foreachExpressionReferencing
 * @group controlStructures
 *
 * @covers \PHPCompatibility\Sniffs\ControlStructures\ForeachExpressionReferencingSniff
 *
 * @uses    \PHPCompatibility\Tests\BaseSniffTest
 * @package PHPCompatibility
 * @author  Juliette Reinders Folmer <phpcompatibility_nospam@adviesenzo.nl>
 */
class ForeachExpressionReferencingSniffTest extends BaseSniffTest
{
    const TEST_FILE = 'Sniffs/ControlStructures/ForeachExpressionReferencingTestCases.inc';

    /**
     * testForeachExpressionReferencing
     *
     * @dataProvider dataForeachExpressionReferencing
     *
     * @param int $line Line number where the error should occur.
     *
     * @return void
     */
    public function testForeachExpressionReferencing($line)
    {
        $file = $this->sniffFile(self::TEST_FILE, '5.4');
        $this->assertError($file, $line, 'Referencing $value is only possible if the iterated array is a variable in PHP 5.4 or earlier.');
    }

    /**
     * dataForeachExpressionReferencing
     *
     * @see testForeachExpressionReferencing()
     *
     * @return array
     */
    public function dataForeachExpressionReferencing()
    {
        return array(
            array(13),
            array(14),
            array(16),
            array(17),
            array(19),
            array(20),
        );
    }


    /**
     * testNoFalsePositives
     *
     * @dataProvider dataNoFalsePositives
     *
     * @param int $line Line number with a valid list assignment.
     *
     * @return void
     */
    public function testNoFalsePositives($line)
    {
        $file = $this->sniffFile(self::TEST_FILE, '5.4');
        $this->assertNoViolation($file, $line);
    }

    /**
     * dataNoFalsePositives
     *
     * @see testNoFalsePositives()
     *
     * @return array
     */
    public function dataNoFalsePositives()
    {
        return array(
            array(6),
            array(7),
            array(8),
        );
    }


    /**
     * Verify no notices are thrown at all.
     *
     * @return void
     */
    public function testNoViolationsInFileOnValidVersion()
    {
        $file = $this->sniffFile(self::TEST_FILE, '5.5');
        $this->assertNoViolation($file);
    }
}
