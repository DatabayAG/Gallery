<?php

include_once("./Services/Repository/classes/class.ilObjectPluginGUI.php");

/**
* User Interface class for gallery repository object.
*
* User interface classes process GET and POST parameter and call
* application classes to fulfill certain tasks.
*
* @author Aresch Yavari <ay@databay.de>
*
* $Id$
*
* Integration into control structure:
* - The GUI class is called by ilRepositoryGUI
* - GUI classes used by this class are ilPermissionGUI (provides the rbac
*   screens) and ilInfoScreenGUI (handles the info screen).
*
* @ilCtrl_isCalledBy ilObjGalleryGUI: ilRepositoryGUI, ilAdministrationGUI, ilObjPluginDispatchGUI
* @ilCtrl_Calls ilObjGalleryGUI: ilPermissionGUI, ilInfoScreenGUI, ilObjectCopyGUI, ilCommonActionDispatcherGUI
*
*/
class ilObjGalleryGUI extends ilObjectPluginGUI
{
	/**
	* Initialisation
	*/
	protected function afterConstructor()
	{
		// anything needed after object has been constructed
		// - gallery: append my_id GET parameter to each request
		//   $ilCtrl->saveParameter($this, array("my_id"));
	}
	
	/**
	* Get type.
	*/
	final function getType()
	{
		return "xgal";
	}
	
	/**
	* Handles all commmands of this class, centralizes permission checks
	*/
	function performCommand($cmd)
	{
		switch ($cmd)
		{
			case "editProperties":		// list all commands that need write permission here
			case "updateProperties":
			//case "...":
				$this->checkPermission("write");
				$this->$cmd();
				break;
			
			case "showContent":			// list all commands that need read permission here
			//case "...":
			//case "...":
				$this->checkPermission("read");
				$this->$cmd();
				break;
		}
	}

	/**
	* After object has been created -> jump to this command
	*/
	function getAfterCreationCmd()
	{
		return "editProperties";
	}

	/**
	* Get standard command
	*/
	function getStandardCmd()
	{
		return "showContent";
	}


	/**
	* show information screen
	*/
	function infoScreen()
	{
		global $ilAccess, $ilUser, $lng, $ilCtrl, $tpl, $ilTabs;

		$ilTabs->setTabActive("info_short");

		$this->checkPermission("visible");

		include_once("./Services/InfoScreen/classes/class.ilInfoScreenGUI.php");
		$info = new ilInfoScreenGUI($this);

		$info->addSection($this->txt("plugininfo"));
		$info->addProperty('Name', 'Fotogalerie');
		$info->addProperty('Version', xgal_version);
		$info->addProperty('Developer', 'Aresch Yavari');
		$info->addProperty('Kontakt', 'ay@databay.de');
		$info->addProperty('&nbsp;', 'Databay AG');
		$info->addProperty('&nbsp;', '<img src="http://www.iliasnet.de/download/databay.png?plug=gallery" alt="Databay AG" title="Databay AG" />');
		$info->addProperty('&nbsp;', "http://www.iliasnet.de");
		
		

		$info->enablePrivateNotes();

		// general information
		$lng->loadLanguageModule("meta");

		$this->addInfoItems($info);


		// forward the command
		$ret = $ilCtrl->forwardCommand($info);


		//$tpl->setContent($ret);
	}
//
// DISPLAY TABS
//
	
	/**
	* Set tabs
	*/
	function setTabs()
	{
		global $ilTabs, $ilCtrl, $ilAccess;
		
		// tab for the "show content" command
		if ($ilAccess->checkAccess("read", "", $this->object->getRefId()))
		{
			$ilTabs->addTab("content", $this->txt("content"), $ilCtrl->getLinkTarget($this, "showContent"));
		}

		// standard info screen tab
		$this->addInfoTab();

		// a "properties" tab
		if ($ilAccess->checkAccess("write", "", $this->object->getRefId()))
		{
			$ilTabs->addTab("properties", $this->txt("properties"), $ilCtrl->getLinkTarget($this, "editProperties"));
		}

		// standard epermission tab
		$this->addPermissionTab();
	}
	

// THE FOLLOWING METHODS IMPLEMENT SOME EXAMPLE COMMANDS WITH COMMON FEATURES
// YOU MAY REMOVE THEM COMPLETELY AND REPLACE THEM WITH YOUR OWN METHODS.

//
// Edit properties form
//

