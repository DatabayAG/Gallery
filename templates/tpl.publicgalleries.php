
	<?php foreach($VARS->get('ppictures') as $key => $picture) { ?>
		<div style="margin:0 5px 5px 0;border: solid 1px gray;background-color: white;float:left;padding:5px;">
		    <a  href="<?php echo $VARS->get('contentLink').'&palbum_id='.$_GET['palbum_id'].'&imgout='.$key; ?>&width=1000&height=800" rel="img_group" class="lytebox" data-lyte-options="group:album" data-title="<?php echo $picture->get('title');?>"  title="<?php echo $picture->get('title');?>" onclick="return false;" ><img src='<?php echo $VARS->get('contentLink').'&palbum_id='.$_GET['palbum_id'].'&imgout='.$key; ?>&width=100&height=100&upscale=1&quad=1' title="<?php echo $picture->get('title');?>" width="100" height="100" /></a><br/>
        </div>
	    <?php } ?>
	    
