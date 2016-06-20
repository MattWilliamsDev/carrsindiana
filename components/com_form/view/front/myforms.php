<?php
/* Must be logged in! */
$user = bfUser::getInstance();
if ($user->get('id')=="0"){
	echo '<h1>'.bfText::_('Please login').'</h1><p>'.bfText::_('You need to be logged in to see your forms').'</p>';
	return;
}

/*
 * First sortout what actions we are allowed to do.
 *  public 'allowpause' => string '1' (length=1)
 *  public 'allowownsubmissionedit' => string '1' (length=1)
 * public 'allowownsubmissiondelete' => string '0' (length=1)
 */

// Create keyed array for easier access
$formsArray = array ();
foreach ( $this->forms as $form ) {
	$formsArray [$form->id] = $form;
}
?>


<h1 class="componentheading"><?php
echo bfText::_ ( 'Your Forms' );
?></h1>

<table style="width: 100%;" class="contentpane">
	<thead>
		<tr>
			<th class="sectiontableheader" width="20">Id</th>
			<th class="sectiontableheader">Form Name</th>
			<th class="sectiontableheader" width="150">Status</th>
			<th class="sectiontableheader" width="250">Actions Available</th>
		</tr>
	</thead>

	<?php
	$k = 0;
	foreach ( $this->mysubmissions as $s ) {
		
		?>
	<tr class="row<?php
		echo $k;
		?>">
		<td><?php
		echo $s->id;
		?></td>
		<td><?php
		echo $s->bf_form_name;
		?></td>
		<td><?php
		echo $s->bf_status;
		?></td>
		<td><?php
		view_myforms_actions ( $s, $formsArray );
		?></td>
	</tr>
	<?php
		$k = 1 - $k;
	}
	?>
</table>

<?php
function view_myforms_actions($s, $fA) {
	if ($s->bf_status == 'Deleted') return;

	if ($fA [$s->bf_form_id]->allowownsubmissionedit == "1") {
		echo '<a style="text-decoration:none;" href="index.php?option=com_form&form_id=' . $s->bf_form_id . '&submission_id=' . $s->id . '&task=edit">
		<img border="0" width="16" height="16" src="plugins/system/blueflame/view/images/bullet-element.gif" alt="Edit" align="absmiddle" class="icon"/>&nbsp;' . bfText::_ ( 'Resume' ) . '</a>';
		echo '&nbsp;&nbsp;&nbsp;';
	}
	
	if ($fA [$s->bf_form_id]->allowownsubmissiondelete == "1") {
		echo '<a style="text-decoration:none;" href="index.php?option=com_form&form_id=' . $s->bf_form_id . '&submission_id=' . $s->id . '&task=delete">
		<img border="0" width="16" height="16" src="plugins/system/blueflame/view/images/bullet-delete.gif" alt="Delete" align="absmiddle" class="icon"/>&nbsp;' . bfText::_ ( 'Delete' ) . '</a>';
	}
	
/* @todo Add View :-) */
//if ($fA[$s->bf_form_id]->allowownsubmissiondelete == "1") {
//		echo '<a style="text-decoration:none;" href="index.php?option=com_form&form_id='.$s->bf_form_id.'&submission_id='.$s->id.'&task=delete">
//		<img width="16" height="16" src="plugins/system/blueflame/view/images/bullet-delete.gif" alt="Edit" align="absmiddle" class="icon"/>'. bfText::_('Delete').'</a>';
//	}
}

