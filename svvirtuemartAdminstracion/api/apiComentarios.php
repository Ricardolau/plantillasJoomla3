<?php
/**
*
* Description
*
* @package	VirtueMart
* @subpackage
* @author RolandD, Max Milbers
* @link https://virtuemart.net
* @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: ratings.php 9413 2017-01-04 17:20:58Z Milbo $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

if (!class_exists ('VmModel')){
	require(VMPATH_ADMIN . DS . 'helpers' . DS . 'vmmodel.php');
}

/**
 * Model for VirtueMart Products
 *
 * @package VirtueMart
 * @author RolandD
 */
class apiComentarios {

	
	/**
	 * @author Max Milbers
	 * @param $virtuemart_product_id
	 * @return null
	 */
	function getReviews($virtuemart_vendor_id = 0, $num_reviews = false){

	    $db = JFactory::getDBO(  );
		static $reviews = array();

			$jKind = 'INNER';
			//~ $jKind = 'LEFT';
			
			//$select = '`u`.*,`pr`.*,`l`.`product_name`,`rv`.`vote`, IFNULL(`u`.`name`, `pr`.`customer`) AS customer, `pr`.`published`';
			$tables = ' FROM `#__virtuemart_rating_reviews` AS `pr`
			'.$jKind.' JOIN `#__virtuemart_products_'.VmConfig::$vmlang.'` AS `l` ON `l`.`virtuemart_product_id` = `pr`.`virtuemart_product_id` ';
			//~ if(!empty($virtuemart_vendor_id)){
				//~ $tables .= 'LEFT JOIN `#__virtuemart_products` AS `p` ON `p`.`virtuemart_product_id` = `pr`.`virtuemart_product_id` ';
			//~ }
			//~ $tables .= self::$_jTables;
			/*$tables .= 'LEFT JOIN `#__virtuemart_rating_votes` AS `rv` on
			(`pr`.`virtuemart_rating_vote_id` IS NOT NULL AND `rv`.`virtuemart_rating_vote_id`=`pr`.`virtuemart_rating_vote_id` ) XOR
			(`pr`.`virtuemart_rating_vote_id` IS NULL AND (`rv`.`virtuemart_product_id`=`pr`.`virtuemart_product_id` and `rv`.`created_by`=`pr`.`created_by`) )';
		$tables .= 'LEFT JOIN `#__users` AS `u`	ON `pr`.`created_by` = `u`.`id`';
*/
			//~ $whereString = ' WHERE  `pr`.`virtuemart_product_id` = "'.$virtuemart_product_id.'" ';
			//~ if(!empty($virtuemart_vendor_id)){
				//~ $whereString .= ' AND `p`.virtuemart_vendor_id="'.$virtuemart_vendor_id.'"';
			//~ }
			//~ self::$_select = self::getSelect();
			$query = 'SELECT * '.$tables;
			$db->setQuery( $query );
            $resultados = $db->loadObjectList();
			$items = array();
			$i= 0;
			foreach ($resultados as $resultado){
				//~ $items = $resultado;
				$items[$i]['id']			 = $resultado->virtuemart_rating_review_id;
				$items[$i]['id_product']	 = $resultado->virtuemart_product_id;
				$items[$i]['product_name']	 = $resultado->product_name;
				$items[$i]['published']		 = $resultado->published;
				$items[$i]['created_by'] = $resultado->created_by;  // Id de quien comentó.
				$items[$i]['created_on'] = $resultado->created_on;
				$items[$i]['comment'] = $resultado->comment;
				// Ahora tengo que buscar el nombre del que comento.
				$queryQuien = "Select name FROM #__virtuemart_userinfos where `virtuemart_user_id`=".$items[$i]['created_by'];
				$db->setQuery( $queryQuien );
				$items[$i]['name'] = $db->loadResult();

				
				
				$i++;
			}
			
			$reviews['consulta'] = $queryQuien ;
			$reviews['resultados'] = $items ;

		


     	return $reviews;
    }


	/**
	 * @author Max Milbers
	 * @param $cids
	 * @return mixed@
	 */
	function getReview($cids, $new = false){

		if($new){
			$t = $this->getTable('products');
			$t->load($cids);
			$t->customer = '';
			$t->vote = '';
			$t->comment = '';
			$t->virtuemart_rating_review_id = null;
			$t->virtuemart_rating_vote_id = null;
			$t->created_by_alias = '';
			return $t;
		} else {
			self::$_select = self::getSelect();
			$q = 'SELECT '.self::$_select.' FROM `#__virtuemart_rating_reviews` AS `pr`
		LEFT JOIN `#__virtuemart_products_'.VmConfig::$vmlang.'` AS `l` ON `l`.`virtuemart_product_id` = `pr`.`virtuemart_product_id`';
		$q .= self::$_jTables;
 /*    	ON `p`.`virtuemart_product_id` = `pr`.`virtuemart_product_id`
		LEFT JOIN `#__virtuemart_rating_votes` as `rv` on `rv`.`virtuemart_product_id`=`pr`.`virtuemart_product_id` and `rv`.`created_by`=`pr`.`created_by`
		LEFT JOIN `#__users` AS `u`
     	ON `pr`.`created_by` = `u`.`id`*/
		$q .= 'WHERE virtuemart_rating_review_id="'.(int)$cids[0].'" ' ;


			$db = JFactory::getDBO();
			$db->setQuery($q);
			$r = $db->loadObject();
			if(!$r){
				vmdebug('getReview',$db->getQuery());
			}
			return $r;
		}

    }


