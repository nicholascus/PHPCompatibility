<?php
/**
 * \PHPCompatibility\Sniffs\ControlStructures\ForeachExpressionReferencingSniff.
 *
 * PHP version 5.5
 *
 * @category PHP
 * @package  PHPCompatibility
 * @author   Juliette Reinders Folmer <phpcompatibility_nospam@adviesenzo.nl>
 */

namespace PHPCompatibility\Sniffs\ControlStructures;

use PHPCompatibility\Sniff;

/**
 * \PHPCompatibility\Sniffs\ControlStructures\ForeachExpressionReferencingSniff.
 *
 * Before PHP 5.5.0, referencing $value is only possible if the iterated array
 * can be referenced (i.e. if it is a variable).
 *
 * PHP version 5.5
 *
 * @category PHP
 * @package  PHPCompatibility
 * @author   Juliette Reinders Folmer <phpcompatibility_nospam@adviesenzo.nl>
 */
class ForeachExpressionReferencingSniff extends Sniff
{

    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(T_FOREACH);
    }

    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param \PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int                   $stackPtr  The position of the current token in the
     *                                         stack passed in $tokens.
     *
     * @return void
     */
    public function process(\PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        if ($this->supportsBelow('5.4') === false) {
            return;
        }

        $tokens = $phpcsFile->getTokens();

        if (isset($tokens[$stackPtr]['parenthesis_opener'], $tokens[$stackPtr]['parenthesis_closer']) === false) {
            return;
        }

        $opener = $tokens[$stackPtr]['parenthesis_opener'];
        $closer = $tokens[$stackPtr]['parenthesis_closer'];

        $asToken = $phpcsFile->findNext(T_AS, ($opener + 1), $closer);
        if ($asToken === false) {
            return;
        }

        /*
         * Note: referencing $key is not allowed in any version, so this should only find referenced $values.
         * If it does find a referenced key, it would be a parse error anyway.
         */
        $hasReference = $phpcsFile->findNext(T_BITWISE_AND, ($asToken + 1), $closer);
        if ($hasReference === false) {
            return;
        }

        $ignore   = \PHP_CodeSniffer_Tokens::$emptyTokens;
        $ignore[] = T_VARIABLE;

        if ($phpcsFile->findNext($ignore, ($opener + 1), $asToken, true) !== false) {
            // Non-variable detected before the `as` keyword.
            $phpcsFile->addError(
                'Referencing $value is only possible if the iterated array is a variable in PHP 5.4 or earlier.',
                $hasReference,
                'Found'
            );
        }
    }
}
