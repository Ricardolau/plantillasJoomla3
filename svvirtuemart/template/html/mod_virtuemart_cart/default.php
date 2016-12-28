<?php // no direct access
defined('_JEXEC') or die('Restricted access');

//dump ($cart,'mod cart');
// Ajax is displayed in vm_cart_products
// ALL THE DISPLAY IS Done by Ajax using "hiddencontainer" ?>

<!--  Overwrite de plantilla de Virtuemart 2 Ajax Card -->
<?php 
			/* Realizamos link a carro con comporativa si tiene datos.
			 * la ruta es : index.php?option=com_virtuemart&view=cart*/
		$onclick =' ';
		if ($data->totalProduct > 0 ){
		 $onclick='onclick="location.href='."'".'index.php?option=com_virtuemart&view=cart'."';".'" style="cursor:pointer;"';
		}
	?>
<div id="vmCartModule<?php echo $params->get('moduleid_sfx'); ?>" class="col-md-12 text-right"  <?php echo $onclick;?>>
	
	<?php 	
		//~ echo '<pre>';
		//~ print_r($cart);
		//~ echo '</pre>';
	
			/* Tiene una funcion javascript en el modulo, que se ejecuta al añadir algo al carro
			 * que es sustituye los datos.
			 * por ello si queremos realizar cambios tenemos que tener en cuenta update_cart.js
			 * */?>
	<div class= "cesta" style="display:inline;">
	<img src="" title="Mostrar Carro" alt="Carro">
	</div>
	<div class="total" style="display:inline;margin-top:8px;">
		<?php // la linea comentada es la cantidad de productos.
		if ($data->totalProduct > 0 ){		
		?>
		<span class="importe"><?php 
		echo number_format($cart->cartPrices['billTotal'],2, ',', '');
		?></span>
		<?php
		} 
		?>
	</div>
	
	<div style="clear:both;"></div>
	<noscript>
	<?php
	 echo vmText::_('MOD_VIRTUEMART_CART_AJAX_CART_PLZ_JAVASCRIPT') ?>
	</noscript>
</div>

