<?php
/**
* sublayout products
* para la vista detallada de un producto cuando carga
* relacionados.
* @package	VirtueMart
* @author Max Milbers
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2014 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL2, see LICENSE.php
* @version $Id: cart.php 7682 2014-02-26 17:07:20Z Milbo $
*/

defined('_JEXEC') or die('Restricted access');
$product = $viewData['product'];
$position = $viewData['position'];
$customTitle = isset($viewData['customTitle'])? $viewData['customTitle']: false;;
if(isset($viewData['class'])){
	$class = $viewData['class'];
} else {
	$class = 'product-fields';
}

if (!empty($product->customfieldsSorted[$position])) {
	?>
	<div class="<?php echo $class?>">
		<?php
		if($customTitle and isset($product->customfieldsSorted[$position][0])){
			$field = $product->customfieldsSorted[$position][0]; ?>
		<div class="title-product-relacionados">
				<strong>
					<?php echo 'Con este producto te recomendamos:'; ?>
				</strong>
		</div> 
		<?php
		}
		$custom_title = null;
		// El numero maximo de 6 producto siempre centrado.
		// Calculamos productos a mostrar.
		$Nproductos = count($product->customfieldsSorted[$position]);
		if ($Nproductos > 6 ){
			echo " Entro en If porque productos es mayor que 6";
		$Ncolumnas = 6	;
		} else {
		$Ncolumnas = $Nproductos ;
		}
		$row = 1;
		$nColMd=  floor (12 / $Ncolumnas); // Calculamos el número columnas para bootstrap
		$NProducto=0;
		$Ncol =0;
		
		?>
			
		<div class="product-field product-field-type-Relacionado">
		<?php
		foreach ($product->customfieldsSorted[$position] as $field) {
			if ( $field->is_hidden || empty($field->display))//OSP http://forum.virtuemart.net/index.php?topic=99320.0
			continue;
			?>
				<?php
				$NProducto	= $NProducto + 1;
				if (!empty($field->display)){
					$Ncol		= $Ncol + 1;
					if ($Ncol == 1){
					?>
					<div class="col-md-12 row<?php echo $row;?>">
					<?php
					}
					?>
						<div class="col-md-<?php echo $nColMd;?> product-field-display">
							
							<?php 
							//~ echo ' Entro en related';
							
							//~ echo '<pre>';
							//~ $related =  $viewData['customfield'];
							//~ print_r( $field);
							//~ echo '</pre>';
							
							echo $field->display;
							//~ echo ' Fin en related';
							?>
							
						</div>
				<?php
					if ($Ncol == $Ncolumnas){ 
					echo "	</div>"; // Cerramos div row
					$Ncol = 0;
					}


				}
				?>
				
		<?php
			$custom_title = $field->custom_title;
		} ?>
      </div>
	</div>
<?php
}
 ?>
