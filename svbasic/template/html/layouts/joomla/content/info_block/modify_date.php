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
			<dd class="modified">
				<span class="glyphicon glyphicon-refresh"></span>
				<time datetime="<?php echo JHtml::_('date', $displayData['item']->modified, 'c'); ?>" itemprop="dateModified">
					<?php echo '<a title="'.JTEXT::_('COM_CONTENT_LAST_UPDATED').'">'.JHtml::_('date', $displayData['item']->modified, JText::_('DATE_FORMAT_LC3')).'</a>'; ?>
				</time>
			</dd>
<?php
}  else {
	// Pasamos parametro Si , entonce solo mostramos icono.
?>

			<dd class="modified">
					<a class="icon" title="<?php echo  $displayData['item']->modified;?>"><span class="glyphicon glyphicon-refresh"></span></a>
			</dd>
<?php 
}
?>
