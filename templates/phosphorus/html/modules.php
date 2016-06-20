<?php
/**
 * @version		$Id: modules.php 8255 2007-07-30 23:37:23Z jinx $
 * @package		Joomla
 * @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

function modChrome_notitle($module, &$params, &$attribs)
{

$suffix = $params->get('moduleclass_sfx');
if ($suffix == "_menu") {
$suffix = "";
}

	if (!empty ($module->content)) : ?>
		<div class="moduletable<?php echo $params->get('moduleclass_sfx'); ?>">
			<?php echo $module->content; ?>
		</div>
	<?php endif;
}


function modChrome_round_box($module, &$params, &$attribs)
{

$suffix = $params->get('moduleclass_sfx');
if ($suffix == "_menu") {
$suffix = "";
}


	if (!empty ($module->content)) : ?>
	
			<?php if ($module->showtitle) : ?>
			
			<?php 
			
			$s5_h3 = strpos($module->title," ");
			
			if ($s5_h3 != "") {
			$s5_h3_beginning = substr($module->title, 0, $s5_h3);
			$s5_h3_end = substr($module->title, $s5_h3, 500);
			}
			else {
			$s5_h3_beginning = $module->title;
			$s5_h3_end = "";
			}
			
			?>
			
			<?php endif; ?>
			
		<?php if ($module->showtitle) { ?>
		<div class="module<?php echo $suffix ?>">		
			<div class="s5_moduletl<?php echo $suffix ?>">	
				<div class="s5_moduletr<?php echo $suffix ?>">	
					<div class="s5_moduletm<?php echo $suffix ?>">	
					</div>
				</div>	
			</div>
			<div class="s5_moduleml<?php echo $suffix ?>">
				<div class="s5_modulemr<?php echo $suffix ?>">	
					<div class="s5_modulemm<?php echo $suffix ?>">	
						<h3 class="s5_mod_h3<?php echo $suffix ?>"><span class="s5_h3_first"><?php echo $s5_h3_beginning ?> </span><?php echo $s5_h3_end ?></h3>
						<div class="spacer">
						<?php echo $module->content; ?>
						</div>
					</div>	
				</div>
			</div>
			<div class="s5_modulebl<?php echo $suffix ?>">	
				<div class="s5_modulebr<?php echo $suffix ?>">	
					<div class="s5_modulebm<?php echo $suffix ?>">	
					</div>
				</div>	
			</div>
		</div>
		<?php } else { ?>
		<div class="module<?php echo $suffix ?>">		
			<div class="s5_moduletl<?php echo $suffix ?>">	
				<div class="s5_moduletr<?php echo $suffix ?>">	
					<div class="s5_moduletm<?php echo $suffix ?>">	
					</div>
				</div>	
			</div>
			<div class="s5_moduleml<?php echo $suffix ?>">
				<div class="s5_modulemr<?php echo $suffix ?>">	
					<div class="s5_modulemm<?php echo $suffix ?>">	
						<?php echo $module->content; ?>
					</div>	
				</div>
			</div>
			<div class="s5_modulebl<?php echo $suffix ?>">	
				<div class="s5_modulebr<?php echo $suffix ?>">	
					<div class="s5_modulebm<?php echo $suffix ?>">	
					</div>
				</div>	
			</div>
		</div>
		<?php } ?>

	<?php endif;
}



?>