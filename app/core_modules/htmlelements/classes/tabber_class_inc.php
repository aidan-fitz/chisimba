<?php
/**
 * Tabber class
 * 
 * HTML control class to create multiple tabbed boxes using the layers class.
 * 
 * PHP version 5
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the
 * Free Software Foundation, Inc.,
 * 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 * 
 * @category  Chisimba
 * @package   htmlelements
 * @author Kevin Cyster <kcyster@uwc.ac.za>
 * @copyright 2004-2007, University of the Western Cape & AVOIR Project
 * @license   http://www.gnu.org/licenses/gpl-2.0.txt The GNU General Public License 
 * @version   $Id$
 * @link      http://avoir.uwc.ac.za
 */
// security check - must be included in all scripts
if (!
/**
 * Description for $GLOBALS
 * @global unknown $GLOBALS['kewl_entry_point_run']
 * @name   $kewl_entry_point_run
 */
$GLOBALS['kewl_entry_point_run']) {
    die("You cannot view this page directly");
}
/**
* HTML control class to create multiple tabbed boxes using the layers class.
* The style sheet class is >box<.
* 
* 
* @abstract 
* @package tabber
* @category HTML Controls
* @copyright 2007, University of the Western Cape & AVOIR Project
* @license GNU GPL
* @author Kevin Cyster
* @example
*/
class tabber extends object 
{
    
    /**
    * @var $tabs array :  Array that holds all the tabs
    * @access private
    */
    private $tabs = array();

    /**
    * @var string $setSelected: The tab to shown as default (0, 1, 2 etc.)
    * @access public
    */
    public $setSelected = 0;

    /**
    * @var string $tabId: The tab id
    * @access public
    */
    public $tabId;

    /**
    * @var boolean $isNested: TRUE if the tab is in another FALSE if main tab
    * @access public
    */
    public $isNested = FALSE;

    /**
    * Constuctor
    * 
    * @access public
    * @return void
    */    
    public function init()
    {
        $headerParams = $this->getJavascriptFile('x_minified.js', 'htmlelements');
        $this->appendArrayVar('headerParams', $headerParams);
        $headerParams = $this->getJavascriptFile('tabber.js', 'htmlelements');
        $this->appendArrayVar('headerParams', $headerParams);
        $link = '<link id="tabber" type="text/css" rel="stylesheet" href="core_modules/htmlelements/resources/css/tabber.css" />';
        $this->appendArrayVar('headerParams', $link);
        $this->tabId = 'tabPane_'.rand(1,10);
        $this->tabs = array();
        $this->isNested = FALSE;
    }
        
    /**
    * Method that adds a tab
    * 
    * @access public
    * @param array $tab : Can hold the following values
    * name string
    * content string
    * onclick string
    * @return void
    */    
    function addTab($tab = NULL){
        if(is_array($tab)){
            if(isset($tab['name'])){                
                $this->tabs[$tab['name']]['name'] = $tab['name'];
                if(isset($tab['content'])){
                    $this->tabs[$tab['name']]['content'] = $tab['content'];
                }
                if(isset($tab['onclick'])){
                    $this->tabs[$tab['name']]['onclick'] = $tab['onclick'];
                }
            }            
        }        
    }
    
    /**
    * Method that prepends data to a tab
    * 
    * @access public
    * @param array $tab : Can hold the following values
    * name string
    * content string
    * onclick string
    * @return void
    */    
    function prependToTab($tab = NULL){
        if(is_array($tab)){
            if(isset($tab['name'])){                
                $this->tabs[$tab['name']]['name'] = $tab['name'];
                if(isset($tab['content'])){
                    $content = $tab['content'];
                    $content .= $this->tabs[$tab['name']]['content'];
                    $this->tabs[$tab['name']]['content'] = $content;
                }
                if(isset($tab['onclick'])){
                    $this->tabs[$tab['name']]['onclick'] = $tab['onclick'];
                }
            }            
        }        
    }
    
    /**
    * Method that appends data to a tab
    * 
    * @access public
    * @param array $tab : Can hold the following values
    * name string
    * content string
    * onclick string
    * @return void
    */    
    function appendToTab($tab = NULL){
        if(is_array($tab)){
            if(isset($tab['name'])){                
                $this->tabs[$tab['name']]['name'] = $tab['name'];
                if(isset($tab['content'])){
                    $content = $this->tabs[$tab['name']]['content'];
                    $content .= $tab['content'];
                    $this->tabs[$tab['name']]['content'] = $content;
                }
                if(isset($tab['onclick'])){
                    $this->tabs[$tab['name']]['onclick'] = $tab['onclick'];
                }
            }            
        }        
    }
    
    /**
    * Method to get a list of current tabs
    *
    * @access public
    * @return array $tabArray: The tabs for an instance of the tabber object
    */
    public function getTabs()
    {
        $tabArray = $this->tabs;
        return $tabArray;
    }

    /**
    * Method to show the tabs
    * 
    * @access public
    * @return $str string
    */
    public function show(){
        if(isset($this->tabs) && is_array($this->tabs)){            
            $str = '<div id="'.$this->tabId.'" class="tabber">';
            $i = 0;
            foreach($this->tabs as $tab){
                if (isset($tab['onclick']))
                {
                    $onclick = ' onclick="' . $tab['onclick'] . '"';
                }
                else
                {
                    $onclick = NULL;
                }
                if (is_numeric($this->setSelected))
                {
                    if($this->setSelected == $i++)
                    {
                        $str .= '<div class="tabbertab tabbertabdefault" title="'.$tab['name'].'"'.$onclick.'>';
                    }
                    else
                    {
                        $str .= '<div class="tabbertab" title="'.$tab['name'].'"'.$onclick.'>';
                    }
                }
                else
                {
                    if ($this->setSelected == $tab['name'])
                    {
                        $str .= '<div class="tabbertab tabbertabdefault" title="'.$tab['name'].'"'.$onclick.'>';
                    }
                    else
                    {
                        $str .= '<div class="tabbertab" title="'.$tab['name'].'"'.$onclick.'>';
                    }
                }
                $str .= $tab['content'];
                $str .= '</div>';
            }
            $str .= '</div>';
            if(!$this->isNested){
                $body = 'tabberAutomatic({addLinkId: true})';
                $this->appendArrayVar('bodyOnLoad', $body);
            }
            return $str;
        }
        return FALSE;
    }    
}
?>