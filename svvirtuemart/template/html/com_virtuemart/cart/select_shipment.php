<?php
/**
 *
 * Template for the shipment selection
 *
 * @package	VirtueMart
 * @subpackage Cart
 * @author Max Milbers
 *
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: cart.php 2400 2010-05-11 19:30:47Z milbo $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');


if (VmConfig::get('oncheckout_show_steps', 1)) {
	echo '<div class="checkoutStep" id="checkoutStep2">' . vmText::_('COM_VIRTUEMART_USER_FORM_CART_STEP2') . '</div>';
}
if($this->cart->virtuemart_shipmentmethod_id){
	echo '<p class="vm-shipment-header-selected">'.vmText::_('COM_VIRTUEMART_CART_SELECTED_SHIPMENT_SELECT').'</p>';
} else {
	echo '<p class="vm-shipment-header-select">'.vmText::_('COM_VIRTUEMART_CART_SELECT_SHIPMENT').'</p>';
}
if ($this->layoutName!='default') {
	$headerLevel = 1;
	if($this->cart->getInCheckOut()){
			$buttonclass = 'button vm-button-correct';
		} else {
			$buttonclass = 'default';
	}
	?>
	<form method="post" id="shipmentForm" name="chooseShipmentRate" action="<?php echo JRoute::_('index.php'); ?>" class="form-validate">
	<?php
	} else {
		$headerLevel = 3;
		$buttonclass = 'vm-button-correct';
}

	if ($this->found_shipment_method ) {
		echo '<fieldset class="vm-payment-shipment-select vm-shipment-select">';
		// if only one Shipment , should be checked by default
		
		foreach ($this->shipments_shipment_rates as $shipment_shipment_rates) {
			if (is_array($shipment_shipment_rates)) {
				foreach ($shipment_shipment_rates as $shipment_shipment_rate) {
					echo '<div class="vm-shipment-plugin-single">';
					echo $shipment_shipment_rate;
					echo '</div>';
					//~ $array = strip_tags($shipment_shipment_rate, '<br>');
					//~ echo '<pre>';
					//~ print_r($array);
					//~ echo '</pre>';
				}
			}
		}
		echo '</fieldset>';
	} else {
		// Advertencia de que no hay ninguna forma envio para la zona
		?>
		<div class="alert alert-warning" style="display:table;">
		<?php
		echo $this->shipment_not_found_text;
		echo '<br/>'."Revisa tu direccion de envió !!!";
		?>
		</div>
		
		<?php
	}
?>
<?php  // No encuentro forma extraer datos de formas de envio.. 
	   // solo con $this->shipments_shipment_rates
	   // donde muestra una array con los plugin de shipments que hay y dentro ellos
	   // array con la metodos de envio... 
	   // Creo que la unica forma , sería generando todo nosotros, un coñazo..
	   
		//~ echo '<pre>';
		//~ print_r($viewData);
		//~ echo '</pre>';
?>
<div>
		<?php 
		$dynUpdate = '';
		if( VmConfig::get('oncheckout_ajax',false)) {
		$dynUpdate=' data-dynamic-update="1" ';
		} ?>
		<button name="updatecart" class="<?php echo $buttonclass ?>" type="submit" <?php echo $dynUpdate ?> ><?php echo vmText::_('COM_VIRTUEMART_SAVE'); ?></button>

		<?php   if ($this->layoutName!='default') { ?>
			<button class="<?php echo $buttonclass ?>" type="reset" onClick="window.location.href='<?php echo JRoute::_('index.php?option=com_virtuemart&view=cart&task=cancel'); ?>'" ><?php echo vmText::_('COM_VIRTUEMART_CANCEL'); ?></button>
		<?php  } ?>
</div>
<?php

	if ($this->layoutName!='default') {
	?> <input type="hidden" name="option" value="com_virtuemart" />
	<input type="hidden" name="view" value="cart" />
	<input type="hidden" name="task" value="updatecart" />
	<input type="hidden" name="controller" value="cart" />
</form>
<?php
}
?>

