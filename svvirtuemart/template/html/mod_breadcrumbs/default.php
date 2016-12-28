<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_breadcrumbs
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
JHtml::_('bootstrap.tooltip');
/* Encuentro un error en este modulo.
 * Si tenemos una tienda virtuemart, si un producto pertenece a varias categorias
 * entonces, este modulo muestra repetido los item de menus.( No se porque )
 * La solucion que encuentro es que apartir del nombre del item activo, no muestre nada
 * solo el item final ( es decir el del producto que no tiene link) */
$menu = $app->getMenu();
$ItemMenuActivo = $menu->getActive(); 
$NombreMenuActivo = $ItemMenuActivo->title;// Nombre del item activo
/* Otro problema que encuentro es sustituir inicio por el icono que me manda el cliente
 * Para esto vamos tener que en configuración del modulo de la siguiente forma:
 * 		Mostrar Inicio = NO
 * 		Mostrar el "Estas aqui" = NO
 * */

//~ echo '<pre>';
//~ print_r($NombreMenuActivo);
//~ echo '</pre>'; 
?>

<ul itemscope itemtype="https://schema.org/BreadcrumbList" class="breadcrumb<?php echo $moduleclass_sfx; ?>">
	<?php if ($params->get('showHere', 1)) : ?>
		<li>
			<?php
			 echo  JText::_('MOD_BREADCRUMBS_HERE');
			  ?>&#160;
		</li>
	<?php else : ?>
		<li class="active">
			<span class="icon-breacrumb">
				
			</span>
		</li>
	<?php endif; ?>

	<?php
	// Get rid of duplicated entries on trail including home page when using multilanguage
	for ($i = 0; $i < $count; $i++)
	{
		if ($i == 1 && !empty($list[$i]->link) && !empty($list[$i - 1]->link) && $list[$i]->link == $list[$i - 1]->link)
		{
			unset($list[$i]);
		}
	}

	// Find last and penultimate items in breadcrumbs list
	end($list);
	$last_item_key = key($list);
	prev($list);
	$penult_item_key = key($list);

	// Make a link if not the last item in the breadcrumbs
	$show_last = $params->get('showLast', 1);

	// Generate the trail
	$Continuar = "Si";

	foreach ($list as $key => $item) :
			
		?>
		<?php
		if ($Continuar != "No") {
			if ($key != $last_item_key) :
			// Render all but last item - along with separator ?>
		
						<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
							<?php if (!empty($item->link)) : ?>
								<a itemprop="item" href="<?php echo $item->link; ?>" class="pathway">
									<span itemprop="name">
									<?php echo $item->name; ?>
									</span>
								</a>
							<?php else : ?>
								<span itemprop="name">
									<?php echo $item->name; ?>
								</span>
							<?php endif; ?>

							<?php /* Comento el separador, ya que lo maqueto con bootstrap
								if (($key != $penult_item_key) || $show_last) : ?>
								<span class="divider">
									<?php echo $separator; ?>
								</span> 
							<?php endif; ?>
							<meta itemprop="position" content="<?php echo $key + 1; ?>">*/?>
						</li>
			<?php endif;
		}
			?>
		<?php // Entra si es el ultimo item y tenemos en parametros SI mostrar ultimo tramo. 
		if ($show_last and $key == $last_item_key) :
			// Render last item if reqd. ?>
			<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="active">
				<span itemprop="name">
					<?php echo $item->name; ?>
				</span>
				<meta itemprop="position" content="<?php echo $key + 1; ?>">
			</li>
		<?php endif;
		// Ahora si es igual item con el item activo tenemos que poner variable continuar como NO
		if (trim($NombreMenuActivo) == trim($item->name)){ 
		$Continuar='No';
		}
	endforeach; ?>
</ul>
