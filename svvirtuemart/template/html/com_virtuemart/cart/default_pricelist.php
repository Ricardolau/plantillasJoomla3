<?php 
/*  Mostramos los productos que hay en carro
 * a demas mostramos:
 *   - Formas de envió
 *   - Formas de pago.
 * 
 * */

?>

<fieldset class="vm-fieldset-pricelist">
<div class="col-md-12">
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Descripcion</th>
				<th>Precio</th>
				<th>Cantidad</th>
				<th>Total</th>
			</tr>
		</thead>

	<!-- Inicio de listado productos carro -->
		<?php
		$i = 1;
		foreach ($this->cart->products as $pkey => $prow) {
			$prow->prices = array_merge($prow->prices,$this->cart->cartPrices[$pkey]);
			/* // Print_r precios.
			 	echo '<pre>';
				print_r($prow->prices);
				echo '</pre>';
			* <?php */ 
			?>
			<tr valign="top" class="sectiontableentry<?php echo $i ?>">
			<input type="hidden" name="cartpos[]" value="<?php echo $pkey ?>">
				<td class="vm-cart-item-name" >
					<?php if ($prow->virtuemart_media_id) { ?>
					<span class="cart-images">
									 <?php
						if (!empty($prow->images[0])) {
							echo $prow->images[0]->displayMediaThumb ('', FALSE);
						}
						?>
					</span>
					<?php } ?>
					<?php
						
						echo JHtml::link ($prow->url, $prow->product_name);
						foreach($prow->customProductData as $clave=>$field) {
							// Lo seleccionado [virtuemart_custom_id]=>$clave y [virtuemart_customfield_id]=>$field
							// Ahora buscamos en campos:
							foreach($prow->customfields as $custom){
								if ($custom->virtuemart_custom_id == $clave && $custom->virtuemart_customfield_id == $field){
								echo '<br/><small><strong>'.$custom->custom_title.':</strong>'.$custom->customfield_value.'</small>';
								}
							}
						}
						
						echo $this->customfieldsModel->CustomsFieldCartDisplay ($prow->customProductData);
						echo '<small>ID:'.$prow->virtuemart_product_id.'</small><br/>';
						
						
					 ?>

				</td>
<!--
				<td class="vm-cart-item-basicprice" >
-->
				<td>

					<!-- Precio con iva -->
					<?php
					echo $this->currencyDisplay->createPriceDiv ('basePriceWithTax', '', $prow->prices, FALSE, FALSE, 1.0, false, true);
					//~ echo $this->currencyDisplay->createPriceDiv ('basePriceWithTax', '', $prow->prices, FALSE);

					?>
					<small>
					<?php
					if (VmConfig::get ('checkout_show_origprice', 1) && $prow->prices['discountedPriceWithoutTax'] != $prow->prices['priceWithoutTax']) {
						// Esto no se muestra, me imagino que cuando hay precio con descuento.
						echo '<span class="line-through">'. $this->currencyDisplay->createPriceDiv ('basePriceVariant', '', $prow->prices, TRUE, FALSE) . '</span><br />';
					}

					if ($prow->prices['discountedPriceWithoutTax']) {
						// Precio sin iva.
						//~ echo $this->currencyDisplay->createPriceDiv ('discountedPriceWithoutTax', '', $prow->prices, FALSE, FALSE, 1.0, false, true);
					//~ } else {
						//~ // Esto no se muestra, me imagino que cuando hay precio con descuento.
						//~ echo $this->currencyDisplay->createPriceDiv ('basePriceVariant', '', $prow->prices, FALSE, FALSE, 1.0, false, true);
					}
					?>
					</small>
				</td>
<!--
				<td class="vm-cart-item-quantity" >
-->
				<td>

					<?php

						if ($prow->step_order_level)
							$step=$prow->step_order_level;
						else
							$step=1;
						if($step==0)
							$step=1;
						?>
						<input type="text"
						   onblur="Virtuemart.checkQuantity(this,<?php echo $step?>,'<?php echo vmText::_ ('COM_VIRTUEMART_WRONG_AMOUNT_ADDED',true)?>');"
						   onclick="Virtuemart.checkQuantity(this,<?php echo $step?>,'<?php echo vmText::_ ('COM_VIRTUEMART_WRONG_AMOUNT_ADDED',true)?>');"
						   onchange="Virtuemart.checkQuantity(this,<?php echo $step?>,'<?php echo vmText::_ ('COM_VIRTUEMART_WRONG_AMOUNT_ADDED',true)?>');"
						   onsubmit="Virtuemart.checkQuantity(this,<?php echo $step?>,'<?php echo vmText::_ ('COM_VIRTUEMART_WRONG_AMOUNT_ADDED',true)?>');"
						   title="<?php echo  vmText::_('COM_VIRTUEMART_CART_UPDATE') ?>" class="quantity-input js-recalculate" size="3" maxlength="4" name="quantity[<?php echo $pkey; ?>]" value="<?php echo $prow->quantity ?>" />
				</td>

				<?php 
				/*
				<td class="vm-cart-item-discount" ><?php echo "<span class='priceColor2'>" . $this->currencyDisplay->createPriceDiv ('discountAmount', '', $prow->prices, FALSE, FALSE, $prow->quantity, false, true) . "</span>" ?></td>
				* */
				?>
<!--
				<td class="vm-cart-item-total">
-->
				<td>

					<?php //vmdebug('hm',$prow->prices,$this->cart->cartPrices[$pkey]);
					if (VmConfig::get ('checkout_show_origprice', 1) && !empty($prow->prices['basePriceWithTax']) && $prow->prices['basePriceWithTax'] != $prow->prices['salesPrice']) {
						echo '<span class="line-through">' . $this->currencyDisplay->createPriceDiv ('basePriceWithTax', '', $prow->prices, TRUE, FALSE, $prow->quantity) . '</span><br />';
					}
					elseif (VmConfig::get ('checkout_show_origprice', 1) && empty($prow->prices['basePriceWithTax']) && !empty($prow->prices['basePriceVariant']) && $prow->prices['basePriceVariant'] != $prow->prices['salesPrice']) {
						echo '<span class="line-through">' . $this->currencyDisplay->createPriceDiv ('basePriceVariant', '', $prow->prices, TRUE, FALSE, $prow->quantity) . '</span><br />';
					}
					echo $this->currencyDisplay->createPriceDiv ('salesPrice', '', $prow->prices, FALSE, FALSE, $prow->quantity) ?>
				</td>
				<td>
					<button type="submit" class="glyphicon glyphicon-refresh" name="updatecart.<?php echo $pkey ?>" title="<?php echo  vmText::_ ('COM_VIRTUEMART_CART_UPDATE') ?>" ></button>
					<button type="submit" class="glyphicon glyphicon-trash" name="delete.<?php echo $pkey ?>" title="<?php echo vmText::_ ('COM_VIRTUEMART_CART_DELETE') ?>" ></button>
				</td>
			</tr>
			<?php
			$i = ($i==1) ? 2 : 1;
		} ?>
	<!-- Fin de listado productos carro -->
	<!--Begin of SubTotal, Tax, Shipment, Coupon Discount and Total listing -->
	</table>


	<!-- // Desde default_envio cargamos default_contenedor_coupon -->
	
	<?php
	echo $this->loadTemplate ('contenedor_coupon');
	?>
	<?php
	echo $this->loadTemplate ('total');
	?>
	<!-- // Volvemos a default_pricelist desde default_total -->
</div>	


</fieldset>

