<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;
if ($displayData['columna'] == 'no' or !isset($displayData['columna'])) {;
// Quiere decir que le pasamos este parametro y es un articulo en toda la pantalla.

?>
			<dd class="hits">
					<span class="glyphicon glyphicon-thumbs-up"></span>
					<meta itemprop="interactionCount" content="UserPageVisits:<?php echo $displayData['item']->hits; ?>" />
					<?php echo $displayData['item']->hits; ?>
			</dd>
<?php
}  else {
	// Pasamos parametro Si , entonce solo mostramos icono.
?>

			<dd class="hits">
					<meta itemprop="interactionCount" content="UserPageVisits:<?php echo $displayData['item']->hits; ?>" />
					<a class="icon" title="<?php echo $displayData['item']->hits;?>"><span class="glyphicon glyphicon-thumbs-up"></span></a>
			</dd>
<?php 
}
?>
