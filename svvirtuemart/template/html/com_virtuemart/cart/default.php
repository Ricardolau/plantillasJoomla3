<?php
/**
 *
 * Layout for the shopping cart
 *
 * @package    VirtueMart
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
 * @version $Id: cart.php 2551 2010-09-30 18:52:40Z milbo $
 */

// Check to ensure this file is included in Joomla!
defined ('_JEXEC') or die('Restricted access');

JHtml::_ ('behavior.formvalidation');
?>

<div id="cart-view" class="cart-view">
	<div class="vm-cart-header container">
		<div class="blog">
		<h1><?php echo vmText::_ ('COM_VIRTUEMART_CART_TITLE'); ?></h1>
		<?php if (VmConfig::get ('oncheckout_show_steps', 1) && $this->checkout_task === 'confirm') {
			echo '<div class="checkoutStep" id="checkoutStep4">' . vmText::_ ('COM_VIRTUEMART_USER_FORM_CART_STEP4') . '</div>';
		} ?>
		
		<?php
		// Solo entramos si el usuario logueado es el administrador de la tienda
		// Este formulario nos permite seleccionar un comprador.
		// Es decir nos deja comprar por un usuarios.
					if ($this->allowChangeShopper){
			?>
			<div class="NuevoComprador text-center">
			<?php
				echo $this->loadTemplate ('shopperform');
			?>
			
			</div>
			<?php
			}
		// Fin de formulario de Cambiar Comprador
			?>
			

			
		</div>
		<div class="clear"></div>
	</div>

	<?php
	$uri = vmURI::getCleanUrl();
	$uri = str_replace('&tmpl=component','',$uri);
	?>
	<div class="container">
		<div class="RegistroForm col-md-10 col-md-offset-1">
		<?php
		// Formulario de acceso donde nos pide usuario y contraseña para identificarse.
		echo shopFunctionsF::getLoginForm ($this->cart, FALSE,$uri);
		?>
		</div>
	</div>
	
	<?php
		$taskRoute = '';
	?>
	<div class="container">
		<form method="post" id="checkoutForm" name="checkoutForm" action="<?php echo JRoute::_ ('index.php?option=com_virtuemart&view=cart' . $taskRoute, $this->useXHTML, $this->useSSL); ?>">
			<?php
			if(VmConfig::get('multixcart')=='byselection'){
				// Esta opcion es si tenemos varios vendedores , multivendedor
				if (!class_exists('ShopFunctions')) require(VMPATH_ADMIN . DS . 'helpers' . DS . 'shopfunctions.php');
				echo shopFunctions::renderVendorFullVendorList($this->cart->vendorId);
				?><input type="submit" name="updatecart" title="<?php echo vmText::_('COM_VIRTUEMART_SAVE'); ?>" value="<?php echo vmText::_('COM_VIRTUEMART_SAVE'); ?>" class="button"  style="margin-left: 10px;"/><?php
				// Fin de opción de multivenderdor
			}
			?>
			<?php
			
			// Mostramos la lista de productos del carrito,se debe hacer con las tablas ya que se utiliza en los correo electrónico
			?>
			<div class="col-md-7">
				<!-- // Default carga pricelist // Entramos  template pricelist -->
				<div class="Cuentas">
				<h2 class="LetraVerde">
				Resumen del pedido
				</h2>
				<?php
				echo $this->loadTemplate ('pricelist');
				?>
				</div>
				<!-- // Vuelvo a Defautl de pricelist // Fin de mostrar template pricelist -->
			</div> 
			<div class="col-md-5">
				<!-- // Default carga address // Datos facturacion y envió  -->

				<?php
				echo $this->loadTemplate ('address');
				?>
				<!-- // Desde default cargamos default_envio -->
				<?php
				echo $this->loadTemplate ('envio');
				?>
				<!-- // Volvemos a default desde default_envio -->

				<!-- Cargo default_forma_pago -->
				<?php
				echo $this->loadTemplate ('forma_pago');
				?>
				<!-- Fin default_forma_pago ,volví default -->
				<?php
				if (!empty($this->checkoutAdvertise)) {
					?>
					<!-- Mostrar advertencias -->
					<div id="checkout-advertise-box"> 
					<?php
					foreach ($this->checkoutAdvertise as $checkoutAdvertise) {
						?>
						<div class="checkout-advertise">
							<?php echo $checkoutAdvertise; ?>
						</div>
					<?php
					}
					?>
					</div><!-- Fin mostrar advertencias -->
					<?php
				}
				?>
				<!-- Mostramos comentarios -->
				<?php
				echo $this->loadTemplate ('comentarios');
				?>
				<!-- Fin comentarios servicios-->

				<div class="col-md-12">
					<?php
						echo $this->loadTemplate ('fieldspie');
					?>
					 <div class="checkout-button-top"> 
						<?php
						echo $this->checkout_link_html;
						?>
					</div>
				</div>
			</div>
			
			
			<?php // Continue and Checkout Button END ?>
			<input type='hidden' name='order_language' value='<?php echo $this->order_language; ?>'/>
			<input type='hidden' name='task' value='updatecart'/>
			<input type='hidden' name='option' value='com_virtuemart'/>
			<input type='hidden' name='view' value='cart'/>
		</form>
	</div>

<?php

if(VmConfig::get('oncheckout_ajax',false)){
	vmJsApi::addJScript('updDynamicListeners',"
if (typeof Virtuemart.containerSelector === 'undefined') Virtuemart.containerSelector = '#cart-view';
if (typeof Virtuemart.container === 'undefined') Virtuemart.container = jQuery(Virtuemart.containerSelector);

jQuery(document).ready(function() {
	if (Virtuemart.container)
		Virtuemart.updDynFormListeners();
}); ");
}


vmJsApi::addJScript('vm.checkoutFormSubmit',"
Virtuemart.bCheckoutButton = function(e) {
	e.preventDefault();
	jQuery(this).vm2front('startVmLoading');
	jQuery(this).attr('disabled', 'true');
	jQuery(this).removeClass( 'vm-button-correct' );
	jQuery(this).addClass( 'vm-button' );
	jQuery(this).fadeIn( 400 );
	var name = jQuery(this).attr('name');
	var div = '<input name=\"'+name+'\" value=\"1\" type=\"hidden\">';

	jQuery('#checkoutForm').append(div);
	//Virtuemart.updForm();
	jQuery('#checkoutForm').submit();
}
jQuery(document).ready(function($) {
	jQuery(this).vm2front('stopVmLoading');
	var el = jQuery('#checkoutFormSubmit');
	el.unbind('click dblclick');
	el.on('click dblclick',Virtuemart.bCheckoutButton);
});
	");

if( !VmConfig::get('oncheckout_ajax',false)) {
	vmJsApi::addJScript('vm.STisBT',"
		jQuery(document).ready(function($) {

			if ( $('#STsameAsBTjs').is(':checked') ) {
				$('#output-shipto-display').hide();
			} else {
				$('#output-shipto-display').show();
			}
			$('#STsameAsBTjs').click(function(event) {
				if($(this).is(':checked')){
					$('#STsameAsBT').val('1') ;
					$('#output-shipto-display').hide();
				} else {
					$('#STsameAsBT').val('0') ;
					$('#output-shipto-display').show();
				}
				var form = jQuery('#checkoutFormSubmit');
				form.submit();
			});
		});
	");
}

$this->addCheckRequiredJs();
echo vmJsApi::writeJS();

?>
</div>
