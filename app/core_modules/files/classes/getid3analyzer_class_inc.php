<?php
/**
* Wrapper to Get Id3
*
* This class is a wrapper to GetId3 which is a media analyser script
* It provides information on media files such as width, height,
* compression, codecs, bitrates, play length, etc.
*
* @author Tohir Solomons
*/

class getid3analyzer extends object
{
    
    /**
    * Get Id3 Object
    * @var $_objGetID3
    */
    private $_objGetID3;
    
    /**
    * Constructor
    */
    public function init()
    {
        require_once($this->getResourceUri('getid3/getid3.php'));
    }
    
    /**
    * Method to Analyze a Media File
    * @param string $file Path to File
    * @return array Media Information
    */
    public function analyze($file)
    {
        // Turn Off Errors
        $displayErrors = ini_get('display_errors');
        error_reporting(0);
        
        $getID3 = new getID3();
                
        $ThisFileInfo = $getID3->analyze($file);
        
        getid3_lib::CopyTagsToComments($ThisFileInfo);
        
        // Turn Errors back On
        error_reporting($displayErrors);
        
        return $ThisFileInfo;
    }
}

?>