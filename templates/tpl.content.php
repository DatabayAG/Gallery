<script type="text/javascript" language="javascript" src="Customizing/global/plugins/Services/Repository/RepositoryObject/Gallery/templates/lytebox/lytebox.js"></script>
<link rel="stylesheet" href="Customizing/global/plugins/Services/Repository/RepositoryObject/Gallery/templates/lytebox/lytebox.css" type="text/css" media="screen" />

<table><tr>
<?php if($VARS->getInt('writePermission')==1)	 { ?>
	<td valign="top" style="width:160px;">
	    <h3><?php echo $this->txt('meine_alben');?></h3>
    <?php foreach($VARS->get('albums') as $key => $album) { ?>
	<div style="padding-bottom:5px;">
	    <span style='font-size:7pt;color: gray;'><?php echo ilDatePresentation::formatDate(new ilDate(date("Y-m-d",$album->get('date')),IL_CAL_DATE)); ?></span><br/>
	    <a href="<?php echo $VARS->get('contentLink');?>&album_id=<?php echo $album->get('id'); ?>"><?php echo $album->get('name'); ?></a><br/>
	</div>
    <?php

    if($album->get('id').''==$_GET['album_id'].'') {
	$albumSelect = $album;
    }
    } ?>
    <hr size="1" color="#afafaf" />
    <a href="#" onclick="document.getElementById('newAlbum').style.display = 'block';" class="submit" style="font-size:8pt;"><?php echo $this->txt('neues_album_anlegen');?></a>

    <div id="newAlbum" style="display: none;">
	<br/><br/>
	<form action="<?php echo $VARS->get('contentLink');?>" method="post">
	    <?php echo $this->txt('titel');?>:<br/>
	    <input type="text" name="newalbumtitle" value="" /><br/>
	    <input type="submit" value="<?php echo $this->txt('album_anlegen');?>"  class="submit"/>
	</form>
    </div>

    </td>
    <td width="10" style="border-right:solid 1px #afafaf;">&nbsp;</td>
    <td width="10"></td>
<?php } ?>
<td valign="top">
    <?php if($VARS->is_set('ppictures')) {
	include dirname(__FILE__).'/tpl.publicgalleries.php';
    } else if(isset($albumSelect)) {
	include dirname(__FILE__).'/tpl.mygalleries.php';
    } else {
	include dirname(__FILE__).'/tpl.overview.php';
    } ?>
	<div style="width:500px;"></div>
</td>
<td width="10" style="border-right:solid 1px #afafaf;">&nbsp;</td>
<td width="10"></td>
<td valign="top" style="width:160px;">
    	    <h3><?php echo $this->txt('freie_alben');?></h3>

    <?php
    foreach($VARS->get('publics') as $key => $value) {
	foreach($value as $key => $pubalb) {
	    if($pubalb->get('visible')!='private') { ?>
		    <div style="padding-bottom:5px;">
			<span style='font-size:7pt;color: gray;'><?php echo ilDatePresentation::formatDate(new ilDate(date("Y-m-d",$pubalb->get('date')),IL_CAL_DATE)); ?></span><br/>
			<a href="<?php echo $VARS->get('contentLink');?>&palbum_id=<?php echo $pubalb->get('id'); ?>"><?php echo $pubalb->get('name'); ?></a><br/>
		    </div>
		    <?php
	    }
	}
    }
    ?>
</td>
</tr></table>
