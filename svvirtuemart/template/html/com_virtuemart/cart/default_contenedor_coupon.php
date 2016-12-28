<?php 
/*  Mostramos cupon que hay en carro
 * 
 * */

?>

<div class="col-md-12 Cupones">

<table class= "table table-striped">
<?php
if (VmConfig::get ('coupons_enable')) {
	?>
	<?php if (VmConfig::get ('show_tax')) {
		$colspan = 3;
	} else {
		$colspan = 2;
	} ?>
<tr class="sectiontableentry2">
	<td class="col-md-5">
		<?php // Si ya introducciomos un cupon
		if (!empty($this->cart->cartData['couponCode'])) { ?>
			<h4 class="Rojo">Ya introduciste el Cupon</h4>
			<div class="text-center">
			<?php
			echo $this->cart->cartData['couponCode'];
			echo $this->cart->cartData['couponDescr'] ? (' (' . $this->cart->cartData['couponDescr'] . ')') : '';
			?>
			</div>
		<?php
		} else {
		?>
			<h4 class="Rojo">¿Si tienes código descuento?</h4>
			<div class="text-center">Ahora es el momento de usuarlo</div>
		<?php
		}
		?>
	</td>
	<td class="col-md-5" align="left">
		<?php if (!empty($this->layoutName) && $this->layoutName == 'default') {
			echo $this->loadTemplate ('coupon');
		} ?>

	</td>
	
	<td class="col-md-2" align="rigth">
		<?php echo $this->currencyDisplay->createPriceDiv ('salesPriceCoupon', '', $this->cart->cartPrices['salesPriceCoupon'], FALSE); ?> 
		</td>
	</tr>
<?php } ?>
</table>
<?php if (VmConfig::get ('show_tax')) { ?>
	
		<?php // No se realmente que muestra. 
		echo '<!-- No se que muestra -->'.$this->currencyDisplay->createPriceDiv ('couponTax', '', $this->cart->cartPrices['couponTax'], FALSE); ?> 
	
	<?php } ?>
</div>