	/**
	* Edit Properties. This commands uses the form class to display an input form.
	*/
	function editProperties()
	{
		global $tpl, $ilTabs;
		
		$ilTabs->activateTab("properties");
		$this->initPropertiesForm();
		$this->getPropertiesValues();
		$tpl->setContent($this->form->getHTML());
	}
	
	/**
	* Init  form.
	*
	* @param        int        $a_mode        Edit Mode
	*/
	public function initPropertiesForm()
	{
		global $ilCtrl;
	
		include_once("Services/Form/classes/class.ilPropertyFormGUI.php");
		$this->form = new ilPropertyFormGUI();
	
		// title
		$ti = new ilTextInputGUI($this->txt("title"), "title");
		$ti->setRequired(true);
		$this->form->addItem($ti);
		
		// description
		$ta = new ilTextAreaInputGUI($this->txt("description"), "desc");
		$this->form->addItem($ta);
		

		$this->form->addCommandButton("updateProperties", $this->txt("save"));
	                
		$this->form->setTitle($this->txt("edit_properties"));
		$this->form->setFormAction($ilCtrl->getFormAction($this));
	}
	
	/**
	* Get values for edit properties form
	*/
	function getPropertiesValues()
	{
		$values["title"] = $this->object->getTitle();
		$values["desc"] = $this->object->getDescription();
		$this->form->setValuesByArray($values);
	}
	
	/**
	* Update properties
	*/
	public function updateProperties()
	{
		global $tpl, $lng, $ilCtrl;
	
		$this->initPropertiesForm();
		if ($this->form->checkInput())
		{
			$this->object->setTitle($this->form->getInput("title"));
			$this->object->setDescription($this->form->getInput("desc"));
			$this->object->update();
			ilUtil::sendSuccess($lng->txt("msg_obj_modified"), true);
			$ilCtrl->redirect($this, "editProperties");
		}

		$this->form->setValuesByPost();
		$tpl->setContent($this->form->getHtml());
	}
	
//
// Show content
//

