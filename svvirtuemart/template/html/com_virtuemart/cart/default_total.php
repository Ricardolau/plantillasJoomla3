<?php 
/*  Mostramos los productos que hay en carro
 * a demas mostramos:
 *   - Formas de envió
 *   - Formas de pago.
 * 
 * */

?>
<!-- Vista de cart de total -->
<?php
/* Mostramos importes desglosado */
if ( $this->cart->cartPrices['paymentValue']){
	?>
	<div class="col-md-8 text-right">
	<?php 
	echo ' Importe por forma pago:';
	?>
	</div>
	<div class="col-md-4 text-right">
	<?php
	echo $this->currencyDisplay->createPriceDiv('paymentValue', '',$this->cart->cartPrices['paymentValue'], FALSE);
	?>
	</div>
	<?php
} 
?>
<div class="col-md-8 text-right">
	<?php 
	echo ' Metodo envio'
	?>
</div>
<div class="col-md-4 text-right">
	<?php
	if ( $this->cart->cartPrices['salesPriceShipment']){
		echo $this->currencyDisplay->createPriceDiv('salesPriceShipment', '',$this->cart->cartPrices['salesPriceShipment'], FALSE);
	} else {
		echo '<strong>Gratis</strong>';
	}	
	?>
</div>
<div class="col-md-8 text-right">
	<?php
	echo 'Subtotal';
	?>
</div>
	<div class="col-md-4 text-right">
	<?php
	echo $this->currencyDisplay->createPriceDiv('billSub', '',$this->cart->cartPrices['billSub'], FALSE);
	?>
</div>
<?php 
if (VmConfig::get ('show_tax')) 
{ 
	?>
	<div class="col-md-8 text-right">
		<?php 
		echo ' Impuestos: ';
		?>
	</div>
	<div class="col-md-4 text-right">
		<?php echo $this->currencyDisplay->createPriceDiv ('billTaxAmount', '', $this->cart->cartPrices['billTaxAmount'], FALSE);
		?>
	</div> 
	<?php
} ?>
<div class="col-md-12 billto-shipto" >
	<div class="col-md-8 text-right" >
		<strong style="font-size:1.5em;">
		<?php 
		echo vmText::_ ('COM_VIRTUEMART_CART_TOTAL')
		?>
		</strong>
	</div>
	<div class="col-md-4 text-right LetraVerde" style="padding-right:0px;">
		<?php 
		// Creo que es el valor si tiene descuentos
		if ($this->cart->cartPrices['billDiscountAmount']) {
			echo "<span  class='priceColor2'>" . $this->currencyDisplay->createPriceDiv ('billDiscountAmount', '', $this->cart->cartPrices['billDiscountAmount'], FALSE) . "</span>" ;
		}
		?> 
		<strong><?php echo $this->currencyDisplay->createPriceDiv ('billTotal', '', $this->cart->cartPrices['billTotal'], FALSE); ?></strong>
	</div>
</div>
<?php
/*
echo '<pre>';
print_r($this->cart);
echo '</pre>';
*/




if ($this->totalInPaymentCurrency) {
	/* Pienso que esto cuando se permite pagar en otras monedas
?>
<!-- Inicio table de totalInPaymentCurrency --> 
<table>
<tr class="sectiontableentry2">
	<td colspan="4" align="right"><?php echo vmText::_ ('COM_VIRTUEMART_CART_TOTAL_PAYMENT') ?>:</td>

	<?php if (VmConfig::get ('show_tax')) { ?>
	<td align="right"></td>
	<?php } ?>
	<td align="right"></td>
	<td align="right"><strong><?php echo $this->totalInPaymentCurrency;   ?></strong></td>
</tr>
</table>
 
<!-- Fin  table de totalInPaymentCurrency --> 
<?php 
 * */
 ?> 
	<?php
}

//Muestra separado los ivas.... 
if(!empty($this->cart->cartData)){
	if(!empty($this->cart->cartData['VatTax'])){
		?>
		<!-- Inicio table  Show VAT tax seperated -->
		<table>
		<?php
		$c = count($this->cart->cartData['VatTax']);
		if (!VmConfig::get ('show_tax') or $c>1) {
			if($c>0){
				?><tr class="sectiontableentry2">
				<td colspan="5" align="right"><?php echo vmText::_ ('COM_VIRTUEMART_TOTAL_INCL_TAX') ?></td>

				<?php if (VmConfig::get ('show_tax')) { ?>
					<td ></td>
				<?php } ?>
				<td></td>
				</tr><?php
			}
			foreach( $this->cart->cartData['VatTax'] as $vatTax ) {
				if(!empty($vatTax['result'])) {
					echo '<tr class="sectiontableentry'.$i.'">';
					echo '<td colspan="4" align="right">'.shopFunctionsF::getTaxNameWithValue($vatTax['calc_name'],$vatTax['calc_value']). '</td>';
					echo '<td align="right"><span class="priceColor2">'.$this->currencyDisplay->createPriceDiv( 'taxAmount', '', $vatTax['result'], FALSE, false, 1.0,false,true ).'</span></td>';
					echo '<td></td><td></td>';
					echo '</tr>';
				}
			}
		}
	?>
	</table>
	<!-- Fin Mostras ivas semaprados...  -->
	<?php
	}
}
?>




