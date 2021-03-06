<?php
// security check - must be included in all scripts
if (!
/**
 * Description for $GLOBALS
 * @global unknown $GLOBALS['kewl_entry_point_run']
 * @name   $kewl_entry_point_run
 */
$GLOBALS['kewl_entry_point_run']){
    die("You cannot view this page directly");
}
// end security check

/**
* Class to check whether Class/Object file exists.
*
* In the Chisimba framework, classes exist in a specified file format in modules.
* This class checks whether the FILE exist
* It does not test/throw exceptions whether the object has been/can be instantiated.
*
* @category  Chisimba
* @package   utilities
* @author    Tohir Solomons
* @copyright 2007 AVOIR
* @license   http://www.gnu.org/licenses/gpl-2.0.txt The GNU General
Public License
* @version   $Id$
* @link      http://avoir.uwc.ac.za
*/

class checkobject extends object
{
    
    /**
    * Standard Constructor
    */
    public function init()
    { 
        $this->objConfig = $this->getObject('altconfig', 'config');
    }
    
    /**
    * Method to check whether an objects file exists
    * @param string $name Name of the Class
    * @param string $module Name of the Module to look in for the class
    * @return boolean TRUE if file is found else FALSE
    */
    public function objectFileExists($name, $moduleName)
    {
        $filename2 = '';
        
        if ($moduleName == '_core') {
            $filename = "classes/core/".strtolower($name)."_class_inc.php";
        } else {
            // Check in Config folder if module is gives as _site_
            if ($moduleName == '_site_') {
                $moduleName = 'config';
            }
            
            // Generate Filename for core_modules
            $filename = $this->objConfig->getSiteRootPath() . "core_modules/".$moduleName."/classes/".strtolower($name)."_class_inc.php";
            
            // Generate Filename for chisimba_modules
            $filename2 = $this->objConfig->getModulePath().$moduleName."/classes/".strtolower($name)."_class_inc.php";
        }
        
        $filename = strtolower($filename);
        
        if (file_exists($filename)) {
            return TRUE;
        } else if ($filename2 != '' && file_exists($filename2)){
            return TRUE;
        } else {
            return FALSE;
        }
    }
}

?>