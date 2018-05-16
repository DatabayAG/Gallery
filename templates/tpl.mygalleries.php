
	<?php echo $this->txt('obj_xgal');?>: <b><?php  echo $albumSelect->get('name'); ?></b> <?php echo $this->txt('vom');?> <b><?php echo ilDatePresentation::formatDate(new ilDate(date("Y-m-d",$albumSelect->get('date')),IL_CAL_DATE)); ?></b>
	<hr size="1" />

	<form action="<?php echo $VARS->get('contentLink');?>&album_id=<?php echo $albumSelect->get('id');?>" method="post" enctype="multipart/form-data" id="deletepicturesform">
	    <input type="hidden" name="deletepictures" id="deletepictures" value="0" />
	    <?php
        foreach($VARS->get('pictures') as $key => $picture) { ?>
		<div style="margin:0 5px 5px 0;border: solid 1px gray;background-color: white;float:left;padding:5px;">
		    <a href="<?php echo $VARS->get('contentLink').'&album_id='.$albumSelect->get('id').'&imgout='.$key; ?>&width=1000&height=800" rel="img_group" class="lytebox" data-lyte-options="group:album" data-title="<?php echo $picture->get('title');?>" title="<?php echo $picture->get('title');?>" onclick="return false;"><img src='<?php echo $VARS->get('contentLink').'&album_id='.$albumSelect->get('id').'&imgout='.$key; ?>&width=100&height=100&upscale=1&quad=1' title="<?php echo $picture->get('title');?>" width="100" height="100" /></a><br/>
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

        $(function() {
	    		    $('a[rel=img_group]').fancybox({
                        'type' : 'image',
                        'autoPlay'   : '<?php echo (bool)$VARS->get('slideshow_enabled'); ?>',
                         'playSpeed'  : '<?php echo $VARS->get('slideshow_seconds')*1000; ?>',
                        'preload'    : '3',
                        'loop'       : '<?php echo (bool)$VARS->get('slideshow_repeat'); ?>'
                    });
	    });
	    
	</script>

	<style>
	    .around {
		padding: 5px;
		border: solid 1px silver;
		border-radius: 5px;
	    }
	    </style>

	    <br/><br/>

	<div id="newPhoto" style="display: <?php echo ($VARS->getInt('openUpload')==1 ? 'block' : 'none'); ?>;">

	    <div class="around">
		<img src="Customizing/global/plugins/Services/Repository/RepositoryObject/Gallery/templates/images/close.png" style="float:right;" onmouseover="style.cursor='pointer';" onclick="closeAll();" />
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

		<script>
		var hasFlash = false;
		try {
		  var fo = new ActiveXObject('ShockwaveFlash.ShockwaveFlash');
		  if(fo) hasFlash = true;
		}catch(e){
		  if(navigator.mimeTypes ["application/x-shockwave-flash"] != undefined) hasFlash = true;
		}
		
		var inp = document.createElement("input");
		inp.setAttribute("multiple", "true");
		var supportsMultiple = inp.multiple===true;
		if(supportsMultiple) hasFlash = false;
		
		</script>

		<div style="display:none;" id="enableflashupload">
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
		 <script>
		    if(hasFlash==true) document.getElementById('enableflashupload').style.display = 'block';
		</script>

		
		<div style="display:none;" id="enablemultiupload2">
			<div style='padding: 5px 0 5px 0;'><?php echo $this->txt('oder');?></div>
			<h2><?php echo $this->txt('mehrere_bilder_senden');?></h2>
			
			<form action="<?php echo $VARS->get('contentLink');?>&album_id=<?php echo $albumSelect->get('id');?>" method="post" id="uploadmultiform2">
				<input type="hidden" name="uploadmultifiles" id="uploadmultifiles2" value="" />
				<input type="file" multiple id="uploadmulti2" onchange="uploadFiles();">
			</form>
			<?php echo $this->txt('infomulti');?>
			


			<script>
			
			var fileList = [];
			function uploadFiles() {
				var obj = document.getElementById("uploadmulti2");
			
				for(var i=0;i<obj.files.length;i++) {
					var filename = obj.files[i].name;
					var ext = filename.split(".");
					if(ext.length==0) continue;
					ext = ext[ext.length-1].toLowerCase();
					if(ext!="jpg") continue;
					
					uploadsToDo++;
					fileList.push(obj.files[i]);
				}
				setTimeout(function() { runUploads(); }, 100);
			}
			
			function runUploads() {
			
				if(running>1) {
					setTimeout(function() { runUploads(); }, 100);
					return;
				}
			
				if(fileList.length>0) {
					var file = fileList.pop();
					uploadOneFile(file);
					setTimeout(function() { runUploads(); }, 100);
				}
			}
			
			var progressNr=0;
			var uploadsToDo = 0;
			var running = 0;
			
			function uploadOneFile(file) {
			//console.log(file);
				running++;
			
				progressNr++;
				progress = '<div id="progressBarDiv' + progressNr + '"><progress id="progressBar' + progressNr + '" value="0" max="100" style="width:300px;"></progress>&nbsp;'+file.name+'</div>';
			
				var obj = document.getElementById("fluplist2");
				$(obj).append(progress);
			
				//console.log(progressNr);
				//return;
			
				var formdata = new FormData();
				formdata.append("Filedata", file );
			
				var ajax = new XMLHttpRequest();
				progressData = {
					"id": 'progressBar' + progressNr,
					"id2": 'progressBarDiv' + progressNr,
					"progress": function(event) {
						var percent = (event.loaded / event.total) * 100;
						$('#' + this.id).val(Math.round(percent));
					},
					"done": function(event) {
						var T = event.target.responseText;
						$('#' + this.id2).remove();
						uploadsToDo--;
						running--;
						document.getElementById('uploadmultifiles2').value += file.name+',';
						if(uploadsToDo==0) {
							//window.location = '';
							//alert("Fertig");
							document.getElementById('uploadmultiform2').submit();
						}
					}
			
				};
				ajax.upload.addEventListener("progress", $.proxy(progressData.progress, progressData), false);
			
				ajax.addEventListener("load", $.proxy(progressData.done, progressData), false);
				ajax.addEventListener("error", function(event) { }, false);
				ajax.addEventListener("abort", function(event) { }, false);
				ajax.open("POST", "Customizing/global/plugins/Services/Repository/RepositoryObject/Gallery/upload.php?album_id=<?php echo $_GET['album_id'] ?>&ilClientId=<?php echo $_COOKIE['ilClientId']; ?>");
				ajax.send(formdata);
			}
			
			</script>			
			
		</div>
		
		 <script>
		    if(supportsMultiple==true) document.getElementById('enablemultiupload2').style.display = 'block';
		</script>
		
		
		</div>
	</div>

	<div id="editAlbum" style="display: none;">
    	    <div class="around">
		<img src="Customizing/global/plugins/Services/Repository/RepositoryObject/Gallery/templates/images/close.png" style="float:right;" onmouseover="style.cursor='pointer';" onclick="closeAll();" />

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
	</div>

	<div id="deleteAlbum" style="display: none;">
       	    <div class="around">
		<img src="Customizing/global/plugins/Services/Repository/RepositoryObject/Gallery/templates/images/close.png" style="float:right;" onmouseover="style.cursor='pointer';" onclick="closeAll();" />

		<h2><?php echo $this->txt('album_loeschen');?></h2>
		<form action="<?php echo $VARS->get('contentLink');?>&album_id=<?php echo $albumSelect->get('id');?>" method="post" enctype="multipart/form-data">
		    <input type="checkbox" value="1" name="deletealbum" /> <?php echo $this->txt('markalbum');?><br/>
		    <br/>
		    <input type="submit" value="<?php echo $this->txt('album_loeschen');?>" class="submit" />
		</form>
	    </div>
	</div>

	<div id="deletePictures" style="display: none;">
       	    <div class="around">
		<img src="Customizing/global/plugins/Services/Repository/RepositoryObject/Gallery/templates/images/close.png" style="float:right;" onmouseover="style.cursor='pointer';" onclick="closeAll();" />

		<h2><?php echo $this->txt('markierte_loeschen');?></h2>
		<form action="<?php echo $VARS->get('contentLink');?>&album_id=<?php echo $albumSelect->get('id');?>" method="post" enctype="multipart/form-data">
		    <input type="checkbox" value="1" name="deletebilder" onclick="document.getElementById('deletepictures').value=(this.checked ? 1 : 0);"/> <?php echo $this->txt('markbilder');?><br/>
		    <br/>
		    <input type="button" value="<?php echo $this->txt('markierte_loeschen');?>" onclick="document.getElementById('deletepicturesform').submit();" class="submit" />
		</form>
	    </div>
	</div>