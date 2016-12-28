
<?php
/**
 *
 * Show the product details page
 *
 * @package	VirtueMart
 * @subpackage
 * @author Max Milbers, Eugen Stranz, Max Galt
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2014 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default.php 9058 2015-11-10 18:30:54Z Milbo $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
$Usuario = $this->user;
// Para saber si es administrado , tiene que pertenecer al group 8
// El array $Usuario->groups contiene todos los group permisos que pertenece
// con  if in_array(8,$Usuario,true) entra en condicional




/* Let's see if we found the product */
if (empty($this->product)) {
	echo vmText::_('COM_VIRTUEMART_PRODUCT_NOT_FOUND');
	echo '<br /><br />  ' . $this->continue_link_html;
	return;
}

echo shopFunctionsF::renderVmSubLayout('askrecomjs',array('product'=>$this->product));


// Si se va imprimir, generamos el cuerpo...
if(vRequest::getInt('print',false)){ 
?>
	<body onload="javascript:print();">
<?php
 }
?>

<div class="productdetails-view productdetails">

    <?php
    // Product Navigation
    if (VmConfig::get('product_navigation', 1)) {
	?>
        <div class="product-neighbours">
	    <?php
	    if (!empty($this->product->neighbours ['previous'][0])) {
		$prev_link = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->neighbours ['previous'][0] ['virtuemart_product_id'] . '&virtuemart_category_id=' . $this->product->virtuemart_category_id, FALSE);
		echo JHtml::_('link', $prev_link, $this->product->neighbours ['previous'][0]
			['product_name'], array('rel'=>'prev', 'class' => 'previous-page','data-dynamic-update' => '1'));
		

	    }
	    if (!empty($this->product->neighbours ['next'][0])) {
		$next_link = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->neighbours ['next'][0] ['virtuemart_product_id'] . '&virtuemart_category_id=' . $this->product->virtuemart_category_id, FALSE);
		echo JHtml::_('link', $next_link, $this->product->neighbours ['next'][0] ['product_name'], array('rel'=>'next','class' => 'next-page','data-dynamic-update' => '1'));
	    }
	    ?>
    	<div class="clear"></div>
        </div>
    <?php
    } // Product Navigation END
    ?>

	<?php // Back To Category Button
	if ($this->product->virtuemart_category_id) {
		$catURL =  JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$this->product->virtuemart_category_id, FALSE);
		$categoryName = vmText::_($this->product->category_name) ;
	} else {
		$catURL =  JRoute::_('index.php?option=com_virtuemart');
		$categoryName = vmText::_('COM_VIRTUEMART_SHOP_HOME') ;
	}
	?>
	
    <?php // afterDisplayTitle Event
    echo $this->product->event->afterDisplayTitle ?>

    <?php
    // Solo muestra botton de editar si eres administrador de la tienda
    echo $this->edit_link;
    // Product Edit Link END
    ?>

    
	<?php
	echo shopFunctionsF::renderVmSubLayout('customfields',array('product'=>$this->product,'position'=>'ontop'));
    ?>

