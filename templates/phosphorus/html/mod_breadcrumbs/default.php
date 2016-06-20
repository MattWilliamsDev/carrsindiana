<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<div class="breadcrumbs pathway">
<?php for ($i = 0; $i < $count; $i ++) :

	// If not the last item in the breadcrumbs add the separator
	
	if ($count > 1) {

		if ($i < $count -1) {
		
			if ($i == 0) {
				echo '<div class="pathway_first"><div class="pathway_first_wrapper"><a href="'.$list[$i]->link.'">'.$list[$i]->name.'</a></div></div>';
		echo '<div class="pathway_middle"> <img src="templates/phosphorus/images/Shape5_GetReserved_grayarrow.png" alt="arrow"/> </div>';
			}
			
			if ($i > 0) {
			
					if(!empty($list[$i]->link)) {
						echo '<div class="pathway_middle"><div class="pathway_middle_wrapper"><a href="'.$list[$i]->link.'">'.$list[$i]->name.'</a></div></div>';
					} else {
						echo $list[$i]->name;
					}
					echo '<div class="pathway_middle"> <img src="templates/phosphorus/images/Shape5_GetReserved_grayarrow.png" alt="arrow"/> </div>';
					
			}
			
		}  else if ($params->get('showLast', 1)) { // when $i == $count -1 and 'showLast' is true
		   echo '<div class="pathway_last"><div class="pathway_last_wrapper">'.$list[$i]->name.'</div></div>';
		}
		
	}
	
	else {
		echo '<div class="pathway_first"><div class="pathway_first_wrapper"><a href="'.$list[$i]->link.'">'.$list[$i]->name.'</a></div></div>';
	}
endfor; ?>
</div>
