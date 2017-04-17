<?php
/**
*
* Description
*
* @package	VirtueMart
* @subpackage
* @author
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: default.php 8695 2015-02-12 14:05:25Z Milbo $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
/* Creo objecto de menu para poder mostrar el titulo del menu .. 
 * ya vituemart no hacer */
$app = JFactory::getApplication();
$menu = $app->getMenu();
// El item de menu activo lo obtengo de 
$menuItemActivo= $menu->getActive()->params;

?>
<!-- Mostramos virtuemart Titulo de Item de Menu-->
<div class="blog">
	<?php if ($menuItemActivo->get('show_page_heading',1) ) : ?>
		<div class="page-header">
			<div class="CategoriaVirtuemart">
					<h1><?php echo $menuItemActivo->get('page_heading'); ?></h1>
			</div>
		</div>
	<?php endif; ?>



<?php # Vendor Store Description
// Link para añadir producto, pero lo cancelamos ya que bloque la Web
// echo $this->add_product_link;
if (!empty($this->vendor->vendor_store_desc) and VmConfig::get('show_store_desc', 1)) { ?>
<div class="vendor-store-desc">
	<?php echo $this->vendor->vendor_store_desc; ?>
</div>
<?php } ?>

<?php
# Categorías de carga de front_categories si existen
# teniendo en cuenta que carga los subLayout... 
if ($this->categories and VmConfig::get('show_categories', 1) ) {
	 echo $this->renderVmSubLayout('categoE',array('categoE'=>$this->categories));
	}
# Show template for : topten,Featured, Latest Products if selected in config BE
if (!empty($this->products) ) {
	
	//~ $vmtemplate =VmConfig::loadConfig(); // Asi sabemos que podemos obtener en config
	$ConfImagen = array (
				'width' 			=> VmConfig::get('img_width'),
				'height' 			=> VmConfig::get('img_height'),
				'ImgPendiente'		=> VmConfig::get('no_image_set'),
				'ImgNoEncontrada'	=> VmCOnfig::get('no_image_found')
				);
	
	
	$products_per_row = VmConfig::get ( 'homepage_products_per_row', 3 ) ;
	echo $this->renderVmSubLayout($this->productsLayout,array('products'=>$this->products,'currency'=>$this->currency,'products_per_row'=>$products_per_row,'showRating'=>$this->showRating,'ConfImagen'=>$ConfImagen)); //$this->loadTemplate('products');
}

?> <?php vmTime('vm view Finished task ','Start'); ?>
</div>