	/**
	* Show content
	*/
	function showContent()
	{
		global $tpl, $ilTabs, $ilUser, $ilCtrl, $ilAccess;
		define('projectPath', dirname(__FILE__).'/..');
		include_once dirname(__FILE__).'/class.template.php';
		
		$T = new Template($this);
		$ilTabs->activateTab("content");

		$userID = $ilUser->getId();

		$writePermission = false;
		if ($ilAccess->checkAccess("write", "", $this->object->getRefId())) {
		    $T->setVariable ('writePermission', '1');
		    $writePermission = true;
		} else {
		    $T->setVariable ('writePermission', '0');
		}

		$this->objDir = ilUtil::getWebspaceDir().'/lm_data/lm_'.$this->object->getRefId();

		if($writePermission) {
		    $this->dataDir = $this->objDir.'/'.$userID;
		    if(!file_exists($this->dataDir)) ilUtil::makeDirParents($this->dataDir);
		}

		$publics = array();
		$user = glob($this->objDir.'/*');
		for($i=0;$i<count($user);$i++) {
		    if(basename($user[$i])!=$userID && file_exists($user[$i].'/albums.ser')) {
			$publics[basename($user[$i])] = unserialize(file_get_contents($user[$i].'/albums.ser'));
			for($j=0;$j<count($publics[basename($user[$i])]);$j++) {
			    #vd($publics[basename($user[$i])][$j]);
			    $publics[basename($user[$i])][$j]["files"] = glob($this->objDir.'/'.basename($user[$i]).'/'.$publics[basename($user[$i])][$j]['id'].'/*.jpg');
                            #if(file_exists($this->objDir.'/'.basename($user[$i]).'/'.$publics[basename($user[$i])][$j]['id'].'/pictures.ser')) {
                            #        $publics[basename($user[$i])][$j]["pictures"] = unserialize(file_get_contents($this->objDir.'/'.basename($user[$i]).'/'.$publics[basename($user[$i])][$j]['id'].'/pictures.ser'));
                            #}
			}
		    }
		}
#vd($publics);
		$albums = array();
		if($writePermission) {
		    $T->setVariable('openUpload', 0);
		    #unlink($this->dataDir.'/albums.ser');
		    if(!file_exists($this->dataDir.'/albums.ser')) {
			/*$newid = microtime(true);
			$albums = array(array('id' => $newid, 'date' => time(), 'name' => 'Album von '.strip_tags($ilUser->getPublicName())));
			file_put_contents($this->dataDir.'/albums.ser', serialize($albums));
			chmod($this->dataDir.'/albums.ser', 0664);
			$_GET["album_id"] = $newid;
			$T->setVariable('openUpload', 1);*/
			$albums = array();
		    } else {
			$albums = unserialize(file_get_contents($this->dataDir.'/albums.ser'));
                        #vd($albums);exit;
			for($i=0;$i<count($albums);$i++) {
			    $albums[$i]["files"] = glob($this->dataDir.'/'.$albums[$i]['id'].'/*.jpg');
                            if(file_exists($this->dataDir.'/'.$albums[$i]['id'].'/pictures.ser')) $albums[$i]["pictures"] = unserialize(file_get_contents($this->dataDir.'/'.$albums[$i]['id'].'/pictures.ser'));
			}
                        #vd($albums);exit;
		    }

		    if($_POST['newalbumtitle']!='') {
			$newid = microtime(true);
			$albums[] = array('id' => $newid, 'date' => time(), 'name' => strip_tags($_POST['newalbumtitle']), 'visible' => 'private');
			file_put_contents($this->dataDir.'/albums.ser', serialize($albums));
			chmod($this->dataDir.'/albums.ser', 0664);
			$_GET["album_id"] = $newid;
			$T->setVariable('openUpload', 1);
		    }

		    if($_POST['sendalbumdata']==1) {
			for($i=0;$i<count($albums);$i++) {
			    if($albums[$i]['id'].''==$_GET['album_id'].'') {
				$albums[$i]['name'] = strip_tags($_POST['albumtitle']);
				$D = explode('.', $_POST["albumdatum"]);
				$albums[$i]['date'] = mktime(0,0,0,$D[1],$D[0],$D[2]);
				$albums[$i]['visible'] = $_POST['albumvisible'];
				file_put_contents($this->dataDir.'/albums.ser', serialize($albums));
				chmod($this->dataDir.'/albums.ser', 0664);
				break;
			    }
			}
		    }

		    if($_POST['deletealbum']==1) {

			$this->albumDir = $this->dataDir.'/'.$_GET['album_id'];
			$f = glob($this->albumDir.'/*');
			for($i=0;$i<count($f);$i++) {
			    unlink($f[$i]);
			}
			rmdir($this->albumDir);
			$A = array();
			for($i=0;$i<count($albums);$i++) {
			    if($albums[$i]['id'].''!=$_GET['album_id'].'') {
				$A[] = $albums[$i];
			    }
			}
			$albums = $A;
			file_put_contents($this->dataDir.'/albums.ser', serialize($albums));
			chmod($this->dataDir.'/albums.ser', 0664);
			$_GET['album_id'] = '';
		    }
		}
		
		$T->setVariable('contentLink', $ilCtrl->getLinkTarget($this, 'showContent'));

		$T->setVariable('albums', $albums);
		$T->setVariable('publics', $publics);


		if( (!isset($_GET['palbum_id']) || $_GET['palbum_id']=='') && (!isset($_GET['album_id']) || $_GET['album_id']=='') ) {
		    
		}


		// ****************************************************************************************************
		if(isset($_GET['palbum_id']) && $_GET['palbum_id']!='') {
		    foreach($publics as $i => $pub) {
			for($j=0;$j<count($publics[$i]);$j++) {
			    if($publics[$i][$j]['visible']!='private') {
				if($publics[$i][$j]['id'].''==$_GET['palbum_id'].'') {
				    $this->albumDir = $this->objDir.'/'.$i.'/'.$_GET['palbum_id'];
				    $pictures = unserialize(file_get_contents($this->albumDir.'/pictures.ser'));

				    if($_GET['imgout']!='') {
					$this->imageOut($pictures);
				    }

				    $T->setVariable('ppictures', $pictures);
				}
			    }
			}
		    }
		}
		// ****************************************************************************************************

		// ****************************************************************************************************
		if(isset($_GET['album_id']) && $_GET['album_id']!='' && writePermission) {
		    $this->albumDir = $this->dataDir.'/'.$_GET['album_id'];
		    if(!file_exists($this->albumDir)) ilUtil::makeDirParents($this->albumDir);

		    if(!file_exists($this->albumDir.'/pictures.ser')) {
			$pictures = array();
			file_put_contents($this->albumDir.'/pictures.ser', serialize($pictures));
			chmod($this->albumDir.'/pictures.ser', 0664);
		    } else {
			$pictures = unserialize(file_get_contents($this->albumDir.'/pictures.ser'));
                        #vd($pictures);exit;
		    }

		    if($_POST['deletepictures']==1) {
			for($i=0;$i<count($_POST['pix']);$i++) {
			    $fn = $this->albumDir.'/'.$pictures[$_POST['pix'][$i]]['file'];
			    unlink($fn);
			    unset($pictures[$_POST['pix'][$i]]);
			}
			file_put_contents($this->albumDir.'/pictures.ser', serialize($pictures));
			chmod($this->albumDir.'/pictures.ser', 0664);
		    }

		    if($_GET['imgout']!='') {
			$this->imageOut($pictures);
		    }

		    if($_POST['uploadmultifiles']!='') {

			$F = explode(',', $_POST['uploadmultifiles']);
			for($i=0;$i<count($F);$i++) {
			    if($F[$i]!='') {
				$ext = strtolower(substr($F[$i], strrpos($F[$i],'.')));
				if($ext=='.jpg') {
				    $cachefn = $this->dataDir.'/../../cache/'.$_GET['album_id'].'_'.$F[$i];
				    if(file_Exists($cachefn)) {
					$fn = strtolower($F[$i]);
					$fn = str_replace(' ', '_', $fn);
					$pn = $this->albumDir.'/'.microtime(true).'.'.$fn;
					rename($cachefn, $pn);
					chmod($pn, 0664);
					$id = md5(uniqid(rand().microtime(true)).rand());
					$pictures[$id] = array('title' => '', 'date' => time(), 'file' => basename($pn));
				    }
				}
			    }
			}
			
			file_put_contents($this->albumDir.'/pictures.ser', serialize($pictures));
			chmod($this->albumDir.'/pictures.ser', 0664);
		    }


		    if($_POST['sendphoto']==1) {
			$ext = strtolower(substr($_FILES['newphoto']['name'], strrpos($_FILES['newphoto']['name'],'.')));
			if($ext=='.jpg') {
			    $fn = strtolower($_FILES['newphoto']['name']);
			    $fn = str_replace(' ', '_', $fn);
			    $pn = $this->albumDir.'/'.microtime(true).'.'.$fn;
			    move_uploaded_file($_FILES['newphoto']['tmp_name'], $pn);
			    chmod($pn, 0664);
			    $id = md5(uniqid(rand().microtime(true)).rand());
			    $pictures[$id] = array('title' => strip_tags($_POST['newphototitle']), 'date' => time(), 'file' => basename($pn));
			    file_put_contents($this->albumDir.'/pictures.ser', serialize($pictures));
			    chmod($this->albumDir.'/pictures.ser', 0664);
			}
		    }

		    $T->setVariable('pictures', $pictures);


		}
		// ****************************************************************************************************

		$html = $T->get('tpl.content.php');
		//$tpl->setContent($html."<br>Hello World.<br>RefID = ".$this->object->getRefId()."<br/>ilUserID = ". $ilUser->getId()."<br>PublicName = ".$ilUser->getPublicName());
		$tpl->setContent($html);
	}

