<?php
// Status Of Delimiter
$closeDelimiter = false;
$openTable = true;
$hiddenFields = '';

if(!empty($this->userFieldsCart['fields'])) {
?>
<!-- Estamos en default_fieldspie -->
<div class="terms-of-service">

<?php
	// Output: Userfields
	foreach($this->userFieldsCart['fields'] as $field) {
		// El campo de comentario no lo mostramos ya que lo mostramos antes, al carga template comentarios.
		if ( $field['name'] !== 'customer_note' ) {

	?>
		<fieldset class="vm-fieldset-<?php echo str_replace('_','-',$field['name']) ?>">
			<div  class="cart <?php echo str_replace('_','-',$field['name']) ?>" title="<?php echo strip_tags($field['description']) ?>">
			<span class="cart <?php echo str_replace('_','-',$field['name']) ?>" ><?php echo $field['title'] ?></span>
			<?php
			if ($field['hidden'] == true) {
			// Recopilamos todos los campos ocultos
			// Y la salida de ellos, al final
			$hiddenFields .= $field['formcode'] . "\n";
			} else { ?>
				<?php 
					echo $field['formcode'] 
				?>
			</div>
			<?php 
			} ?>
		</fieldset>
		<?php
		}
	}
	// Output: Hidden Fields
	echo $hiddenFields;
}
?>
</div>
