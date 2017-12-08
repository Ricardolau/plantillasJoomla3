<?php
/**
 * sublayout products
 *
 * @package	VirtueMart
 * @author Max Milbers
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2014 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL2, see LICENSE.php
 * @version $Id: cart.php 7682 2014-02-26 17:07:20Z Milbo $
 */

defined('_JEXEC') or die('Restricted access');
// Obtenemos la configuracion de archivos multimedia del producto.
$ConfImagen = $viewData['ConfImagen'];
if ($ConfImagen['width'] === ''){
	// Si el valor width en configuracion es vacio, ponemos 0
	$ConfImagen['width'] = 0;
}
$products_per_row = $viewData['products_per_row'];
$currency = $viewData['currency'];
$showRating = $viewData['showRating'];
$verticalseparator = " vertical-separator";
echo shopFunctionsF::renderVmSubLayout('askrecomjs');

$ItemidStr = '';
$Itemid = shopFunctionsF::getLastVisitedItemId();
if(!empty($Itemid)){
	$ItemidStr = '&Itemid='.$Itemid;
}

foreach ($viewData['products'] as $type => $products ) {

	$rowsHeight = shopFunctionsF::calculateProductRowsHeights($products,$currency,$products_per_row);
	
	if(!empty($type) and count($products)>0){
		$productTitle = vmText::_('COM_VIRTUEMART_'.strtoupper($type).'_PRODUCT'); ?>
<div class="<?php echo $type ?>-view">
  <h4><?php echo $productTitle ?></h4>
		<?php // Start the Output
    }

	// Calculating Products Per Row
	$cellwidth = ' width'.floor ( 100 / $products_per_row );

	$BrowseTotalProducts = count($products);

	$col = 1;
	$nb = 1;
	$row = 1;

	foreach ( $products as $product ) {

		// Show the horizontal seperator
		if ($col == 1 && $nb > $products_per_row) { ?>
	<div class="separador"></div>
		<?php }

		// this is an indicator wether a row needs to be opened or not
		if ($col == 1) { ?>
	<div>
	  <div class="col-md-12">
		<?php }

		// Show the vertical seperator
		if ($nb == $products_per_row or $nb % $products_per_row == 0) {
			$show_vertical_separator = ' ';
		} else {
			$show_vertical_separator = $verticalseparator;
		}

    // Show Products 
    /* Como utilizamos sistema grid de BootStrat calculamos el clase diviendo
     * el numero de columnas por 12 */
     $columnas = 12 / $products_per_row ;
    //~ echo '<pre>';
    //~ $imagenes23= $product->images[0];
    //~ echo $imagenes23->file_url_folder_thumb.$imagenes23->file_name. $imagenes23->file_extension ;
    //~ $Imagenthum = $product->images[0];
	//~ $UrlImagenthum= $Imagenthum->file_url_folder_thumb.$Imagenthum->file_name.'.'.$Imagenthum->file_extension;
	//~ echo JPATH_CONFIGURATION.'/';
	//~ echo $UrlImagenthum;
    //~ print_r($Imagenthum);
    //~ echo '</pre>';
    
    //~ echo '<pre>';
    //~ print_r( $ConfImagen);
    //~ echo '</pre>';
    
    ?>
    
	<div class="producto <?php echo ' col-md-' . $columnas ?>">
		<div class="contenido-product">
			<div class="vm-product-media-container">
					
					<a title="<?php echo $product->product_name ?>" href="<?php echo $product->link.$ItemidStr; ?>">

						<?php  
						/* Ahora tenemos que calcular si la imagen Creamos la clase de imagen en producto centrada verticalmente. 
						 * Para poder realizar el centrado de la imagen en proporción debemos
						 * conocer el alto y ancho de la imagen.
						 * El siguiente código es para conocer alto y ancho de la imagen original */						
						$Media100 = 0;
						$imagenProducto = $product->images[0];
						$classimagen= 'class="browseProductImage ';

						if (!empty($product->virtuemart_media_id)) {
							/* Realizamos el calculo si tiene imagen , si no la tiene no hace falta. */
							// Ahora obtenemos datos la direccion de la url de la imagen en miniatura.
							// La url que encontramos en $product->file_url es de la imagen grande.
							// La url de la imagen en miniatura la saco de:
							
							$Imagenthum = $product->images[0];
							$LinkImagenthum=JPATH_CONFIGURATION.'/';// Ruta del servidor
							$LinkImagenthum= $LinkImagenthum.$Imagenthum->file_url_folder_thumb;
							// Obtenemos la configuracion que tenemos para montar el sufijo.
							$sufijo = '_'.$ConfImagen['width'].'x'.$ConfImagen['height'];
							$LinkImagenthum = $LinkImagenthum.$Imagenthum->file_name.$sufijo.'.'.$Imagenthum->file_extension;
							//~ print_r($LinkImagenthum);
							if (file_exists($LinkImagenthum)) {
							// Mostramos imagen centrada verticalmente.
							$imagenMedidas = getimagesize($LinkImagenthum);    //Sacamos la información
							$ancho = $imagenMedidas[0];     //Ancho  
							$alto = $imagenMedidas[1];      //Alto 
							$classimagen .= ' Medida'.$ancho.'x'.$alto.'"';

								//~ if ($ancho > $alto){
								//~ // Es mas alta que ancha lo que debemos reducir el alto en proporcion.
									//~ $Media100 = (100-(($alto*100)/$ancho))/2;
									//~ $classimagen .=	'style="padding:'.$Media100.'% 0;"';
								//~ }
								//~ if ($ancho < $alto){
									//~ $Media100 = (100-(($ancho*100)/$alto))/2;
									//~ $classimagen .=	'style="padding:0 '.$Media100.'%;"';
	
								//~ }
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

				<div class="vm-product-name producto-<?php echo $rowsHeight[$row]['product_s_desc'] ?>">
					<h2><?php echo JHtml::link ($product->link.$ItemidStr, $product->product_name); ?></h2>
				</div>
			
			<!-- Contenedor de Stock y Precio  -->
			<div class="vm-product-precio-stock">

				<div class="vm-product-rating-container">
					<?php // Esto muestrás las estrellas de valoración que voy a eliminar. 
					//echo shopFunctionsF::renderVmSubLayout('rating',array('showRating'=>$showRating, 'product'=>$product));
					/* Cancelamos mostrar stock en vista categorias  y modulos ... 
					if ( VmConfig::get ('display_stock', 1)) { 
						if ( $product->product_in_stock == 0 ){
						echo 'SIN STOCK'; // Esto debería ser una constante... 
						} else {
						echo ' DISPONIBLE '; // Esto debería ser una constante...
						}
					
						?>
						
					<?php }*/
					// NO muestro Stock
					//echo  shopFunctionsF::renderVmSubLayout('stockhandle',array('product'=>$product));
					?>
				</div>
				<!-- Contenedor de Precios -->
				<?php //echo $rowsHeight[$row]['price'] ?>
				<div class="vm3pr-<?php echo $rowsHeight[$row]['price'] ?>"> <?php
					echo shopFunctionsF::renderVmSubLayout('prices',array('product'=>$product,'currency'=>$currency)); ?>
					<div class="clear"></div>
				</div>
				<?php //echo $rowsHeight[$row]['customs'] ?>
				
			</div>
			<div class="clear"></div>
			<!-- Ahora añadimos formularios de añadir carro y seleccion campos -->
<!--
			<div class="vm3pr-<?php echo $rowsHeight[$row]['customfields'] ?>"> 
-->
			<?php //echo shopFunctionsF::renderVmSubLayout('addtocart',array('product'=>$product,'rowHeights'=>$rowsHeight[$row])); ?>
<!--
			</div>
-->
<!--
			<div class="vm-details-button">
-->
				<?php // Product Details Button
				$link = empty($product->link)? $product->canonical:$product->link;
				//~ echo JHtml::link($link.$ItemidStr,vmText::_ ( 'COM_VIRTUEMART_PRODUCT_DETAILS' ), array ('title' => $product->product_name, 'class' => 'product-details' ) );
				//echo JHtml::link ( JRoute::_ ( 'index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' . $product->virtuemart_category_id , FALSE), vmText::_ ( 'COM_VIRTUEMART_PRODUCT_DETAILS' ), array ('title' => $product->product_name, 'class' => 'product-details' ) );
				?>
<!--
			</div>
-->

		</div>
	</div>

	<?php
    $nb ++;

      // Do we need to close the current row now?
      if ($col == $products_per_row || $nb>$BrowseTotalProducts) { ?>
    </div>
    <div class="clear"></div>
  </div>
      <?php
      	$col = 1;
		$row++;
    } else {
      $col ++;
    }
  }

      if(!empty($type)and count($products)>0){
        // Do we need a final closing row tag?
        //if ($col != 1) {
      ?>
    <div class="clear"></div>
  </div>
    <?php
    // }
    }
  }
