<?php defined('_JEXEC') or die('Restricted access');




echo '<!-- Estoy en html/sublayout/related -->';
$related = $viewData['related'];
$customfield = $viewData['customfield'];
$thumb = $viewData['thumb'];
// Creamos objeto con display ( $viewData[thumb])
// Así podemos extraer la imagen
$img= simplexml_load_string($thumb);
// Extraemos la imagen
$imagen= $img[src];

// Ahora creamos link
$Idproducto =$related->virtuemart_product_id ;
$IdCategoria = $related->virtuemart_category_id;
$link='index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='
		.$Idproducto.'&virtuemart_category_id='.$IdCategoria;
// Ahora convertimos link en amigable.
$link = JRoute::_ ($link);

// Ahora vemos nombre del producto para meter en title.
$titleProductoRel = $related->product_name;
//~ echo '<pre>';
//~ echo '<a href="'.$link.'">'.$link.'</a><br/>';
//~ echo $img[src].'<br/>';
//~ echo $titleProductoRel;
//~ echo '</pre>';
?>
<div class="col-md-10 contenedor-relacionado">
<a href="<?php echo $link;?>" title="<?php echo $titleProductoRel;?>">
<img src="<?php echo $imagen;?>"alt="<?php echo $titleProductoRel;?>" style="width:100%"/>
</a>
</div>


<?php
// El código siguiente lo comento ya que no me hace falta... era el que tenía antes
/*
//juri::root() For whatever reason, we used this here, maybe it was for the mails
echo JHtml::link (JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $related->virtuemart_product_id . '&virtuemart_category_id=' . $related->virtuemart_category_id), $thumb   . $related->product_name, array('title' => $related->product_name,'target'=>'_blank'));

if($customfield->wPrice){
	$currency = calculationHelper::getInstance()->_currencyDisplay;
	echo $currency->createPriceDiv ('salesPrice', 'COM_VIRTUEMART_PRODUCT_SALESPRICE', $related->prices);
}
if($customfield->wDescr){
	echo '<p class="product_s_desc">'.$related->product_s_desc.'</p>';
}
*/
