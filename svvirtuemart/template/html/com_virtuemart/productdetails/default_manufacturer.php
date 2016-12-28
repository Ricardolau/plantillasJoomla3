<?php
/**
 *
 * Show the product details page
 *
 * @package	VirtueMart
 * @author Max Milbers, Valerie Isaksen
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2014 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * @version $Id: default_manufacturer.php 8702 2015-02-14 15:28:56Z Milbo $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
?>
	<?php
	$i = 1;

	$mans = array();
	// Gebe die Hersteller aus
	foreach($this->product->manufacturers as $manufacturers_details) {

		//Link to products
		//Link a pagina de productos del fabricante.
		//Mantinen la lista de categorias.. Serán las categorias de los productos de ese fabricante?
		$link = JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_manufacturer_id=' . $manufacturers_details->virtuemart_manufacturer_id, FALSE);
		$name = $manufacturers_details->mf_name;

		// Avoid JavaScript on PDF Output
		if (strtolower(vRequest::getCmd('output')) == "pdf") {
			$mans[] = JHtml::_('link', $link, $name);
		} else {
		
			$mans[] = '<a title="Todos los productos de '.$name.' "href="'.$link .'">'.$name.'</a>';
		}
	}
	echo implode(', ',$mans);
	?>
