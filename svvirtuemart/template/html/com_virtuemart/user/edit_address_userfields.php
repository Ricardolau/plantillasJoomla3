<?php

/**
 *
 * Modify user form view, User info
 *
 * @package	VirtueMart
 * @subpackage User
 * @author Oscar van Eijk, Eugen Stranz
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: edit_address_userfields.php 8895 2015-07-02 05:51:05Z kkmediaproduction $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
// Hay que tener en cuenta que muestra que el bucle va
// leer todos los campos, y hay unos campos que son delimitadores
// Es decir campos que van indicar que cambia de grupo.
// por ello se crea las variables $closeDelimiter -> Que indica que cierra delimitado si cambia...(true)
// 
// Status Of Delimiter
$closeDelimiter = false;
$openTable = true;
$hiddenFields = '';
$cont_x =0;
?>
<script language="javascript">
function myValidator(f, t) {
  f.task.value = t; //this is a method to set the task of the form on the fTask.
  if (document.formvalidator.isValid(f)) {
  f.submit();
  return true;
  } else {
  var msg = '<?php echo addslashes (JText::_ ('COM_VIRTUEMART_USER_FORM_MISSING_REQUIRED_JS')); ?>';
  alert(msg + ' ');
  }
  return false;
}
 
function callValidatorForRegister(f, t){
  document.getElementById('name_field').value = document.getElementById('username_field').value;
  return myValidator(userForm, true);
 
}
 
</script>


<?php
// Output: Userfields


foreach($this->userFields['fields'] as $field) {
$cont_x= $cont_x + 1;
?>
<!-- Estamos en bucle -->
<?php 
	if($field['type'] == 'delimiter') {

		// For Every New Delimiter
		// We need to close the previous
		// table and delimiter
		?>
		<!-- Delimitador -->
		
		<?php 
		if($closeDelimiter) { ?>
				</table>
			</fieldset>
			<?php
			$closeDelimiter = false;
		} 
			?>
			
			<fieldset>
			<span class="userfields_info"><?php echo $field['title'] ?></span>

			<?php
			$closeDelimiter = true;
			$openTable = true;
		

	} else {
		if ($field['hidden'] == true) {

		// We collect all hidden fields
		// and output them at the end
		$hiddenFields .= $field['formcode'] . "\n";

		} else {

		// If we have a new delimiter
		// we have to start a new table
		if($openTable) {
			$openTable = false;
			?>
			<table class="adminForm user-details">
				<!-- Generamos tabla para cargar campos registro usuario -->


		<?php
		}
		$descr = empty($field['description'])? $field['title']:$field['description'];
		// Output: Userfields
		?>
				<?php
					// Ahora debemos comprobar si el campo es name.. "Nombre Mostrado"
					// Este lo creamos oculto con el mismo valor de usuario.
					if ($field['name'] != 'name'){
					
					?>
					<tr title="<?php echo strip_tags($descr) ?>">
						
						<td class="key"  >
							<label class="<?php echo $field['name'] ?>" for="<?php echo $field['name'] ?>_field">
								<?php echo $field['title'] . ($field['required'] ? ' *' : '') ?>
							</label>
						</td>
						<td>
							<?php echo $field['formcode'] ?>
						</td>
					</tr>
					<?php
					} else {
					// Quiere decir que es campo Nombre Mostrado
					// Lo metemos como oculto
					?>
					
					<tr title="<?php echo strip_tags($descr) ?>" style="display:none;">
						
						<td class="key"  >
							<label class="<?php echo $field['name'] ?>" for="<?php echo $field['name'] ?>_field">
								<?php echo $field['title'] . ($field['required'] ? ' *' : '') ?>
							</label>
						</td>
						<td>
							<input id="name_field" name="name" size="30" value="" type="text">				
						</td>
					</tr>
					<?php
					
					}
					?>
		<?php
		}
	}

}

// Al final tenemos que cerrar tabla y fieldset
?>

			</table>
		</fieldset>

<?php 
//~ echo '<pre>';
//~ print_r($this->userFields['fields']);
//~ echo '</pre>';

// Output: Hidden Fields
echo $hiddenFields
?>
