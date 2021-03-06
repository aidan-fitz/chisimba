<?php
/**
 * Verifies that control statements conform to their coding standards.
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @author    Marc McIntyre <mmcintyre@squiz.net>
 * @copyright 2006 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 * @version   CVS: $Id$
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */

require_once 'PHP/CodeSniffer/Standards/AbstractPatternSniff.php';

/**
 * Verifies that control statements conform to their coding standards.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @author    Marc McIntyre <mmcintyre@squiz.net>
 * @copyright 2006 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 * @version   Release: 0.6.0
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */
class Squiz_Sniffs_ControlStructures_ControlSignatureSniff extends PHP_CodeSniffer_Standards_AbstractPatternSniff
{


    /**
     * Returns the patterns that this test wishes to verify.
     *
     * @return array(string)
     */
    protected function getPatterns()
    {
        return array(
                "try {\n...} catch (...) {\n",
                "do {\n...} while (...);\n",
                "while (...) {\n",
                "for (...) {\n",
                "if (...) {\n",
                "foreach (...) {\n",
                "} else if (...) {\n",
                "} else {\n",
                "do {\n",
               );

    }//end getPatterns()


}//end class

?>