    /**
     * gets a rating by a product id
     *
     * @author Max Milbers
     * @param int $product_id
     */

   


    function getProductReviewForUser($product_id,$userId=0){
   		if(empty($userId)){
			$user = JFactory::getUser();
			$userId = $user->id;
    	}
		if(!empty($userId)){
			$q = 'SELECT * FROM `#__virtuemart_rating_reviews` WHERE `virtuemart_product_id` = "'.(int)$product_id.'" AND `created_by` = "'.(int)$userId.'" ';
			$db = JFactory::getDBO();
			$db->setQuery($q);
			return $db->loadObject();
		} else {
			return false;
		}

    }

	/**
	 * @deprecated
	 */
	function getReviewByProduct($product_id,$userId=0){
		return $this->getProductReviewForUser($product_id,$userId);
	}

    /**
     * gets a reviews by a product id
     *
     * @author Max Milbers
     * @param int $product_id
     */

	function getReviewsByProduct($product_id){
   		if(empty($userId)){
			$user = JFactory::getUser();
			$userId = $user->id;
    	}
		$q = 'SELECT * FROM `#__virtuemart_rating_reviews` WHERE `virtuemart_product_id` = "'.(int)$product_id.'" ';
		$db = JFactory::getDBO();
		$db->setQuery($q);
		return $db->loadObjectList();
    }

    

    /**
	* Returns the number of reviews assigned to a product
	*
	* @author RolandD
	* @param int $pid Product ID
	* @return int
	*/
	public function countReviewsForProduct($pid) {
		$db = JFactory::getDBO();
		$q = "SELECT COUNT(*) AS total
			FROM #__virtuemart_rating_reviews
			WHERE virtuemart_product_id=".(int)$pid;
		$db->setQuery($q);
		$reviews = $db->loadResult();
		return $reviews;
	}

	public function showReview($product_id){

		return $this->show($product_id, VmConfig::get('showReviewFor','all'));
	}

	
	public function allowReview($product_id){
		return $this->show($product_id, VmConfig::get('reviewMode','bought'));
	}

	
	/**
	 * Decides if the rating/review should be shown on the FE
	 * @author Max Milbers
	 */
	private function show($product_id, $show){

		//dont show
		if($show == 'none'){
			return false;
		}
		//show all
		else {
			if ($show == 'all') {
				return true;
			}
			//show only registered
			else {
				if ($show == 'registered') {
					$user = JFactory::getUser ();
					return !empty($user->id);
				}
				//show only registered && who bought the product
				else {
					if ($show == 'bought') {

						if (empty($product_id)) {
							return false;
						}

						if (isset($this->_productBought[$product_id])) {
							return $this->_productBought[$product_id];
						}

						if(!class_exists('vmCrypt')){
							require(VMPATH_ADMIN.DS.'helpers'.DS.'vmcrypt.php');
						}
						$key = vmCrypt::encrypt('productBought'.$product_id);
						$count = JFactory::getApplication()->input->cookie->getString($key, false);
						if($count){
							//check, somehow broken, atm
							$v = vmCrypt::encrypt($key);
							if($v!=$count){
								$count = false;
							}
						}

						if(!$count){
							$user = JFactory::getUser ();
							if(empty($user->id)) return false;

							$rr_os=VmConfig::get('rr_os',array('C'));
							if(!is_array($rr_os)) $rr_os = array($rr_os);

							$db = JFactory::getDBO ();
							$q = 'SELECT COUNT(*) as total FROM `#__virtuemart_orders` AS o LEFT JOIN `#__virtuemart_order_items` AS oi ';
							$q .= 'ON `o`.`virtuemart_order_id` = `oi`.`virtuemart_order_id` ';
							$q .= 'WHERE o.virtuemart_user_id = "' . $user->id . '" AND oi.virtuemart_product_id = "' . $product_id . '" ';
							$q .= 'AND o.order_status IN (\'' . implode("','",$rr_os). '\') ';

							$db->setQuery ($q);
							$count = $db->loadResult ();
						}

						if ($count) {
							$this->_productBought[$product_id] = true;
							return true;
						}
						else {
							$this->_productBought[$product_id] = false;
							return false;
						}
					}
				}
			}
		}
	}
}
// pure php no closing tag