<div class="vm-product-container row">
	<div class="col-md-12">
		<div class="vm-product-details-columna1 col-md-7">
			<div class="vm-product-imagenes">
			<?php
			echo $this->loadTemplate('images');
			?>
			<?php
					// Mostramos las imagenes pequenas si las hay
					$count_images = count ($this->product->images);
					if ($count_images > 1) {
						echo $this->loadTemplate('images_additional');
					}
					?>   
			<?php
				// Iconos de redes sociales.
			?>
			</div>
			<div class="col-md-12 icons-redes-sociales">
			<?php
				
				// Generar url para compartir
				$uri = JFactory::getURI(); 
				$vm_link = str_replace(JURI::base(),"",$uri->toString());
				//~ $vm_link ='index.php?tmpl=component&option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->virtuemart_product_id;
				$link = JRoute::_($vm_link);
					//old
					//$full_link = JURI::base().substr(JRoute::_($vm_link), strlen(JURI::base(true)) + 1);
					
					$full_link = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}/{$_SERVER['REQUEST_URI']}";

					$title = $article->product_name;

				//~ $link ='index.php?tmpl=component&option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->virtuemart_product_id;
				//~ echo 'Link:'.$full_link;
				echo '<span class="icono-compartir"> ¡Compártelo!</span>';
				// Compartir en facebook
				echo '<span class="icono-compartir"><a title="Facebook" target="append_blank" href=""></a></span>';
				// Compartir en pinterest
				echo '<span class="icono-compartir"><a title="Pinterest" "target="append_blank" href=""><img src="" alt="Compartir en "></a></span>';
				// Compartir en twitter
				echo '<span class="icono-compartir"><a title="Twitter" target="append_blank" href="https://twitter.com/share?url='.$full_link.'"><img src="" alt="Compartir "></a></span>';

				// PDF - Print - Email Icon
				if (VmConfig::get('show_emailfriend')){
					$MailLink = 'index.php?option=com_virtuemart&view=productdetails&task=recommend&virtuemart_product_id=' . $this->product->virtuemart_product_id . '&virtuemart_category_id=' . $this->product->virtuemart_category_id . '&tmpl=component';
					echo '<span class="icono-compartir">';
					echo $this->linkIcon($MailLink, 'COM_VIRTUEMART_EMAIL', 'email-compartir', 'show_emailfriend', false,true,false,'class="recommened-to-friend"');
					echo '</span>';
				}
				if (VmConfig::get('show_printicon')){
					$link = 'index.php?tmpl=component&option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->virtuemart_product_id;
					echo '<span class="icono-compartir">';
					echo $this->linkIcon($link . '&print=1', 'COM_VIRTUEMART_PRINT', 'Imprimir-compartir', 'show_printicon',false,true,false,'class="printModal"');
					echo '</span>';
				} 
				if (VmConfig::get('pdf_icon')) {
				?>
					<?php

					$link = 'index.php?tmpl=component&option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->virtuemart_product_id;
					echo '<span class="icono-compartir">';
					echo $this->linkIcon($link . '&format=pdf', 'COM_VIRTUEMART_PDF', 'pdf_button', 'pdf_icon', false);
					echo '</span>';
					
					
					//echo $this->linkIcon($link . '&print=1', 'COM_VIRTUEMART_PRINT', 'printButton', 'show_printicon');
					//~ echo $this->linkIcon($link . '&print=1', 'COM_VIRTUEMART_PRINT', 'printButton', 'show_printicon',false,true,false,'class="printModal"');
					//~ $MailLink = 'index.php?option=com_virtuemart&view=productdetails&task=recommend&virtuemart_product_id=' . $this->product->virtuemart_product_id . '&virtuemart_category_id=' . $this->product->virtuemart_category_id . '&tmpl=component';
					//~ echo $this->linkIcon($MailLink, 'COM_VIRTUEMART_EMAIL', 'emailButton', 'show_emailfriend', false,true,false,'class="recommened-to-friend"');
					?>
					<div class="clear"></div>
			 
				<?php } // PDF - Print - Email Icon END
				?>
			</div> <!-- Fin capa de redes sociales -->
			<?php
			//echo ($this->product->product_in_stock - $this->product->product_ordered);
			// Product Description
			if (!empty($this->product->product_desc)) {
				?>
				<div class="product-description">
					<?php /** @todo Test if content plugins modify the product description */ ?>
					<span class="tituloInformacion"><?php echo vmText::_('Mas información') ?></span>
					<?php echo $this->product->product_desc; ?>
				</div>
			<?php
			} // Product Description END
			?>
		</div>
		<!-- Cierre div vm-product-details-columna1 -->
		<div class="vm-product-details-columna2 col-md-5">
		<?php
			// Manufacturer of the Product
			if (VmConfig::get('show_manufacturers', 1) && !empty($this->product->virtuemart_manufacturer_id)) {
			?>
				<div class="Fabricante">
					<?php
					echo 'ID '.$this->product->virtuemart_product_id;
					// Creamos una vista distinta para  los fabricantes 
					if (in_array(8, $Usuario->groups) == 1){
					// Vista fabricantes para que vean los administradores
					 echo ''.$this->loadTemplate('manufactureradmin').'';
					} else {
					// Vista fabricantes
					
					 echo ''.$this->loadTemplate('manufacturer');
					}
					?>
				</div>
			<?php
			}
			?>
			<?php // Product Title   ?>
			<div class="tituloProducto">
				<h1 itemprop="name"><?php echo $this->product->product_name ?></h1>
			</div>
			<?php // Product Title END   ?>
	    
		    <div class="spacer-buy-area">

			<?php
			// TODO in Multi-Vendor not needed at the moment and just would lead to confusion
			/* $link = JRoute::_('index2.php?option=com_virtuemart&view=virtuemart&task=vendorinfo&virtuemart_vendor_id='.$this->product->virtuemart_vendor_id);
			  $text = vmText::_('COM_VIRTUEMART_VENDOR_FORM_INFO_LBL');
			  echo '<span class="bold">'. vmText::_('COM_VIRTUEMART_PRODUCT_DETAILS_VENDOR_LBL'). '</span>'; ?><a class="modal" href="<?php echo $link ?>"><?php echo $text ?></a><br />
			 */
			?>

			<?php
			//~ echo shopFunctionsF::renderVmSubLayout('rating',array('showRating'=>$this->showRating,'product'=>$this->product));

			if (is_array($this->productDisplayShipments)) {
			    foreach ($this->productDisplayShipments as $productDisplayShipment) {
				echo $productDisplayShipment . '<br />';
			    }
			}
			if (is_array($this->productDisplayPayments)) {
			    foreach ($this->productDisplayPayments as $productDisplayPayment) {
				echo $productDisplayPayment . '<br />';
			    }
			}

			//In case you are not happy using everywhere the same price display fromat, just create your own layout
			//in override /html/fields and use as first parameter the name of your file
			echo shopFunctionsF::renderVmSubLayout('prices',array('product'=>$this->product,'currency'=>$this->currency));
			?>
			<div class="clear"></div>
			<?php
				// Product Short Description
				if (!empty($this->product->product_s_desc)) {
				?>
					<div class="product-short-description">
					<?php
					/** @todo Test if content plugins modify the product description */
					echo nl2br($this->product->product_s_desc);
					?>
					</div>
				<?php
				} // Product Short Description END
				?>
			<?php
			// Link para comentar sobre el producto
			?>
			<div class="ask-a-question">
			<?php
			//~ if (VmConfig::get('ask_question', 0) == 1) {
				$askquestion_url = JRoute::_('index.php?option=com_virtuemart&view=productdetails&task=askquestion&virtuemart_product_id=' . $this->product->virtuemart_product_id . '&virtuemart_category_id=' . $this->product->virtuemart_category_id . '&tmpl=component', FALSE);
				?>
					<a class="comentario" href="<?php echo $askquestion_url ?>" rel="nofollow" ><?php echo vmText::_('COM_VIRTUEMART_PRODUCT_ENQUIRY_LBL') ?></a>
			<?php
			//~ } else {
			//~ echo vmText::_('COM_VIRTUEMART_PRODUCT_ENQUIRY_LBL') ;
			//~ }
			?>
			</div>
			<?php
			// Fin de link para comentar el producto.
			?>
			<?php
			// Creamos formulario de añadir al carro y campos personalizado
			echo shopFunctionsF::renderVmSubLayout('addtocart',array('product'=>$this->product));
			// Fin campos personalizados 

			echo shopFunctionsF::renderVmSubLayout('stockhandle',array('product'=>$this->product));
			?>
			
				




			

			

		    </div>
		</div>
		<!-- Cierre div vm-product-details-columna2 -->
	</div>
