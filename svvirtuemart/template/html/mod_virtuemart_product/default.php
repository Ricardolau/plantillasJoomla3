<?php // no direct access
/* Para llegar a esta vista debemos seleccionar en el modulo default */
defined ('_JEXEC') or die('Restricted access');
// add javascript for price and cart, need even for quantity buttons, so we need it almost anywhere
vmJsApi::jPrice();


$col = 1;
$pwidth = ' width' . floor (100 / $products_per_row);
if ($products_per_row > 1) {
	$float = "floatleft";
} else {
	$float = "center";
}
?>
<div class="vmgroup<?php echo $params->get ('moduleclass_sfx') ?>">

	<?php if ($headerText) { ?>
		<div class="vmheader"><?php echo 'Titulo de Modulo'.$headerText ?></div>
	<?php
	}
	/* Modulo tiene varias forma de diseño, el parametro le llama "Diseño de vista"*/
	
	if ($display_style == "div") {
		?>
		<div class="vmproduct<?php echo $params->get ('moduleclass_sfx'); ?> productdetails">
			<?php foreach ($products as $product) { ?>
			<div class="<?php echo $pwidth ?> <?php echo $float ?>">
				<div class="spacer">
						
					<?php 
					//~ echo JHTML::_ ('link', JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' . $product->virtuemart_category_id), $image, array('title' => $product->product_name));
					$url = JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' .
					$product->virtuemart_category_id); ?>

					<div class="vm-product-media-container">

						<a title="<?php echo $product->product_name ?>" href="<?php echo $product->link.$ItemidStr; ?>">

							<?php  
							/* Creamos la clase de imagen en producto centrada verticalmente. 
							 * Para poder realizar el centrado de la imagen en proporción debemos
							 * conocer el alto y ancho de la imagen.
							 * El siguiente código es para conocer alto y ancho de la imagen original */						
							$imagenProducto = $product->images[0];
							//~ echo '<pre>';
							//~ print_r($product->virtuemart_media_id);
							//~ echo '</pre>';
							
							if (!empty($product->virtuemart_media_id)) {
							/* Realizamos el calculo si tiene imagen , si no la tiene no hace falta. */
							//~ echo $product->file_url;
						
							$imagenMedidas = getimagesize($product->file_url); //Sacamos la información imagen original
							// Puede haber varios motivos por los que la instrucción anteriro no funcione
							// Y si no funciona, no crea array por lo que no va mostrar imagen , por eso el fi
								if (!empty($imagenMedidas)) {
									$ancho = $imagenMedidas[0];              //Ancho
									$alto = $imagenMedidas[1];               //Alto
									/* Ahora tenemos que saber si es panoramica o no la imagen, 
									 * medidas es más grande, ya que esa será la que tomemos 100% */
									$diferencia = $ancho-$alto;
									$margenL	= 0;
									$margenS	= 0;
									if ($diferencia > 0){
										$tipoImagen= 'Horizontal';
										$alto=($alto*100)/$ancho; // Calculamos porcentaje % ( que ocupa del contenedor)
										$ancho = 100 ; // El ancho es el 100%
										$margenS = ($ancho-$alto)/2; // Calculamos margen superior; 
									}
									if ($diferencia < 0){
										$tipoImagen= 'Vertical';
										$ancho=($ancho*100)/$alto; // Calculamos porcentaje % ( que ocupa del contenedor)
										$alto = 100 ; // El ancho es el 100% del contenedor
										$margenL = ($alto-$ancho)/2; // Calculamos margen superior; 
									}
									if ($diferencia == 0){
										$tipoImagen= 'Cuadrada';
										$ancho = 100; // Es 100% ancho contenedor.
										$alto = 100; // Es 100% alto contenedor.
									}
									
									$classimagen= 'class="browseProductImage" style="padding:'.$margenS.'% '.$margenL.'%;"';
									echo $product->images[0]->displayMediaThumb($classimagen, false);
								} else {
									// Implica que la imagen esta mal por eso metemos esta imagen.
									echo '<img src="images/headers/PD_401x401.jpg" class="browseProductImage" style="padding:0% 0%;">';
								}
							} else {
							// Mostramos esta imagen cuando no tiene imagenes el producto.
							
							echo '<img src="images/headers/PD_401x401.jpg" class="browseProductImage" style="padding:0% 0%;">';
							}
						
							?>
						</a>

					</div>

					<a href="<?php echo $url ?>">
					<?php echo $product->product_name ?>
					</a> 
					 <?php    echo '<div class="clear"></div>';

					if ($show_price) {
						// 		echo $currency->priceDisplay($product->prices['salesPrice']);
							?>
							<div class="product-price">
							<?php
							if (!empty($product->prices['salesPrice'])) {
							$PrecioFinal = number_format($product->prices['salesPrice'],2);
							echo '<div class="Precio">';
								echo $PrecioFinal.'<span >€</span>'; // Esto debería ser una constante
							echo '</div>';
							//~ echo $currency->createPriceDiv ('salesPrice', '', $product->prices, FALSE, FALSE, 1.0, TRUE);
							}
							// if ($product->prices['salesPriceWithDiscount']>0) echo $currency->priceDisplay($product->prices['salesPriceWithDiscount']);
							if (!empty($product->prices['salesPriceWithDiscount'])) {
							echo $currency->createPriceDiv ('salesPriceWithDiscount', '', $product->prices, FALSE, FALSE, 1.0, TRUE);
							}
							?>
						</div>
						<?php
						}
					if ($show_addtocart) {
						echo shopFunctionsF::renderVmSubLayout('addtocart',array('product'=>$product));
					}
					?>
				</div>
			</div>
			<?php
			if ($col == $products_per_row && $products_per_row && $col < $totalProd) {
				echo "	</div><div style='clear:both;'>";
				$col = 1;
			} else {
				$col++;
			}
		} ?>
		</div>
		<br style='clear:both;'/>

		<?php
	} else {
		$last = count ($products) - 1;
		?>

		<ul class="vmproduct<?php echo $params->get ('moduleclass_sfx'); ?> productdetails">
			<?php foreach ($products as $product) : ?>
			<li class="<?php echo $pwidth ?> <?php echo $float ?>">
				<?php
				if (!empty($product->images[0])) {
					$image = $product->images[0]->displayMediaThumb ('class="featuredProductImage" border="0"', FALSE);
				} else {
					$image = '';
				}
				echo JHTML::_ ('link', JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' . $product->virtuemart_category_id), $image, array('title' => $product->product_name));
				echo '<div class="clear"></div>';
				$url = JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' .
					$product->virtuemart_category_id); ?>
				<a href="<?php echo $url ?>"><?php echo $product->product_name ?></a>        <?php    echo '<div class="clear"></div>';
				// $product->prices is not set when show_prices in config is unchecked
				if ($show_price and  isset($product->prices)) {
					echo '<div class="product-price">'.$currency->createPriceDiv ('salesPrice', '', $product->prices, FALSE, FALSE, 1.0, TRUE);
					if ($product->prices['salesPriceWithDiscount'] > 0) {
						echo $currency->createPriceDiv ('salesPriceWithDiscount', '', $product->prices, FALSE, FALSE, 1.0, TRUE);
					}
					echo '</div>';
				}
				if ($show_addtocart) {
					echo shopFunctionsF::renderVmSubLayout('addtocart',array('product'=>$product));
				}
				?>
			</li>
			<?php
			if ($col == $products_per_row && $products_per_row && $last) {
				echo '
		</ul><div class="clear"></div>
		<ul  class="vmproduct' . $params->get ('moduleclass_sfx') . ' productdetails">';
				$col = 1;
			} else {
				$col++;
			}
			$last--;
		endforeach; ?>
		</ul>
		<div class="clear"></div>

		<?php
	}
	if ($footerText) : ?>
		<div class="vmfooter<?php echo $params->get ('moduleclass_sfx') ?>">
			<?php echo $footerText ?>
		</div>
		<?php endif; ?>
</div>
