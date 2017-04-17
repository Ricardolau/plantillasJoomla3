<?php
/**
 *
 * Show the products in a category
 *
 * @package    VirtueMart
 * @subpackage
 * @author RolandD
 * @author Max Milbers
 * @todo add pagination
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default.php 8715 2015-02-17 08:45:23Z Milbo $
 */

defined ('_JEXEC') or die('Restricted access');
/* Creo objecto de menu para poder mostrar el titulo del menu .. 
 * ya vituemart no hacer */
$app = JFactory::getApplication();
$menu = $app->getMenu();
$menuActivo = $menu->getActive(); // Obtenemos el array del item menu activo
$menuparams = $menu->getParams($menuActivo->id); // Obtenemos el parametros item
$menuItemstree = $menuActivo->tree; // Obtenemos listado id padres del item.
// En tree , no genera un array empezando po [0] desde el descendiente más bajo hasta
// el id activo.
// Por este motivo en la siguiente variable contamos el array descontamos 2
// descontamos el item actual y uno más porque empieza a contar desde [0]
$NItemsTree = (count( $menuItemstree)-2);

if ($NItemsTree >=  0 ) {
	// Quiere decir que tiene padre.. por lo que debemos 
	$IdItemAnterior = $menuItemstree[$NItemsTree];
	$ObjItemAnterior = $menu->getItem($IdItemAnterior); // Obtenemos objecto de itemAnterior
} else {
		// Si es menor o 0 quiere decir que no tiene padre o es el mismo. 
		$IdItemAnterior = $menuActivo->id;
		
} 

//~ echo '<pre>';
//~ echo 'El id del item que esta activo es '.$menuActivo->id.' El array familiar (padres sin activo) son: '.$NItemsTree.' <br/>';
//~ echo 'El id del padre es '. $IdItemAnterior.':<br/>';
//~ print_r($menuItemstree);
//~ echo '</pre>';
//~ 





?>
<!-- Mostramos Titulo de Item de Menu-->
<div class="blog">
	

	<?php if ($menuparams->get('show_page_heading',1) ) : ?>
		<div class="page-header corona">
			<?php if (is_file($this->category->file_url)){
				$styleone= 'style="background-image:none;text-align: center;padding:0px;"';
				$IconoCategoria = 	'<div>'.
									'<img src="'.$this->category->file_url .
									'" title="'. $this->category->category_name .
									'" alt="'.$this->category->category_name.'">'.
									'</div>';
				} else {
					// Para que no de error la creo vacias.
					$stylenone= '';
					$IconoCategoria = '';
				}
			?>
			<div class="CategoriaVirtuemart" <?php echo $styleone;?>>
				<?php echo $IconoCategoria;?>
				<div class="rayasI"></div>
				<h1><?php echo $this->category->category_name; ?></h1>
				<div class="rayasD"></div>
			</div>
			<?php
			if (empty($this->keyword) and !empty($this->category)) {
				?>
			<div class="category_description">
				<?php echo $this->category->category_description; ?>
			</div>
			<?php
			}
			?>
		</div>

	 <?php endif; ?>





<div class="category-view"> <?php
$js = "
jQuery(document).ready(function () {
	jQuery('.orderlistcontainer').hover(
		function() { jQuery(this).find('.orderlist').stop().show()},
		function() { jQuery(this).find('.orderlist').stop().hide()}
	)
});
";
vmJsApi::addJScript('vm.hover',$js);

/*if (empty($this->keyword) and !empty($this->category)) {
	?>
<div class="category_description">
	<?php echo $this->category->category_description; ?>
</div>
<?php
}*/

// Show child categories
if (VmConfig::get ('showCategory', 1) and empty($this->keyword)) {
	if (!empty($this->category->haschildren)) {

		echo ShopFunctionsF::renderVmSubLayout('categoE',array('categoE'=>$this->category->children));

	}
}

// Ahora mostramos link para volver a item anterior.
/* Ahora debemos comprobar si exite el Objeto $ObjItemAnterior
 * Si existe debemos indicar como obtener los datos que necesitamos
 * 
 * Titulo de item : $ObjItemAnterior->title *
 * Link : $ObjItemAnterior->link
 * 
 * 	echo '<pre>';
	print_r($ObjItemAnterior);
	echo '</pre>';
 * 
 * */

