<?php // no direct access
/* Para llegar a esta vista debemos seleccionar en el modulo default */
defined ('_JEXEC') or die('Restricted access');
// add javascript for price and cart, need even for quantity buttons, so we need it almost anywhere
vmJsApi::jPrice();


$row = 1;
$nColMd=  floor (12 / $products_per_row); // Calculamos el número columnas para bootstrap
$NProducto=0;
$Ncol =0;
		echo '<!-- Modulo producto view Grande -->';

?>

<div class="vmgroup<?php echo $params->get ('moduleclass_sfx') ?> col-md-12">

	<?php
		/* El modulo creo que tiene un error al crear los parametros, ya que no mete el titulo del modulo*
		 * Ya que creo que poner header_text para eso pero no lo carga.*/
		//~ echo ' <pre>';
		//~ print_r($module);
		//~ echo '</pre>';
	?>
	<div class="page-header corona">
		<div class="CategoriaVirtuemart">
			<h1><?php echo $module->title ?></h1>
		</div>
	</div>
	<?php
			foreach ($products as $product) {
			$NProducto	= $NProducto + 1;
			$Ncol		= $Ncol + 1;	
			 if ($Ncol == 1){
			 ?>
			<div class="col-md-12 vmproduct<?php echo $params->get ('moduleclass_sfx'); ?> productdetails">
			<?php
			}
			?>
				<div class="producto  <?php echo 'col-md-'.$nColMd .' product-'.$NProducto;?>">
					<div class="contenido-product">
						
					<?php 
					//~ echo JHTML::_ ('link', JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' . $product->virtuemart_category_id), $image, array('title' => $product->product_name));
					$url = JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' .
					$product->virtuemart_category_id); ?>

						<div class="vm-product-media-container">

						<a title="<?php echo $product->product_name ?>" href="<?php echo $product->link.$ItemidStr; ?>">

						<?php  
						/* Ahora tenemos que calcular si la imagen Creamos la clase de imagen en producto centrada verticalmente. 
						 * Para poder realizar el centrado de la imagen en proporción debemos
						 * conocer el alto y ancho de la imagen.
						 * El siguiente código es para conocer alto y ancho de la imagen original */						
						$Media100 = 0;
						$imagenProducto = $product->images[0];
						if (!empty($product->virtuemart_media_id)) {
							/* Realizamos el calculo si tiene imagen , si no la tiene no hace falta. */
							// Ahora obtenemos datos la direccion de la url de la imagen en miniatura.
							// La url que encontramos en $product->file_url es de la imagen grande.
							// La url de la imagen en miniatura la saco de:
							
							$Imagenthum = $product->images[0];
							$LinkImagenthum=JPATH_CONFIGURATION.'/';// Ruta del servidor
							$LinkImagenthum= $LinkImagenthum.$Imagenthum->file_url_folder_thumb;
							// Esto puede ser un problema si cambiamos las medidas en configuracion virtuemart.
							$sufijo = '_401x401';
							$LinkImagenthum = $LinkImagenthum.$Imagenthum->file_name.$sufijo.'.'.$Imagenthum->file_extension;
							//~ print_r($LinkImagenthum);
							if (file_exists($LinkImagenthum)) {
							// Mostramos imagen centrada verticalmente.
							$imagenMedidas = getimagesize($LinkImagenthum);    //Sacamos la información
							$ancho = $imagenMedidas[0];     //Ancho  
							$alto = $imagenMedidas[1];      //Alto 
							$classimagen= 'class="ProductImage Medida'.$ancho.'x'.$alto.'"';

								if ($ancho > $alto){
								// Es mas alta que ancha lo que debemos reducir el alto en proporcion.
									$Media100 = (100-(($alto*100)/$ancho))/2;
									$classimagen .=	'style="padding:'.$Media100.'% 0;"';
								}
								if ($ancho < $alto){
									$Media100 = (100-(($ancho*100)/$alto))/2;
									$classimagen .=	'style="padding:0 '.$Media100.'%;"';
	
								}
							echo $product->images[0]->displayMediaThumb($classimagen, false);
							} else {
								// Implica que la imagen esta mal por eso metemos esta imagen.
								echo '<img src="images/headers/PD_401x401.jpg" '.$classimagen.' style="padding:0% 0%;">';
							}
						} else {
						// Mostramos esta imagen cuando no tiene imagenes el producto.
						
						echo '<img src="images/headers/PD_401x401.jpg"'.$classimagen.' style="padding:0% 0%;">';
						}
						
						?>
					</a>

						</div>
						<div class="vm-product-name producto-">
						<a href="<?php echo $url ?>">
						<?php echo $product->product_name ?>
						</a> 
						</div>
						<?php 
						if ($show_price) {
						// 		echo $currency->priceDisplay($product->prices['salesPrice']);
							?>
							<div class="product-price">
							<?php
							if (!empty($product->prices['salesPrice'])) {
							$PrecioFinal = number_format($product->prices['salesPrice'],2,',', ' ');
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
			if ($Ncol == $products_per_row){ 
				echo "	</div>"; // Cerramos div row
				$Ncol = 0;
			}
		} // Cierre de foreach?>
		
	<?php
	if ($footerText) : ?>
		<div class="vmfooter<?php echo $params->get ('moduleclass_sfx') ?>">
			<?php echo $footerText ?>
		</div>
		<?php endif; ?>
</div>