	private function imageOut($pictures) {
			$fn = $this->albumDir.'/'.$pictures[$_GET['imgout']]['file'];
			$wh = getImageSize($fn);
			$w = $wh[0];
			$h = $wh[1];
                        if($_GET["quad"]==1) {
                            if( ($_GET["upscale"]==1 && $w<>$_GET["width"]) || ($_GET["upscale"]!=1 && $w>$_GET["width"]) ) {
                                $h = $h * ($_GET["width"]/$w);
                                $w = $_GET["width"];
                            }
                            if($h<$_GET["height"]) {
                                $w = $w * ($_GET["height"]/$h);
                                $h = $_GET["height"];
                            }
                        } else {
                            if( ($_GET["upscale"]==1 && $w<>$_GET["width"]) || ($_GET["upscale"]!=1 && $w>$_GET["width"]) ) {
                                $h = $h * ($_GET["width"]/$w);
                                $w = $_GET["width"];
                            }
                            if($h>$_GET["height"]) {
                                $w = $w * ($_GET["height"]/$h);
                                $h = $_GET["height"];
                            }
                        }
			#phpinfo();
			$w = floor($w);
			$h = floor($h);
			if($_GET["quad"]==1) {
			    $im = imageCreateTrueColor($_GET["width"], $_GET["height"]);
			} else {
			    $im = imageCreateTrueColor($w, $h);
			}
			imagefilledrectangle($im, 0, 0, imageSx($im), imageSy($im), imageColorAllocate($im, 255,255,255));
			$im2 = imageCreateFromJpeg($fn);
			imagecopyresampled($im, $im2, imageSx($im)/2-$w/2,imageSy($im)/2-$h/2,0,0,$w, $h, $wh[0], $wh[1]);
			header('Content-type: image/jpeg');
			imageJpeg($im);
			exit;
	}
	

}
?>