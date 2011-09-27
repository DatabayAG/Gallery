<style>


div.fieldset {
border:  1px solid #afe14c;
margin: 10px 0;
padding: 20px 10px;
}
div.fieldset span.legend {
position: relative;
background-color: #FFF;
padding: 3px;
top: -30px;
font: 700 14px Arial, Helvetica, sans-serif;
color: #73b304;
}

div.flash {
width: 375px;
margin: 10px 5px;
border-color: #D9E4FF;

-moz-border-radius-topleft : 5px;
-webkit-border-top-left-radius : 5px;
-moz-border-radius-topright : 5px;
-webkit-border-top-right-radius : 5px;
-moz-border-radius-bottomleft : 5px;
-webkit-border-bottom-left-radius : 5px;
-moz-border-radius-bottomright : 5px;
-webkit-border-bottom-right-radius : 5px;

}

#btnSubmit { margin: 0 0 0 155px ; }

.progressName {
font-size: 8pt;
font-weight: 700;
color: #555;
width: 323px;
height: 14px;
text-align: left;
white-space: nowrap;
overflow: hidden;
}

.progressBarInProgress,
.progressBarComplete,
.progressBarError {
font-size: 0;
width: 0%;
height: 2px;
background-color: blue;
margin-top: 2px;
}

.progressBarComplete {
width: 100%;
background-color: green;
visibility: hidden;
}

.progressBarError {
width: 100%;
background-color: red;
visibility: hidden;
}

.progressBarStatus {
margin-top: 2px;
width: 337px;
font-size: 7pt;
font-family: Arial;
text-align: left;
white-space: nowrap;
}

a.progressCancel {
font-size: 0;
display: block;
height: 14px;
width: 14px;
background-image: url(Customizing/global/plugins/Services/Repository/RepositoryObject/Gallery/templates/swfupload/cancelbutton.gif);
background-repeat: no-repeat;
background-position: -14px 0px;
float: right;
}

a.progressCancel:hover {
background-position: 0px 0px;
}


/* -- SWFUpload Object Styles ------------------------------- */
.swfupload {
vertical-align: top;
}
</style>




<script type="text/javascript" src="Customizing/global/plugins/Services/Repository/RepositoryObject/Gallery/templates/swfupload/swfupload.js"></script>
<script type="text/javascript" src="Customizing/global/plugins/Services/Repository/RepositoryObject/Gallery/templates/swfupload/js/swfupload.queue.js"></script>
<script type="text/javascript" src="Customizing/global/plugins/Services/Repository/RepositoryObject/Gallery/templates/swfupload/js/fileprogress.js"></script>
<script type="text/javascript" src="Customizing/global/plugins/Services/Repository/RepositoryObject/Gallery/templates/swfupload/js/handlers.js"></script>
<script type="text/javascript">
var swfu;

function WaitForInitSWF() {
	// {{{
	if(document.getElementById('fluplist')) {
		doInitSWF();
	} else {
		setTimeout("WaitForInitSWF()", 1000);
	}
	// }}}
}
setTimeout("WaitForInitSWF()", 1000);

function doInitSWF() {
	// {{{

	var settings = {
		flash_url : "Customizing/global/plugins/Services/Repository/RepositoryObject/Gallery/templates/swfupload/Flash/swfupload.swf",
		xupload_url : "<?php echo $VARS->get('contentLink');?>&album_id=<?php echo $albumSelect->get('id');?>&PHPSESSID=<?php echo session_id(); ?>&multiupload=1",
		// $_GET["ref_id"]=53&amp;cmd=showContent&amp;cmdClass=ilobjgallerygui&amp;cmdNode=5c:jc&amp;baseClass=ilObjPluginDispatchGUI&album_id=1315481690.5973&PHPSESSID=bpviinepbauae3m6rj1jrjcu41&multiupload=1",

		upload_url : "Customizing/global/plugins/Services/Repository/RepositoryObject/Gallery/upload.php?album_id=<?php echo $_GET['album_id'] ?>&ilClientId=<?php echo $_COOKIE['ilClientId']; ?>",
		post_params: {"PHPSESSID" : "<?php echo session_id(); ?>"},
		file_size_limit : "10000 KB",
		file_types : "*.jpg;*.JPG",
		file_types_description : "Files",
		file_upload_limit : 1000,
		file_queue_limit : 1000,
		custom_settings : {
			progressTarget : "fsUploadProgress",
			cancelButtonId : "btnCancel"
		},
		debug: false,

		// Button settings
		button_image_url: "Customizing/global/plugins/Services/Repository/RepositoryObject/Gallery/templates/swfupload/XPButtonUploadText_61x22.png",
		button_width: "61",
		button_height: "22",
		button_placeholder_id: "spanButtonPlaceHolder",
		button_text: '',
		button_text_style: ".theFont { font-size: 16; }",
		//button_text_left_padding: 12,
		//button_text_top_padding: 3,
		
		// The event handler functions are defined in handlers.js
		file_queued_handler : fileQueued,
		file_queue_error_handler : fileQueueError,
		file_dialog_complete_handler : fileDialogComplete,
		upload_start_handler : uploadStart,
		upload_progress_handler : uploadProgress,
		upload_error_handler : uploadError,
		upload_success_handler : uploadSuccess,
		upload_complete_handler : uploadComplete,
		queue_complete_handler : queueComplete	// Queue plugin event
	};

	swfu = new SWFUpload(settings);
	// }}}
}

function uploadStart2() {
	//document.getElementById("flup").style.display = "none";
	//document.getElementById("fsUploadProgress").style.display = "block";
	uploadStart();
}

function queueComplete(numFilesUploaded) {
    // window.location = '[[page]]?complete=1';
	//document.getElementById('fsUploadProgress').innerHTML = "";
	
	//var status = document.getElementById("divStatus");
	//status.innerHTML = numFilesUploaded + " file" + (numFilesUploaded === 1 ? "" : "s") + " uploaded.";

	//window.location = "<?php echo str_replace('&amp;','&',$VARS->get('contentLink'));?>&album_id=<?php echo $albumSelect->get('id');?>";
	document.getElementById('uploadmultiform').submit();;
	uploadRefresh();
}
 
 
 function uploadRefresh() {
	//document.getElementById("flup").style.display = "block";
	//document.getElementById("fsUploadProgress").style.display = "none";
	
	//document.getElementById('fluplistiframe').src = "{UPLOADFILE}?multiUploadInfo={USERSID}";
	//alert('upload refresh');


}

function deleteAuswahl() {
	//document.getElementById('fluplistiframe').src = "{UPLOADFILE}?multiUploadDel={USERSID}";
	alert('delete auswahl');
}

function uploadComplete(file) {
	//console.log(file.name);
	document.getElementById('uploadmultifiles').value += file.name+',';
	if (this.getStats().files_queued === 0) {
		document.getElementById(this.customSettings.cancelButtonId).disabled = true;
	}
}

 
</script>
