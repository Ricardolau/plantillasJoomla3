<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

$params = $displayData['params'];
$item = $displayData['item'];

/* En OPCIONES>>CONTENT tenemos la opciones de:
 *  Mostrar "Leer mas" -> Si o No  [show_readmore]
 *  Mostrar el titulo del articulo -> Si o no  [show_readmore_title]
 *  Limitamos en caracteres el link con el parametro: [readmore_limit]
 * 
 * En OPCIONES>>ARTICULO tenemos la opcion de:
 *  De cambiar el texto para leer mas para ese articulo. $item->alternative_readmore
 *  
 * Tambien hay opciones :
 *  if (!$params->get('access-view')) que es para que permita mostrar el leer mas si esta registro... 
 * o si tiene accesso
 * 
 * */
$readmore ="";
if (isset( $item->alternative_readmore)) {
	// quiere decir que hay texto alternativo
	$readmore = $item->alternative_readmore;
	} else {
	$readmore = JText::_('COM_CONTENT_READ_MORE');	
}
// Creamos texto titulo para link
// con la limitacion que le indicamos o 100 que trae por defecto
$titulo = JHtml::_('string.truncate', ($item->title), $params->get('readmore_limit'));


?>
<?php 
// Solo mostramos si está activa opcion mostrar leer mas
if ( $params->get('show_readmore')  != 0 ) {
	// Solo mostramos si tiene acceso
	 if ($params->get('access-view')) {
?>

		<div class="readmore">
			<a class="btn" title="<?php echo $titulo;?>"  href="<?php echo $displayData['link']; ?>" itemprop="url">
				<span class="glyphicon glyphicon-chevron-right"></span>
				
				<?php
				echo $readmore;
				if ($params->get('show_readmore_title', 0) != 0) :
						echo $titulo;
				endif;
				?>
			</a>
		</div>
	<?php 
	} else {
		// Quiere decir que no tiene acceso
		?> 
		<p class="readmore">
		<?php echo JText::_('COM_CONTENT_REGISTER_TO_READ_MORE');?>
		</p>
		<?php
	} 
}
?>