</div>
<!-- Cierre div vm-product-container row -->



<?php
	// event onContentBeforeDisplay
	echo $this->product->event->beforeDisplayContent; ?>


<?php
	echo shopFunctionsF::renderVmSubLayout('customfields',array('product'=>$this->product,'position'=>'normal'));

    // Product Packaging
    $product_packaging = '';
    if ($this->product->product_box) {
	?>
        <div class="product-box">
	    <?php
	        echo vmText::_('COM_VIRTUEMART_PRODUCT_UNITS_IN_BOX') .$this->product->product_box;
	    ?>
        </div>
    <?php } // Product Packaging END ?>

    <?php 
	echo shopFunctionsF::renderVmSubLayout('customfields',array('product'=>$this->product,'position'=>'onbot'));
	// Entramos en productos relacionados , es Sublayout de related
	echo shopFunctionsF::renderVmSubLayout('customnuevo',array('product'=>$this->product,'position'=>'related_products','class'=> 'product-related-products','customTitle' => true ));
	// Fin de presentacion de productos relacionados.
	echo shopFunctionsF::renderVmSubLayout('customfields',array('product'=>$this->product,'position'=>'related_categories','class'=> 'product-related-categories'));

	?>

<?php // onContentAfterDisplay event
echo $this->product->event->afterDisplayContent;
// Presentamos comentarios 

//echo $this->loadTemplate('reviews');

// Fin de comentarios.

// Show child categories

//~ if (VmConfig::get('showCategory', 1)) {
	//~ echo $this->loadTemplate('showcategory');
//~ }

// Fin presentacion de categorias
$j = 'jQuery(document).ready(function($) {
	Virtuemart.product(jQuery("form.product"));

	$("form.js-recalculate").each(function(){
		if ($(this).find(".product-fields").length && !$(this).find(".no-vm-bind").length) {
			var id= $(this).find(\'input[name="virtuemart_product_id[]"]\').val();
			Virtuemart.setproducttype($(this),id);

		}
	});
});';
//vmJsApi::addJScript('recalcReady',$j);

/** GALT
 * Notice for Template Developers!
 * Templates must set a Virtuemart.container variable as it takes part in
 * dynamic content update.
 * This variable points to a topmost element that holds other content.
 */
$j = "Virtuemart.container = jQuery('.productdetails-view');
Virtuemart.containerSelector = '.productdetails-view';";

vmJsApi::addJScript('ajaxContent',$j);

if(VmConfig::get ('jdynupdate', TRUE)){
	$j = "jQuery(document).ready(function($) {
	Virtuemart.stopVmLoading();
	var msg = '';
	jQuery('a[data-dynamic-update=\"1\"]').off('click', Virtuemart.startVmLoading).on('click', {msg:msg}, Virtuemart.startVmLoading);
	jQuery('[data-dynamic-update=\"1\"]').off('change', Virtuemart.startVmLoading).on('change', {msg:msg}, Virtuemart.startVmLoading);
});";

	vmJsApi::addJScript('vmPreloader',$j);
}

echo vmJsApi::writeJS();

if ($this->product->prices['salesPrice'] > 0) {
  echo shopFunctionsF::renderVmSubLayout('snippets',array('product'=>$this->product, 'currency'=>$this->currency, 'showRating'=>$this->showRating));
}

?>
</div>



