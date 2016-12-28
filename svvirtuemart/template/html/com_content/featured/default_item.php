<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Create a shortcut for params.
$params = $this->item->params;
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
$canEdit = $this->item->params->get('access-edit');
$info    = $params->get('info_block_position', 0);
// Variable para mostrar fecha , visitas, categorias
$useDefList = ($params->get('show_modify_date') || $params->get('show_publish_date') || $params->get('show_create_date')
	|| $params->get('show_hits') || $params->get('show_category') || $params->get('show_parent_category') || $params->get('show_author') );


// Creamos objeto de images
$imagenes = json_decode($this->item->images);
/* Donde Crea :
 * stdClass Object
(
    [image_intro] => images/Articulos/obraNueva.png
    [float_intro] => 
    [image_intro_alt] => 
    [image_intro_caption] => 			// Leyenda
    [image_fulltext] => 
    [float_fulltext] => 
    [image_fulltext_alt] => 
    [image_fulltext_caption] => 		// Leyenda
) */
if (isset($imagenes->image_intro) and !empty($imagenes->image_intro)) { 
			$ImagenIntro = $imagenes->image_intro;
		 } else {
			/* Entonces es que no hay imagen , por lo que entonces cargamos la imagens predefinada,
			 * hay que recordar que tenemos que tener la imagen carga , y es algo exclusivo para este TIPO 
			 * DE PLANTILLA.
			 * Por lo que la carpeta dería cambiar y lo ideal debería añadirse un parametro en la plantilla, con 
			 * este campo y archivo.
			 * */
			 $ImagenIntro = 'images/imagenes/Sin_imagen_disponible.jpg';
			 /* Esto debería ser un parametro de plantilla...
			  * Otros campos que deberíamos añadir son los de:
			  * imagen_intro_alt
			  * imagen_intro_caption
			  * y la varible $imgfloat pero de momento no lo hago*/
		} ;

// Creamos variables para maquetar
$titulo = $this->item->title;
$link = JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catslug));
$tituloUrl = '<a href="' . $link. '">' . $titulo . '</a>';
$textoIntrod = $this->item->introtext;
$autor = $this->item->author;
$fechaCreacion = $this->item->created;
$fechaPublicacion = $this->item->publish_up;
$fechaFinPublicacion = $this->item->publish_down; // Aunque no la vamos utilizar de momento.Deberíamos controlar con
// strtotime(JFactory::getDate() la fecha actual... 
$fechaModificacion = $this->item->modified; // Aunque no la vamos utilizar de momento.
$estadoArticulo = $this->item->state ; // Si es cero no esta publicado
$textoLeerMas = ' Algo' ;

/*
 echo ' ************************************************************************************';
 echo '<pre>';
 //print_r($imagenes);
 print_r($this->item);
 echo '</pre>';
 echo ' ************************************************************************************';
*/
?>
<?php // El articulo sino está publicado muestra clase system-unpublished muestra clase Principal
	if ($estadoArticulo == 0 ) : ?>
	<div class="system-unpublished">
<?php endif; ?>
<div class="blog-item" style="cursor: pointer;" onclick="<?php echo "javascript:window.open('".$link ."','_self');";?>
">
	
	<h2>
	<?php if ($params->get('link_titles') != 1 ) {
	echo $titulo; 
	} else {
	echo $tituloUrl; 
	}
	?>
	</h2>



<div class="blog-item-img">
	<img src="<?php echo $ImagenIntro;?>"/>
</div>
<div class="blog-item-contenido">
<?php 
	echo $this->item->introtext;
?>
</div>

<div class="blog-item-leermas">	
		<div class="boton-leermas">
				<?php 
				//echo '<a href="'.$link.'">'.JText::_('COM_CONTENT_READ_MORE').'</a>';
				echo '<a href="'.$link.'">+</a>';
				?>
		</div>
</div>


<?php /*//echo $this->item->event->beforeDisplayContent
// echo $this->item->introtext; ?>

<?php if ($useDefList && ($info == 1 || $info == 2)) : ?>
	<?php echo JLayoutHelper::render('joomla.content.info_block.block', array('item' => $this->item, 'params' => $params, 'position' => 'below')); ?>
<?php  endif; ?>

<?php if ($canEdit || $params->get('show_print_icon') || $params->get('show_email_icon')) : ?>
	<!-- Imprimir , email ,editar  -->
	<?php echo JLayoutHelper::render('joomla.content.icons', array('params' => $params, 'item' => $this->item, 'print' => false)); ?>
	<!-- Fin de imprimir , email y editar -->
<?php endif; ?>
<?php if ($params->get('show_tags') && !empty($this->item->tags->itemTags)) : ?>
	<!-- Impresion de etiquetas del articulo  -->
	<?php echo JLayoutHelper::render('joomla.content.tags', $this->item->tags->itemTags); ?>
	<!-- Fin impresion de etiquetas de articulo 
<?php endif; ?>

<?php if ($useDefList && ($info == 0 || $info == 2)) : ?>
	<!-- Imprimir categorias,,, -->
	<?php echo JLayoutHelper::render('joomla.content.info_block.block', array('item' => $this->item, 'params' => $params, 'position' => 'above')); ?>
<?php endif; ?>


<?php if ($params->get('show_readmore') && $this->item->readmore) :
	if ($params->get('access-view')) :
		$link = JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid));
	else :
		$menu = JFactory::getApplication()->getMenu();
		$active = $menu->getActive();
		$itemId = $active->id;
		$link1 = JRoute::_('index.php?option=com_users&view=login&Itemid=' . $itemId);
		$returnURL = JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid));
		$link = new JUri($link1);
		$link->setVar('return', base64_encode($returnURL));
	endif; ?>

	<?php echo JLayoutHelper::render('joomla.content.readmore', array('item' => $this->item, 'params' => $params, 'link' => $link)); ?>

<?php endif;*/ ?>


</div> <!-- Cerramos blog -item -->



<?php if ($this->item->state == 0 || strtotime($this->item->publish_up) > strtotime(JFactory::getDate())
	|| ((strtotime($this->item->publish_down) < strtotime(JFactory::getDate())) && $this->item->publish_down != '0000-00-00 00:00:00' )) : ?>
</div>
<?php endif; ?>

<?php //echo $this->item->event->afterDisplayContent; ?>
