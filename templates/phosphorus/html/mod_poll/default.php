<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<script type="text/javascript">

function s5pollhover(id){
<?php for ($i = 0, $n = count($options); $i < $n; $i ++) : ?>document.getElementById('voteid<?php echo $options[$i]->id;?>').className = 's5_radiobutton';	<?php endfor; ?>	
document.getElementById(id).className = 's5_radiobutton_active';}

function s5clickradio(id) {document.getElementById(id).checked = true;}

</script>

<form action="index.php" method="post" name="form2">
<div style="padding-left:6px;">

	<?php for ($i = 0, $n = count($options); $i < $n; $i ++) : ?>	
	<input type="radio" class="s5_radiobuttonnv" name="voteid" id="rvoteid<?php echo $options[$i]->id;?>" value="<?php echo $options[$i]->id;?>" alt="<?php echo $options[$i]->id;?>" />		
	<label class="s5_radiobutton" onclick="s5clickradio('rvoteid<?php echo $options[$i]->id;?>');s5pollhover(this.id);" id="voteid<?php echo $options[$i]->id;?>">
		<?php echo $options[$i]->text; ?>
	</label>		
	<br/>
	<?php
	$tabcnt = 1 - $tabcnt;
	?>
	<?php endfor; ?>
<br/>
</div>
<div align="center">	
	<input type="submit" name="task_button" class="button" onclick="getid();" value="<?php echo JText::_('Vote'); ?>" />
	&nbsp;
	<input type="button" name="option" class="button" value="<?php echo JText::_('Results'); ?>" onclick="document.location.href='<?php echo JRoute::_("index.php?option=com_poll&id=$poll->slug".$itemid); ?>'" />
</div>
	<input type="hidden" name="option" value="com_poll" />
	<input type="hidden" name="task" value="vote" />
	<input type="hidden" name="id" value="<?php echo $poll->id;?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>