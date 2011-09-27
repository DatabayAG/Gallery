<?php

include_once("./Services/Repository/classes/class.ilRepositoryObjectPlugin.php");
 
/**
* Gallery repository object plugin
* Documentation: http://www.ilias.de/docu/ilias.php?ref_id=42&from_page=29964&cmd=layout&cmdClass=illmpresentationgui&cmdNode=e&baseClass=ilLMPresentationGUI&obj_id=29962
*
* @author Aresch Yavari <ay@databay.de>
* @version $Id$
*
*/
class ilGalleryPlugin extends ilRepositoryObjectPlugin
{
	function getPluginName()
	{
		return "Gallery";
	}
}
?>
