	<?php echo $this->txt('obj_xgal');?>: <b><?php  echo $albumSelect->get('name'); ?></b> <?php echo $this->txt('vom');?> <b><?php echo ilDatePresentation::formatDate(new ilDate(date("Y-m-d",$albumSelect->get('date')),IL_CAL_DATE)); ?></b>
	<hr size="1" />

	<form action="<?php echo $VARS->get('contentLink');?>&album_id=<?php echo $albumSelect->get('id');?>" method="post" enctype="multipart/form-data" id="deletepicturesform">
	    <input type="hidden" name="deletepictures" id="deletepictures" value="0" />
	    <?php foreach($VARS->get('pictures') as $key => $picture) { ?>
		<div style="margin:0 5px 5px 0;border: solid 1px gray;background-color: white;float:left;padding:5px;">
		    <a href="<?php echo $VARS->get('contentLink').'&album_id='.$albumSelect->get('id').'&imgout='.$key; ?>&width=1000&height=800" class="lytebox" data-lyte-options="group:album" data-title="<?php echo $picture->get('title');?>" onclick="return false;"><img src='<?php echo $VARS->get('contentLink').'&album_id='.$albumSelect->get('id').'&imgout='.$key; ?>&width=100&height=100&upscale=1&quad=1' width="100" height="100" /></a><br/>
		    <div style="height:12px;width:100px;overflow:hidden;font-size:7pt;padding-top:3px;">
			<table cellspacing="0" cellpadding="0"><tr><td><input type=checkbox value='<?php echo $key;?>' name="pix[]" style="padding:0;margin:0;"></td><td nowrap valign="top"><nobr><?php echo $picture->get('title');?></nobr></td></tr></table>
		    </div>
		</div>
	    <?php } ?>
	</form>
	<div style="clear:both;"></div>

	<hr size="1" />

	<a href="#" onclick="closeAll();document.getElementById('newPhoto').style.display = 'block';" style="font-size:8pt;" class="submit"><?php echo $this->txt('neues_foto');?></a>
	&nbsp;&nbsp;
	<a href="#" onclick="closeAll();document.getElementById('editAlbum').style.display = 'block';" style="font-size:8pt;" class="submit"><?php echo $this->txt('change_info');?></a>
	&nbsp;&nbsp;
	<a href="#" onclick="closeAll();document.getElementById('deletePictures').style.display = 'block';" style="font-size:8pt;" class="submit"><?php echo $this->txt('markierte_loeschen');?></a>
	&nbsp;&nbsp;
	<a href="#" onclick="closeAll();document.getElementById('deleteAlbum').style.display = 'block';" style="font-size:8pt;" class="submit"><?php echo $this->txt('album_loeschen');?></a>

	<script>
	    function closeAll() {
		document.getElementById('newPhoto').style.display = 'none';
		document.getElementById('editAlbum').style.display = 'none';
		document.getElementById('deletePictures').style.display = 'none';
		document.getElementById('deleteAlbum').style.display = 'none';
	    }
	</script>

	<div id="newPhoto" style="display: <?php echo ($VARS->getInt('openUpload')==1 ? 'block' : 'none'); ?>;">
	    <h2><?php echo $this->txt('neues_foto');?></h2>
	    <form action="<?php echo $VARS->get('contentLink');?>&album_id=<?php echo $albumSelect->get('id');?>" method="post" enctype="multipart/form-data">
		<input type="hidden" name="sendphoto" value="1" />
		<table>
		    <tr><td><?php echo $this->txt('titel');?>:</td>
		    <td><input type="text" name="newphototitle" value="" /></td></tr>
		    <tr><td><?php echo $this->txt('bild');?> (.jpg)</td>
		    <td><input type="file" name="newphoto" /></td></tr>
		    <tr>
			<td></td>
			<td><br/>
			    <input type="submit" value="<?php echo $this->txt('neues_foto');?>" class="submit" />
			</td>
		    </tr>
		</table>
	    </form>

	    <div style='padding: 5px 0 5px 0;'><?php echo $this->txt('oder');?></div>

	    <h2><?php echo $this->txt('mehrere_bilder_senden');?></h2>

	    <?php include dirname(__FILE__).'/tpl.multiupload_head.php'; ?>

		<div id='flup'>
			<table><tr><td>
			<span id="spanButtonPlaceHolder"></span>
			<input id="btnCancel" type="button" value="Cancel All Uploads" onclick="swfu.cancelQueue();" disabled="disabled" style="display:none;margin-left: 2px; font-size: 8pt; height: 29px;" />
			</td><td>
			    <?php echo $this->txt('infomulti');?>
			</td></tr></table>
		</div>
		<br>
		<div class="fieldset flash" id="fsUploadProgress" style="display:block;">
			<span class="legend"><?php echo $this->txt('uploadliste');?></span>
		</div>
		<div id="fluplist">
			<div id="fluplist2"></div>
			<form action="<?php echo $VARS->get('contentLink');?>&album_id=<?php echo $albumSelect->get('id');?>" method="post" id="uploadmultiform">
			    <input type="hidden" name="uploadmultifiles" id="uploadmultifiles" value="" />
			</form>
		</div>


	</div>

	<div id="editAlbum" style="display: none;">
	    <h2><?php echo $this->txt('change_info');?></h2>
	    <form action="<?php echo $VARS->get('contentLink');?>&album_id=<?php echo $albumSelect->get('id');?>" method="post" enctype="multipart/form-data">
		<input type="hidden" name="sendalbumdata" value="1" />
		<table>
		    <tr><td><?php echo $this->txt('titel');?>:</td><td>
			<input type="text" name="albumtitle" value="<?php  echo $albumSelect->get('name'); ?>" /><br/>
		    </td></tr>
		    <tr><td><?php echo $this->txt('datum');?>:</td><td>
			<input type="text" name="albumdatum" value="<?php echo date("d.m.Y", $albumSelect->get('date')); ?>" /><br/>
		    </td></tr>
		    <tr><td><?php echo $this->txt('sichtbarkeit');?>:</td><td>
			<select name="albumvisible">
			    <option value="public"><?php echo $this->txt('oeffentlich');?></option>
			    <option value="private" <?php if ($albumSelect->get('visible')=='private') echo "selected"; ?>><?php echo $this->txt('privat');?></option>
			</select>
		    </td></tr>
		     <tr>
			<td></td>
			<td><br/>
		<input type="submit" value="<?php echo $this->txt('sichern');?>" class="submit" />
			    </td>
		    </tr>
		</table>
	    </form>
	</div>

	<div id="deleteAlbum" style="display: none;">
	    <h2><?php echo $this->txt('album_loeschen');?></h2>
	    <form action="<?php echo $VARS->get('contentLink');?>&album_id=<?php echo $albumSelect->get('id');?>" method="post" enctype="multipart/form-data">
		<input type="checkbox" value="1" name="deletealbum" /> <?php echo $this->txt('markalbum');?><br/>
		<br/>
		<input type="submit" value="<?php echo $this->txt('album_loeschen');?>" class="submit" />
	    </form>
	</div>

	<div id="deletePictures" style="display: none;">
	    <h2><?php echo $this->txt('markierte_loeschen');?></h2>
	    <form action="<?php echo $VARS->get('contentLink');?>&album_id=<?php echo $albumSelect->get('id');?>" method="post" enctype="multipart/form-data">
		<input type="checkbox" value="1" name="deletebilder" onclick="document.getElementById('deletepictures').value=(this.checked ? 1 : 0);"/> <?php echo $this->txt('markbilder');?><br/>
		<br/>
		<input type="button" value="<?php echo $this->txt('markierte_loeschen');?>" onclick="document.getElementById('deletepicturesform').submit();" class="submit" />
	    </form>
	</div>