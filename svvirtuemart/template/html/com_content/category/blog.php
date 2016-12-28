<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

JHtml::_('behavior.caption');
/* Vista blog 
 * version : 1.0 bootstrap
 * Ricardo Carpintero - Soluciones Vigo.
 * Variable a conocer:
 * 	$this->columns : La columnas que marcamos en opciones de vista, tanto de generales como en el item de menu.
 * */

?>
<div class="blog<?php echo $this->pageclass_sfx; ?>" >
	<?php // Titulo de pagina marcamos parametros en item de menu
	if ($this->params->get('show_page_heading', 1)) : ?>
		<div class="page-header">
			<h1> <?php echo $this->escape($this->params->get('page_heading')); ?> </h1>
		</div>
	<?php endif; ?>

	<?php // Titulo de Categoria 
	if ($this->params->get('show_category_title', 1) or $this->params->get('page_subheading')) : ?>
		<h1> <?php echo $this->escape($this->params->get('page_subheading')); ?>
			<?php if ($this->params->get('show_category_title')) : ?>
				<?php echo $this->category->title; ?>
			<?php endif; ?>
		</h1>
	<?php endif; ?>

	<?php // Si tenemos etiquetas [TAGS ] y si parametros lo muestra..
	if ($this->params->get('show_cat_tags', 1) && !empty($this->category->tags->itemTags)) : ?>
		<?php // EL siguiente código me parece genera los documentos nuevos de tags.. o links
		$this->category->tagLayout = new JLayoutFile('joomla.content.tags'); ?>
		<?php
			//~ echo '<pre>';
				//~ print_r($this->category->tags->itemTags);
			//~ echo '</pre>';
		echo $this->category->tagLayout->render($this->category->tags->itemTags); 
		
		
		
		?>
	<?php endif; ?>

	<?php if ($this->params->get('show_description', 1) || $this->params->def('show_description_image', 1)) : ?>
		<div class="category-desc clearfix">
			<?php if ($this->params->get('show_description_image') && $this->category->getParams()->get('image')) : ?>
				<img src="<?php echo $this->category->getParams()->get('image'); ?>"/>
			<?php endif; ?>
			<?php if ($this->params->get('show_description') && $this->category->description) : ?>
				<?php echo JHtml::_('content.prepare', $this->category->description, '', 'com_content.category'); ?>
			<?php endif; ?>
		</div>
	<?php endif; ?>

	<?php if (empty($this->lead_items) && empty($this->link_items) && empty($this->intro_items)) : ?>
		<?php if ($this->params->get('show_no_articles', 1)) : ?>
			<p><?php echo JText::_('COM_CONTENT_NO_ARTICLES'); ?></p>
		<?php endif; ?>
	<?php endif; ?>

	<?php $leadingcount = 0; ?>
	<?php if (!empty($this->lead_items)) : 
	// Entramos en principales si hay 
	?>
		<div class="items-leading clearfix">
			<?php foreach ($this->lead_items as &$item) : ?>
				<!-- Entramos en Principales --->
				<div class="leading-<?php echo $leadingcount; ?><?php echo $item->state == 0 ? ' system-unpublished' : null; ?>"
					itemprop="blogPost" itemscope itemtype="http://schema.org/BlogPosting">
					<?php
					$this->item = & $item;
					echo $this->loadTemplate('principales');
					?>
				</div>
				<?php $leadingcount++; ?>
			<?php endforeach; ?>
		</div><!-- end items-leading -->
	<?php endif; ?>

	<?php
	$numColumnas = $this->params['num_columns'];// Numero columnas que pusimos en Global o en Menu.
	$CantidadItems = (count($this->intro_items)); // Cantidad articulos que hay para mostrar.
	$ItemsParamIntro = $this->params['num_intro_articles'];// Numero Articulos que pusimos en Global o en Menu
	//~ echo 'Numero articulos que hay:'.$CantidadItems.'<br/>';
	//~ echo 'Numero de articulos que hay parametros:'.$ItemsParamIntro.'<br/>';
	//~ echo 'Numero de columnas:'.$numColumnas;

	$counter = 0; // Contador Item
	$columna = 0;
	$rowcount =  0 ;
	// Calculo de col-md- para bootstarp.... 12/columnas 
	// la cuestión es si no hay la cantidad items ,entonces tendremos que ajustar al medio... 
	if ($numColumnas>0){
	$mdColumnas =(int) 12 / $numColumnas;
	} else {
	$mdColumnas = 12;
	}
	?>

	<?php if (!$CantidadItems == 0) { ?>
		<?php foreach ($this->intro_items as $key => &$item) : ?>
			<?php
				// (int) $this->columns es el numero de columnas que pusimos en opciones de plantilla blog
				$columna = $columna + 1; 
				$counter = $counter + 1;
				// Creo variable tipo columna para saber si es la primera y la ultima
				$tipocolumna = 'medio';	
			?>
			<?php
				if ($columna == $this->columns) {
					$tipocolumna = 'ultima';
				}	
				if ($columna == 1) {
					$tipocolumna = 'primera';
					$rowcount = $rowcount + 1;
				// Ahora tengo que comprobar si las hay articulos para cubrir toda las columnas.
				// Si no es así tipofila "incompleta" de lo contrario "completa" 
					
					if ( ($CantidadItems - $counter) >= $numColumnas){
					$tipofila= "completa";
					} else {
					$tipofila= "incompleta";
					}
				?>
				<div class="items-row-<?php echo $rowcount;?> col-md-12 tipofila-<?php echo $tipofila;?>">
			<?php } ?>
					<div class="col-md-<?php echo $mdColumnas.' tipoColumna-'.$tipocolumna.' column-'.$rowcount.' item-'.$counter; ?>">
					
					<?php $this->item = & $item;
					echo $this->loadTemplate('item');
					?>
					</div>
					<!-- Cierre columna col-md -->
				<?php // Ahora cerramos row si es la ultima columna 
				 if (( $tipocolumna == 'ultima') or ($counter == $CantidadItems)) { 
					// Entra aquí cuando es la ultima columna o cuando es el ultimo Item
					// y entonces esta fila no tiene tiene la cantidad de items que le indicamos
					// por ejemplo:
					// Queremos que muestre 4 columnas y tenemos 7 articulos solo, la segunda fila
					// solo mostrará 3 items y en 7 articulo entrará. 
					$columna = 0 ;
					?>
					</div> <!-- cierre de row -->
					<div class="separador"></div>
			<?php } ?>
		<?php endforeach; ?>
	<?php } else { ?>
		<div class="alert alert-warning">
		<?php  // Alerta que no hay articulos de en está categoria.
				echo JTEXT::_('COM_CONTENT_NO_ARTICLES');?>
		</div>
		<?php
		}; ?>
	<div class="ssssss"></div><!-- Separador de blog 2 -->
	<?php if (!empty($this->link_items)) : ?>
		<div class="items-more">
			<?php echo $this->loadTemplate('links'); ?>
		</div><!-- Cierre de links -->
	<?php endif; ?>

	<?php if (!empty($this->children[$this->category->id]) && $this->maxLevel != 0) : ?>
		<div class="cat-children">
			<?php if ($this->params->get('show_category_heading_title_text', 1) == 1) : ?>
				<h3> <?php echo JTEXT::_('JGLOBAL_SUBCATEGORIES'); ?> </h3>
			<?php endif; ?>
			<?php echo $this->loadTemplate('children'); ?> 
		</div> <!-- Cierre de cat-children -->
	<?php endif; ?>
	<?php if (($this->params->def('show_pagination', 1) == 1 || ($this->params->get('show_pagination') == 2)) && ($this->pagination->get('pages.total') > 1)) : ?>
		<div class="pagination">
			<?php if ($this->params->def('show_pagination_results', 1)) : ?>
				<p class="counter pull-right"> <?php echo $this->pagination->getPagesCounter(); ?> </p>
			<?php endif; ?>
			<?php echo $this->pagination->getPagesLinks(); ?> 
		</div> <!-- pagination -->
	<?php endif; ?>
</div> <!-- fin blog -->
