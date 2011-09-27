<h3><?php echo $this->txt('meine_alben');?></h3>
<?php foreach($VARS->get('albums') as $key => $value) { ?>

    <div style="margin:0 5px 5px 0;border: solid 1px gray;background-color: white;float:left;padding:5px;">
	<a href="<?php echo $VARS->get('contentLink');?>&album_id=<?php echo $value->get('id'); ?>" title="<?php echo $value->get('name');?>"><img src='Customizing/global/plugins/Services/Repository/RepositoryObject/Gallery/templates/images/icon_xgal_b.gif' width="100" height="100" /></a><br/>
	<div style="width:80px;overflow:hidden;text-align:center;"><nobr>
		<?php echo $value->get('name');?><br/>
	<?php echo $value->get('files')->count().' '.($value->get('files')->count()==1 ? $this->txt('Bild') : $this->txt('Bilder')); ?>
	</nobr></div>

    </div>

<?php } ?>
<div style="clear:both;"></div>
<hr size="1" />
<h3><?php echo $this->txt('freie_alben');?></h3>
<?php foreach($VARS->get('publics') as $key2 => $value2) { ?>
    <?php foreach($value2 as $key => $value) { 
	if($value->get('visible')=='public') {?>

    <div style="margin:0 5px 5px 0;border: solid 1px gray;background-color: white;float:left;padding:5px;">
	<a href="<?php echo $VARS->get('contentLink');?>&palbum_id=<?php echo $value->get('id'); ?>" title="<?php echo $value->get('name');?>"><img src='Customizing/global/plugins/Services/Repository/RepositoryObject/Gallery/templates/images/icon_xgal_b.gif' width="100" height="100" /></a><br/>
	<div style="width:80px;overflow:hidden;text-align:center;"><nobr>
		<?php echo $value->get('name');?><br/>
	<?php echo $value->get('files')->count().' '.($value->get('files')->count()==1 ? $this->txt('Bild') : $this->txt('Bilder')); ?>
	    </nobr></div>

    </div>
<?php } } ?>
<?php } ?>
<div style="clear:both;"></div>
