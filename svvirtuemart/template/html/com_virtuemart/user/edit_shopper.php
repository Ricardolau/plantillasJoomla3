<?php
/**
 *
 * Modify user form view, User info
 *
 * @package	VirtueMart
 * @subpackage User
 * @author Oscar van Eijk
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: edit_shopper.php 8565 2014-11-12 18:26:14Z Milbo $
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
//~ $titulo = "Editando direccion principal";

if ($_GET) {
		//~ echo '<pre>';
		//~ print_r($_GET);
		//~ echo '</pre>';
		if ($_GET['Itemid'] == 329) {
			// En el momento que cambiemos de item deja de fucionar... 
			$Itemdemenu= "Direcciones";
			if ($_GET['virtuemart_userinfo_id']){
			$titulo = "Editando direccion secundaria";
			echo '<h2>'.$titulo.'</h2>';
			} else {
			$titulo = "Editando direccion principal";
			echo '<h2>'.$titulo.'</h2>';	
			}

		} else {
			$Itemdemenu= "Detalles"; 
		}
}



?>

<!-- Estoy en template virtuemart/user/edit_shopper --> 


<?php
if( $this->userDetails->virtuemart_user_id!=0) {
  ?>
  <!-- Vamos a edit_vmshopper --> 
  <?php
	// Solo cargamos Informacion comprado si no es itemd =329
	if ($Itemdemenu != "Direcciones"){
	
    echo $this->loadTemplate('vmshopper');
	}
}
?>
<!-- Vamos a edit_address_userfields --> 

<?php

echo $this->loadTemplate('address_userfields');
?>
<?php
if(!$this->userDetails->user_is_vendor){ 
  // Entramos aquí para mostrar bottones de guardar o cancelar si es distinto de vendedor
  ?>
    <div class="buttonBar-right">
	    <!-- Mostrar buttonBar de edit_shopper.php -->
	    <button class="button" type="submit" onclick="javascript:return callValidatorForRegister(userForm, true);" ><?php echo $this->button_lbl ?></button>
	    &nbsp;
	    <button class="button" type="reset" onclick="window.location.href='<?php echo JRoute::_('index.php?option=com_virtuemart&view=user', FALSE); ?>'" ><?php echo vmText::_('COM_VIRTUEMART_CANCEL'); ?></button>
    </div>
<?php } ?>




<?php
if(!empty($this->virtuemart_userinfo_id)){
	echo '<input type="hidden" name="virtuemart_userinfo_id" value="'.(int)$this->virtuemart_userinfo_id.'" />';
}
?>
<input type="hidden" name="task" value="saveUser" />
<input type="hidden" name="address_type" value="<?php echo $this->address_type; ?>"/>

