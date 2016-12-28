<?php
/**
 *
 * Order detail view
 *
 * @package	VirtueMart
 * @subpackage Orders
 * @author Oscar van Eijk, Valerie Isaksen
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: details_order.php 5341 2012-01-31 07:43:24Z alatak $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
?>

<?php // Si el documento es una factura
if ($this->doctype == 'invoice') {
  if ($this->invoiceNumber) { ?>
<h1><?php echo vmText::_('COM_VIRTUEMART_INVOICE').' '.$this->invoiceNumber; ?> </h1>
<?php }
} elseif ($this->doctype == 'deliverynote') { ?>
<h1><?php echo vmText::_('COM_VIRTUEMART_DELIVERYNOTE'); ?> </h1>
<?php } elseif ($this->doctype == 'confirmation') { ?>
<h1><?php echo vmText::_('COM_VIRTUEMART_CONFIRMATION'); ?> </h1>

<?php } 

?>

<table width="98%" cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td>
		<?php if ($this->invoiceNumber) { 
			// Texto fecha facturacion
			echo vmText::_('COM_VIRTUEMART_INVOICE_DATE').' : '; 
			echo vmJsApi::date($this->invoiceDate, 'LC4', true); ?>
		<?php } ?>
		<br/>
		<?php // Texto fecha entrega
		if (!empty($this->orderDetails['details']['BT']->delivery_date)) { 
				echo vmText::_('COM_VIRTUEMART_DELIVERY_DATE').' : ';
				echo $this->orderDetails['details']['BT']->delivery_date ?>
		<?php } ?>
		<br/>
		<?php // Numero de pedido.
		echo vmText::_('COM_VIRTUEMART_ORDER_PRINT_PO_NUMBER').' : ';?>
		<strong>
		<?php echo $this->orderDetails['details']['BT']->order_number; ?>
		</strong>
		<br/>
		<?php echo vmText::_('COM_VIRTUEMART_ORDER_PRINT_PO_DATE').' : ';
		 echo vmJsApi::date($this->orderDetails['details']['BT']->created_on, 'LC4', true); ?>
		 <br/>
		 <?php echo vmText::_('COM_VIRTUEMART_ORDER_PRINT_PO_STATUS').' : ';
		  echo $this->orderstatuses[$this->orderDetails['details']['BT']->order_status]; ?>
		<br/> 
    	<small>
    	<?php // No muesto label ya que tiene icono y es largo.
    	//echo vmText::_('COM_VIRTUEMART_ORDER_PRINT_SHIPMENT_LBL').' :<br/> '; 
	    echo $this->orderDetails['shipmentName'];?>
	    </small>
	    <br/> 
		<?php // No muesto label ya que tiene icono y es largo.
		//echo vmText::_('COM_VIRTUEMART_ORDER_PRINT_PAYMENT_LBL').' :<br/> '; 
		echo $this->orderDetails['paymentName']; ?>
		<br/>  
		<?php if ($this->orderDetails['details']['BT']->customer_note) { 
			echo vmText::_('COM_VIRTUEMART_ORDER_PRINT_CUSTOMER_NOTE').' : '; 
			echo $this->orderDetails['details']['BT']->customer_note; ?>
		<?php } ?>
		<br/>  
		
		</td>
    	
    	<td valign="top" >
			<strong>
			<?php /* Columna de datos dirección a donde enviar.
			   * Recuerda que se monta con un bucle y una table
			   */
			echo vmText::_('COM_VIRTUEMART_ORDER_PRINT_SHIP_TO_LBL') ?>
			</strong>
			<br/>
	    <table border="0">
			<?php
			foreach ($this->shipmentfields['fields'] as $field) {
				if (!empty($field['value'])) {
					echo '<tr><td class="key">' . $field['title'] . '</td>'
					. '<td>' . $field['value'] . '</td></tr>';
				}
			}
			?>
	    </table>
	</td>
	</tr>
    <?php if ($this->doctype == 'invoice') { ?>
    <tr>
		<td>
			<h2>
			<strong>
			<?php echo vmText::_('COM_VIRTUEMART_ORDER_PRINT_TOTAL'). ' : ';?>
			<?php echo $this->currency->priceDisplay($this->orderDetails['details']['BT']->order_total,$this->currency); ?>
			</strong>
			</h2>
			<br/>
		</td>
			
    </tr>	
    <?php } ?>	
	
    
</table>
