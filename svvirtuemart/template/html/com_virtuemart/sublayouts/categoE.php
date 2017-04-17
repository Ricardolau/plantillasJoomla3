<?php
/**
*
* Shows the products/categories of a category
*
* @package	VirtueMart
* @subpackage
* @author Max Milbers
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2014 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
 * @version $Id: default.php 6104 2012-06-13 14:15:29Z alatak $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

$categories = $viewData['categoE'];


if ($categories) {

// Category and Columns Counter
$iCol = 1;
$iCategory = 1;

// Calculating Categories Per Row

// Separator
}
?>
<!-- Entro layouts CategoE plantilla -->
<div class="category-view">

	<div>
		<div class="CategoriasEtiqueta col-md-12">
		<?php 

	// Start the Output
		foreach ( $categories as $category ) {

		   // Category Link
			$caturl = JRoute::_ ( 'index.php?option=com_virtuemart&view=category&virtuemart_category_id=' . $category->virtuemart_category_id , FALSE);

			  // Show Category ?>
			<h2>
			  <a href="<?php echo $caturl ?>" title="<?php echo $category->category_name ?>">
			  <?php echo $category->category_name ?>
			  </a>
			</h2>
		
			 <?php
			$iCategory ++;

		}?>
		</div>
	</div>
</div>
