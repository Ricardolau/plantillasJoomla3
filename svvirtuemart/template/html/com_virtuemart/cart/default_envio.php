<?php 
/*  Mostramos las formas envió y la operativa forma envio.
 * */

?>

<!-- Ahora mostrar vista nueva formas de envios.. -->
<div class="FormasEnvios">
	<h2 class="LetraVerde">
	<?php echo vmText::_ ('COM_VIRTUEMART_CART_SELECTED_SHIPMENT');?>	
	</h2>
	<p>El tiempo de tránsito refleja los días que transcurren desde que tu pedido sale de nuestras instalaciones. Siempre intentaremos enviar tu pedido en 24 horas laborables para que lo recibas lo antes posible. En temporada alta como campaña de colegio o Navidad, pueden tardar en prepararse hasta 4 días laborables.</p>
	
	<?php  // Comprobamos si selecciono o tiene seleccionada una forma envió
	if (empty($this->cart->virtuemart_shipmentmethod_id)){
		$formaEnvio = "vacio";
	} else {
		$formaEnvio = "contiene datos";
	}
	?>
	
	

	<?php 
	if ($this->cart->cartData['DATaxRulesBill']) { 
	// Solo entra ( creo ) si hay alguna forma envio que este en configuracion en ""Activar selección automática de envío".
	?>
	<table class="EnvioSeleccionado">
	<?php 
	foreach ($this->cart->cartData['DATaxRulesBill'] as $rule) { ?>
		<!-- Mostramos la forma de envió que tenemos seleccionado. -->
		<tr class="sectiontableentry<?php echo $i ?>">
			<td colspan="4" align="right">
				<?php echo   $rule['calc_name'] ?> 
			</td>
			<?php if (VmConfig::get ('show_tax')) { ?>
				<td align="right"></td>
			<?php } ?>
			<td align="right">
				<?php echo $this->currencyDisplay->createPriceDiv ($rule['virtuemart_calc_id'] . 'Diff', '', $this->cart->cartPrices[$rule['virtuemart_calc_id'] . 'Diff'], FALSE); ?>  
			</td>
			<td align="right">
				<?php echo $this->currencyDisplay->createPriceDiv ($rule['virtuemart_calc_id'] . 'Diff', '', $this->cart->cartPrices[$rule['virtuemart_calc_id'] . 'Diff'], FALSE); ?>
			 </td>
		</tr>
			<?php
			if ($i) {
				$i = 1;
			} else {
				$i = 0;
			}
	}
	?>
	</table>
	<?php
	}
	?>
	<?php // Control para saber si tiene forma envio seleccionado
	if ($formaEnvio != "vacio"){
	// Una alerta que hay una forma envió seleccionada con su precio	
	?>
	
	<div class="alert alert-success col-md-12" style="display:table;">
		<h3> Forma de envío seleccionado </h3>
		<p class="col-md-8">
		<?php
				echo $this->cart->cartData['shipmentName'].'<br/>';
		?>
		</p>
		<p class="col-md-4">
			<strong>
			<?php if($this->cart->cartPrices['salesPriceShipment'] == 0){ 
					echo "Gratis";
				} else {
					if($this->cart->cartPrices['salesPriceShipment'] > 0){
						echo $this->currencyDisplay->createPriceDiv ('salesPriceShipment', '', $this->cart->cartPrices['salesPriceShipment'], FALSE);
					}
				}
			?>
			</strong>
		</p>
	</div>
	<?php	
	// Fin condicional si tiene forma envió seleccionado.
	}
	?>
	<?php
if (VmConfig::get('oncheckout_opc',true) or
	!VmConfig::get('oncheckout_show_steps',false) or
	(!VmConfig::get('oncheckout_opc',true) and VmConfig::get('oncheckout_show_steps',false) and
		!empty($this->cart->virtuemart_shipmentmethod_id) )
) { ?>
	<?php
		 
		if (!$this->cart->automaticSelectedShipment) { 
			if (!empty($this->layoutName) and $this->layoutName == 'default') {
				if (VmConfig::get('oncheckout_opc', 0)) {
				$previouslayout = $this->setLayout('select');
				// Cargamos plantilla de mostrar las posibles formas envios.
				echo $this->loadTemplate('shipment');
				$this->setLayout($previouslayout);
				} else {
				echo JHtml::_('link', JRoute::_('index.php?option=com_virtuemart&view=cart&task=edit_shipment', $this->useXHTML, $this->useSSL), $this->select_shipment_text, 'class=""');
				}
			} else {
			// Este texto es Envio, no se cuando lo muestra.
			echo vmText::_ ('COM_VIRTUEMART_CART_SHIPPING');
			}
		} else {
				// Creo que entrá cuando no hay una forma envio sin seleccionar
				echo '<h4>'.vmText::_ ('COM_VIRTUEMART_CART_SELECTED_SHIPMENT').'</h4>';
				echo $this->cart->cartData['shipmentName'];
				echo '<span class="floatright">Value' . $this->currencyDisplay->createPriceDiv ('shipmentValue', '', $this->cart->cartPrices['shipmentValue'], FALSE) . '</span>';
				// Sino existe una forma envío, no selecciono una forma envio y le dio a compra.
				// Esto ultimo, siempre y cuando en configuración estuviera
				// mardaco la opción de todo en la misma pagina.
				
				echo '<small><b>Control 1 de default_envio:</b> <br/> 
				Indique al administrador de la web que le apareció este mensaje				
				</small>';
		} ?>
	<?php
	} 
	?>

</div>
