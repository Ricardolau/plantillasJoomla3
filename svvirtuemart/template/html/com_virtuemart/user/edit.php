<?php
/**
*
* Modify user form view
*
* @package	VirtueMart
* @subpackage User
* @author Oscar van Eijk
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: edit.php 9196 2016-03-20 15:10:12Z Milbo $
* 
* LLEGA AQUI:
* Desde item de menu.... 
* No LLEGA DESDE CART nunca...
* 
* 
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// Implement Joomla's form validation
JHtml::_('behavior.formvalidation');
JHtml::stylesheet('vmpanels.css', JURI::root().'components/com_virtuemart/assets/css/'); // VM_THEMEURL

// Tengo que identificar que voy hacer, es decir si voy mostrar editar , registro nuevo o si estoy editando direccion...
//~ $doc = JFactory::getDocument();
if ($_GET) {
		//~ echo '<pre>';
		//~ print_r($_GET);
		//~ echo '</pre>';
		if ($_GET['Itemid'] == 329) {
			// En el momento que cambiemos de item deja de fucionar... 
			$Itemdemenu= "Direcciones";

		} else {
			$Itemdemenu= "Detalles"; 
		}
}
//~ $app = JFactory::getApplication();
//~ $menu = $app->getMenu();
//~ $menuActivo= $menu->getActive();
//~ 
$titulopagina = $this->page_title; // Detalle cuenta ... por defecto...


?>
<?php //vmJsApi::vmValidator($this->userDetails->JUser->guest,$this->userFields); ?>
<!-- Estoy en template virtuemart/user/edit -->	
<h1><?php echo $titulopagina; ?></h1>
<div class="NuevoComprador text-center">
    <!-- Cargamos formulario de login ( cart/edit) -->
    <?php 
    // Mostramos formulario o hola nombre usuario si esta logueado.
    echo shopFunctionsF::getLoginForm(false); 
    ?>
</div>
<div class="registration col-md-6 col-md-offset-3">
    <?php 
    if ($this->userDetails->JUser->get('id') and $Itemdemenu == "Direcciones" ) {
		// Solo mostramos si es itemd = 329 esto falla, si no es el mismo item... que Direcciones...
	?>
	  <!-- Mostramos lista direcciones --> 
	  <div class="col-md-12">
	  <?php
	  echo $this->loadTemplate('address_addshipto');
	  ?>
	  </div>
	  <?php
	}
	
	
	
	
	
	
	
	
    if($this->userDetails->virtuemart_user_id==0) 
    {
		// Mostramos pregunta si ¿ Ya estás registrato ?
		echo '<h2>'.vmText::_('COM_VIRTUEMART_YOUR_ACCOUNT_REG').'</h2>';
    }
    ?>
    <form method="post" id="adminForm" name="userForm" action="<?php echo JRoute::_('index.php?option=com_virtuemart&view=user',$this->useXHTML,$this->useSSL) ?>" class="form-validate">
	<?php 
	// Loading Templates in Tabs
	if($this->userDetails->virtuemart_user_id!=0) 
	{
    	// Me imagino que entra solo cuando esta logueado
    	?>
    	<!-- Solo si estamos logueado -->
    	<?php
	    $tabarray = array();
	    $tabarray['shopper'] = 'COM_VIRTUEMART_SHOPPER_FORM_LBL';
	    ?>

	    <?php
	    if($this->userDetails->user_is_vendor){ ?>
	    <!-- Mostamos Opciones vendedor-->
		<div class="alert alert-info">
		    <h4> Eres vendedor </h4>
		    <ul>
		    <?php
			if(!empty($this->manage_link)) {
			    echo '<li>';
			    echo $this->manage_link;
			    echo '</li>';
			}
			if(!empty($this->add_product_link)) {
			    echo '<li>';
			    echo $this->add_product_link;
			    echo '</li>';
			}
		    ?>
		    </ul>
		    <p> Recuerda que esta tienda es multivendedor ( aunque no este activa), por ello puedes tener datos como vendedor y comprador a la vez.</p>
		    <!-- Mostramos Button de vendedor -->
		    <div class="buttonBar-right">
			<button class="button" type="submit" onclick="javascript:return callValidatorForRegister(userForm, true);" ><?php echo $this->button_lbl ?></button>
			<button class="button" type="reset" onclick="window.location.href='<?php echo JRoute::_('index.php?option=com_virtuemart&view=user&task=cancel', FALSE); ?>'" ><?php echo vmText::_('COM_VIRTUEMART_CANCEL'); ?></button>
		    </div>
		</div>
		
	    <?php
		$tabarray['vendor'] = 'COM_VIRTUEMART_VENDOR';

	    } ?>
	    <?php
	    if (!empty($this->shipto)) {
		    $tabarray['shipto'] = 'COM_VIRTUEMART_USER_FORM_ADD_SHIPTO_LBL';
	    }
	    if (($_ordcnt = count($this->orderlist)) > 0) {
		    $tabarray['orderlist'] = 'COM_VIRTUEMART_YOUR_ORDERS';
	    }
	    // Cargamos los template en tabs
	    //~ shopFunctionsF::buildTabs ( $this, $tabarray);
	    ?>
	    <!-- Vamos a edit_shopper -->
	    <?php
	    echo $this->loadTemplate ( 'shopper' );

	} else {?>
	<!-- Vamos entrar en template shopper -->
	    <?php
		echo $this->loadTemplate ( 'shopper' );
		echo $this->captcha;
		// captcha addition
		/*if(VmConfig::get ('reg_captcha')){
			JHTML::_('behavior.framework');
			JPluginHelper::importPlugin('captcha');
			$dispatcher = JDispatcher::getInstance(); $dispatcher->trigger('onInit','dynamic_recaptcha_1');
			?>
			<div id="dynamic_recaptcha_1"></div>
			<?php
		}*/
	 }
	// end of captcha addition
	?>
	
	<?php /*
	if ($this->userDetails->JUser->get('id') ) {?>
	  <!-- Mostramos lista direcciones --> 
	  <div class="col-md-12">
	  <?php
	  echo $this->loadTemplate('address_addshipto');
	  ?>
	  </div>
	  <?php
	}
	

	*/?>
	
	
	<input type="hidden" name="option" value="com_virtuemart" />
	<input type="hidden" name="controller" value="user" />
	<?php echo JHtml::_( 'form.token' ); ?>
    </form>



</div>

