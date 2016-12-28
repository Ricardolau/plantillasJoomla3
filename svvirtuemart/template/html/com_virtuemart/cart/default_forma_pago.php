<?php 
/*  Mostramos las formas pago y la operativa forma envio.
 * */

?>
<div class="FormasPago">
	<h2 class="LetraVerde">
	<?php echo vmText::_ ('COM_VIRTUEMART_CART_SELECTED_PAYMENT');?>
	</h2>
	<?php
	// Indica el metod pago seleccionado o indica que no hay ninguna forma pago seleccionada.
	// por lo que debemos controlar cuando es uno u otro para poder mostrarlo como una alert o informacion.
	if ( $this->cart->cartData['paymentName'] == vmText::_ ('COM_VIRTUEMART_CART_NO_PAYMENT_SELECTED') ){
		?>
		<div class="alert alert-warning" style="display:table;">
		<?php
			echo vmText::_ ('COM_VIRTUEMART_CART_NO_PAYMENT_SELECTED').'<br/>';
			echo 'Cualquier duda, pongase en contacto con administracion de la web';
		?>
		</div>
		<?php
	
	} else { ?>
		<div class="alert alert-success col-md-12" style="display:table;">
		<?php if($this->cart->cartPrices['salesPricePayment'] > 0)
				{?>
				<p class="col-md-8">
					<?php echo $this->cart->cartData['paymentName'];?>
				</p>
				<p class="col-md-4">
				<?php
				 echo $this->currencyDisplay->createPriceDiv ('salesPricePayment', '', $this->cart->cartPrices['salesPricePayment'], FALSE); ?>
				</p>
				<?php
				} else {
					echo $this->cart->cartData['paymentName'];
				}
			 ?> 
		
		
		</div>
		<?php 
	}
	?>	
	
<!-- Default_forma_pago -->
<?php if ($this->cart->pricesUnformatted['salesPrice']>0.0 and
	( 	VmConfig::get('oncheckout_opc',true) or
		!VmConfig::get('oncheckout_show_steps',false) or
		( (!VmConfig::get('oncheckout_opc',true) and VmConfig::get('oncheckout_show_steps',false) ) and !empty($this->cart->virtuemart_paymentmethod_id))
	))
	{ ?>
	<?php 
		if (!$this->cart->automaticSelectedPayment) { ?>
			<?php
				if (!empty($this->layoutName) && $this->layoutName == 'default') {
					if (VmConfig::get('oncheckout_opc', 0)) {
						$previouslayout = $this->setLayout('select');
						// Cargar TEMPLATE DE FORMAS DE PAGO
						echo $this->loadTemplate('payment');
						$this->setLayout($previouslayout);
					} else {
						echo JHtml::_('link', JRoute::_('index.php?option=com_virtuemart&view=cart&task=editpayment', $this->useXHTML, $this->useSSL), $this->select_payment_text, 'class=""');
					}
				} else {
				echo vmText::_ ('COM_VIRTUEMART_CART_PAYMENT');
						} ?> 

	<?php 
		} else { ?>
			<?php echo '<h4>'.vmText::_ ('COM_VIRTUEMART_CART_SELECTED_PAYMENT').'</h4>'; ?>
			<?php echo $this->cart->cartData['paymentName'];
		} ?>
	<?php 
		if (VmConfig::get ('show_tax')) 
		{ ?>
			<?php echo "<span  class='priceColor2'>" . $this->currencyDisplay->createPriceDiv ('paymentTax', '', $this->cart->cartPrices['paymentTax'], FALSE) . "</span>"; 
		} ?>
		
<?php  
	} ?>
</div>
<!-- Fin table de forma pago -->