?>
<?php if ( is_object($ObjItemAnterior) ) : ?>
<div class="CategoriaAnterior col-md-6 col-md-offset-3">
	<h2>
	 <a href="<?php echo $ObjItemAnterior->link;?>" title="<?php echo $ObjItemAnterior->title;?>">
			  Volver a <?php echo $ObjItemAnterior->title;?>			  </a>
	</h2>
</div>

<?php endif; 

if($this->showproducts){
?>
<div class="browse-view">
<?php

if (!empty($this->keyword)) {
	//id taken in the view.html.php could be modified
	$category_id  = vRequest::getInt ('virtuemart_category_id', 0); ?>
	<h3><?php echo $this->keyword; ?></h3>

	<form action="<?php echo JRoute::_ ('index.php?option=com_virtuemart&view=category&limitstart=0', FALSE); ?>" method="get">

		<!--BEGIN Search Box -->
		<div class="virtuemart_search">
			<?php echo $this->searchcustom ?>
			<br/>
			<?php echo $this->searchCustomValues ?>
			<input name="keyword" class="inputbox" type="text" size="20" value="<?php echo $this->keyword ?>"/>
			<input type="submit" value="<?php echo vmText::_ ('COM_VIRTUEMART_SEARCH') ?>" class="button" onclick="this.form.keyword.focus();"/>
		</div>
		<input type="hidden" name="search" value="true"/>
		<input type="hidden" name="view" value="category"/>
		<input type="hidden" name="option" value="com_virtuemart"/>
		<input type="hidden" name="virtuemart_category_id" value="<?php echo $category_id; ?>"/>

	</form>
	<!-- End Search Box -->
<?php  } ?>

<?php // Show child categories

	?>

<?php 
/* Tener cuidado con este print_r ya que muestra contraseña de base de datos 
 * Lo realizo para saber cuantos productos hay en la categoria por si lo queremos 
 * mostrar.*/
//~ echo '<pre>'; 
//~ echo print_r($this->category->file_url);
//~ echo '</pre>';
// Así mostramos cuantos productos ha en la 
//echo $this->category->productcount;
?>

<div class="clear"></div>
<div class="orderby-displaynumber">
	<div class="floatleft vm-order-list">
		<?php echo $this->orderByList['orderby']; ?>
		<?php echo $this->orderByList['manufacturer']; ?>

		
	</div>
	
	<?php /* Elimino la presentación de la paginación al inicio ya que lo muestra
		  * también al final de la web <div class="vm-pagination vm-pagination-top">
		<span class="vm-page-counter"><?php echo $this->vmPagination->getPagesCounter (); ?></span>
		<?php // Muestra la páginación si el listado supera el limite que tenemos puesto listado. 
		 echo $this->vmPagination->getPagesLinks (); ?>
		
	</div> */ ?>
	<div class="floatright display-number">
	<?php echo $this->vmPagination->getResultsCounter();
	 echo $this->vmPagination->getLimitBox ($this->category->limit_list_step); ?>
	</div>
	


	<div class="clear"></div>
</div> <!-- end of orderby-displaynumber -->


	<?php
	
	//~ $vmtemplate =VmConfig::loadConfig(); // Asi sabemos que podemos obtener en config
	$ConfImagen = array (
				'width' 			=> VmConfig::get('img_width'),
				'height' 			=> VmConfig::get('img_height'),
				'ImgPendiente'		=> VmConfig::get('no_image_set'),
				'ImgNoEncontrada'	=> VmCOnfig::get('no_image_found')
				);
	

	if (!empty($this->products)) {
	$products = array();
	$products[0] = $this->products;
	echo shopFunctionsF::renderVmSubLayout($this->productsLayout,array('products'=>$products,'currency'=>$this->currency,'products_per_row'=>$this->perRow,'showRating'=>$this->showRating,'ConfImagen'=>$ConfImagen));

	?>

<div class="vm-pagination vm-pagination-bottom">
	<span class="vm-page-counter"><?php echo $this->vmPagination->getPagesCounter (); ?></span><br>
	<?php echo $this->vmPagination->getPagesLinks (); ?>
</div>

	<?php
} elseif (!empty($this->keyword)) {
	echo vmText::_ ('COM_VIRTUEMART_NO_RESULT') . ($this->keyword ? ' : (' . $this->keyword . ')' : '');
}
?>
</div>

<?php } ?>
</div>

<?php
$j = "Virtuemart.container = jQuery('.category-view');
Virtuemart.containerSelector = '.category-view';";

vmJsApi::addJScript('ajaxContent',$j);
?>
<!-- end browse-view -->
