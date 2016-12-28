<?php
/**
*
* Orderlist
* NOTE: This is a copy of the edit_orderlist template from the user-view (which in turn is a slighly
*       modified copy from the backend)
*
* @package	VirtueMart
* @subpackage Orders
* @author Oscar van Eijk
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: list.php 8429 2014-10-14 12:19:39Z Milbo $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
/* Vamos a cambiar la forma contar los pedidos.*/
$usuario = JFactory::getUser();
$idUsuario = $usuario->id; 
$pedidos = VmModel::getModel('orders');
$pedidosLista = $pedidos->getOrdersList($idUsuario, true);


?>
<div class="blog">
<h1><?php echo vmText::_('COM_VIRTUEMART_ORDERS_VIEW_DEFAULT_TITLE'); ?></h1>
<?php

//~ echo 'Isset:'.isset($this->orderlist[0]);
//~ echo '<pre>';
//~ echo 'ID Usuario:'.$usuario->id;
//~ echo '</pre>';



if (count($pedidosLista) == 0 | $usuario->id == 0) {
	/* Si el usuario no tiene pedidos o el usuario es 0, es decir no esta logueado carga los siguiente */
	echo vmText::_('COM_VIRTUEMART_ACC_NO_ORDER');
	/* Carga vista user/login */
	echo shopFunctionsF::getLoginForm(false,true);
} 

if (count($pedidosLista) > 0 && $usuario->id > 0) {
	/* Si el usuario está logueado y tiene pedidos, muestra lo siguiente */
	echo 'ID Usuario:'.$usuario->id;
	echo 'Hemos encontrado '.count($pedidosLista).' pedidos';
 ?>
	<div id="editcell">
	<table class="adminlist" width="80%">
	<thead>
	<tr>
		<th>
			<?php echo vmText::_('COM_VIRTUEMART_ORDER_LIST_ORDER_NUMBER'); ?>
		</th>
		<th>
			<?php echo vmText::_('COM_VIRTUEMART_ORDER_LIST_CDATE'); ?>
		</th>
		<!--th>
			<?php //echo vmText::_('COM_VIRTUEMART_ORDER_LIST_MDATE'); ?>
		</th -->
		<th>
			<?php echo vmText::_('COM_VIRTUEMART_ORDER_LIST_STATUS'); ?>
		</th>
		<th>
			<?php echo vmText::_('COM_VIRTUEMART_ORDER_LIST_TOTAL'); ?>
		</th>
	</thead>
	<?php
		$k = 0;
		foreach ($pedidosLista as $row) {
			$editlink = JRoute::_('index.php?option=com_virtuemart&view=orders&layout=details&order_number=' . $row->order_number, FALSE);
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td align="left">
					<a href="<?php echo $editlink; ?>" rel="nofollow"><?php echo $row->order_number; ?></a>
				</td>
				<td align="left">
					<?php echo vmJsApi::date($row->created_on,'LC4',true); ?>
				</td>
				<!--td align="left">
					<?php //echo vmJsApi::date($row->modified_on,'LC3',true); ?>
				</td -->
				<td align="left">
					<?php echo shopFunctionsF::getOrderStatusName($row->order_status); ?>
				</td>
				<td align="left">
					<?php echo $this->currency->priceDisplay($row->order_total, $row->currency); ?>
				</td>
			</tr>
	<?php
			$k = 1 - $k;
		}
	?>
	</table>
	</div>
</div>
<?php } ?>
