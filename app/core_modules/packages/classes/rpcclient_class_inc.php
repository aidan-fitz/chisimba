<?php
// security check - must be included in all scripts
if (!$GLOBALS['kewl_entry_point_run']) {
	die("You cannot view this page directly");
}
/**
 * XML-RPC Client class
 *
 * @author Paul Scott
 * @copyright GPL
 * @package packages
 * @version 0.1
 */
class rpcclient extends object
{
	/**
	 * Language Object
	 *
	 * @var object
	 */
	public $objLanguage;
	
	/**
	 * Config object
	 *
	 * @var object
	 */
	public $objConfig;
	
	/**
	 * Sysconfig object
	 *
	 * @var object
	 */
	public $sysConfig;
	
	/**
	 * Standard init function
	 * 
	 * @param void
	 * @return void
	 */
	public function init()
	{
		//require_once($this->getPearResource('XML/RPC.php'));
		$this->objConfig = $this->getObject('altconfig', 'config');
		$this->objLanguage = $this->getObject('language', 'language');
		$this->sysConfig = $this->getObject('dbsysconfig', 'sysconfig');
	}

	/**
	 * Method to get a list of available modules from the rpc server
	 *
	 * @param void
	 * @return string
	 */
	public function getModuleList()
	{
		$msg = new XML_RPC_Message('getModuleList');
		$mirrorserv = $this->sysConfig->getValue('package_server', 'packages');
		$mirrorurl = $this->sysConfig->getValue('package_url', 'packages');
		$cli = new XML_RPC_Client($mirrorurl, $mirrorserv);
		$cli->setDebug(0);

		// send the request message
		$resp = $cli->send($msg);
		if (!$resp)
		{
			throw new customException($this->objLanguage->languageText("mod_packages_commserr", "packages").": ".$cli->errstr);
			exit;
		}
		if (!$resp->faultCode())
		{
			$val = $resp->value();
			return $val->serialize($val);
		}
		else
		{
			/*
			* Display problems that have been gracefully caught and
			* reported by the xmlrpc server class.
			*/
			throw new customException($this->objLanguage->languageText("mod_packages_faultcode", "packages").": ".$resp->faultCode() . $this->objLanguage->languageText("mod_packages_faultreason", "packages").": ".$resp->faultString());
		}
	}
	
	/**
	 * Grab a zip file of a module from the RPC Server
	 *
	 * @param string $modulename
	 * @return serialized base64 encoded string
	 */
	public function getModuleZip($modulename)
	{
		$msg = new XML_RPC_Message('getModuleZip', array(new XML_RPC_Value($modulename, "string")));
		$mirrorserv = $this->sysConfig->getValue('package_server', 'packages');
		$mirrorurl = $this->sysConfig->getValue('package_url', 'packages');
		$cli = new XML_RPC_Client($mirrorurl, $mirrorserv);
		$cli->setDebug(0);

		// send the request message
		$resp = $cli->send($msg);
		if (!$resp)
		{
			throw new customException($this->objLanguage->languageText("mod_packages_commserr", "packages").": ".$cli->errstr);
			exit;
		}
		if (!$resp->faultCode())
		{
			$val = $resp->value();
			return $val->serialize($val);
		}
		else
		{
			/*
			* Display problems that have been gracefully caught and
			* reported by the xmlrpc server class.
			*/
			throw new customException($this->objLanguage->languageText("mod_packages_faultcode", "packages").": ".$resp->faultCode().$this->objLanguage->languageText("mod_packages_faultreason", "packages").": ".$resp->faultString());
		}
	}
}
?>