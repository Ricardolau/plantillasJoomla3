<?php
// Status Of Delimiter
$closeDelimiter = false;
$openTable = true;
$hiddenFields = '';

if(!empty($this->userFieldsCart['fields'])) {

	// Output: Userfields
	foreach($this->userFieldsCart['fields'] as $field) {
		// Solo mostramos si field['name'] es igual a customer_note , que el campo de comentarios.
		if ( $field['name'] == 'customer_note' ) {
	?>
			<fieldset class="vm-fieldset-<?php echo str_replace('_','-',$field['name']) ?>">
				<div  class="cart <?php echo str_replace('_','-',$field['name']) ?>" title="<?php echo strip_tags($field['description']) ?>">
				<span class="cart <?php echo str_replace('_','-',$field['name']) ?>" ><?php echo $field['title'] ?></span>

				<?php
					echo $field['formcode'] ?>
				</div>
			</fieldset>

	<?php
		}
	
	}
	
}
?>
