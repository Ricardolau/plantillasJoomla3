<?php
/**
*
* Layout for the login
*
* @package	VirtueMart
* @subpackage User
* @author Max Milbers, George Kostopoulos
*
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: cart.php 4431 2011-10-17 grtrustme $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// Los parametros que enviamos al shopfunctionsf::getLoginForm , provoca que podamos utilizar verlos de distinta manera, si no exite le ponemos valores.
if (!isset( $this->show )) {
  $this->show = TRUE;
}
if (!isset( $this->from_cart )){
  $this->from_cart = FALSE;
}
if (!isset( $this->order )) 
  $this->order = FALSE ; {
}


if (empty($this->url)){
	$url = vmURI::getCleanUrl();
} else{
	$url = $this->url;
}
//$url = JRoute::_($url, $this->useXHTML, $this->useSSL);

$user = JFactory::getUser();

if ($this->show and $user->id == 0  ) {
  // Si no está logueado
  JHtml::_('behavior.formvalidation');

	//Extra login stuff, systems like openId and plugins HERE
    if (JPluginHelper::isEnabled('authentication', 'openid')) {
        $lang = JFactory::getLanguage();
        $lang->load('plg_authentication_openid', JPATH_ADMINISTRATOR);
        $langScript = '
//<![CDATA[
'.'var JLanguage = {};' .
                ' JLanguage.WHAT_IS_OPENID = \'' . vmText::_('WHAT_IS_OPENID') . '\';' .
                ' JLanguage.LOGIN_WITH_OPENID = \'' . vmText::_('LOGIN_WITH_OPENID') . '\';' .
                ' JLanguage.NORMAL_LOGIN = \'' . vmText::_('NORMAL_LOGIN') . '\';' .
                ' var comlogin = 1;
//]]>
                ';
		vmJsApi::addJScript('login_openid',$langScript);
        JHtml::_('script', 'openid.js');
    }

    $html = '';
    JPluginHelper::importPlugin('vmpayment');
    $dispatcher = JDispatcher::getInstance();
    $returnValues = $dispatcher->trigger('plgVmDisplayLogin', array($this, &$html, $this->from_cart));

    if (is_array($html)) {
      foreach ($html as $login) {
          echo $login.'<br />';
      }
    } else {
      echo $html;
    }

    //end plugins section

    //anonymous order section
    if ($this->order  ) {
    	?>

      <div class="order-view">
        <!-- Estoy en login - en opcion order -->
        <h2><?php echo vmText::_('COM_VIRTUEMART_ORDER_ANONYMOUS') ?></h2>

        <form action="<?php echo JRoute::_( 'index.php', 1, $this->useSSL); ?>" method="post" name="com-login" >

          <div class="width30 floatleft" id="com-form-order-number">
          	<label for="order_number"><?php echo vmText::_('COM_VIRTUEMART_ORDER_NUMBER') ?></label><br />
          	<input type="text" id="order_number" name="order_number" class="inputbox" size="18" />
          </div>
          <div class="width30 floatleft" id="com-form-order-pass">
          	<label for="order_pass"><?php echo vmText::_('COM_VIRTUEMART_ORDER_PASS') ?></label><br />
          	<input type="text" id="order_pass" name="order_pass" class="inputbox" size="18" />
          </div>
          <div class="width30 floatleft" id="com-form-order-submit">
          	<input type="submit" name="Submitbuton" class="button" value="<?php echo vmText::_('COM_VIRTUEMART_ORDER_BUTTON_VIEW') ?>" />
          </div>
          <div class="clr"></div>
          <input type="hidden" name="option" value="com_virtuemart" />
          <input type="hidden" name="view" value="orders" />
          <input type="hidden" name="layout" value="details" />
          <input type="hidden" name="return" value="" />

        </form>

      </div>

<?php   }
	?>
	<div class="container">
	<?php // XXX style CSS id com-form-login 
	
	?>
    <form id="com-form-login" action="<?php echo $url; ?>" method="post" name="com-login"  class="form-horizontal">
      <fieldset class="form-group userdata">
        <!-- Estoy login en formulario id com-form-login -->
        <div class="col-md-4 text-center">
        <h2 class="LetraRoja" style="margin-top: 20px;font-family: Daydreamer; text-align: center; font-size: 36px;"><?php echo vmText::_('COM_VIRTUEMART_ORDER_CONNECT_FORM'); ?></h2>
        </div>
        <div class="col-md-8">
          <div class="col-md-4 text-center" id="com-form-login-username">
            <label><?php  echo addslashes(vmText::_('COM_VIRTUEMART_USERNAME')); ?></label>
            <input type="text" name="username" class="inputbox" size="18" title="<?php echo vmText::_('COM_VIRTUEMART_USERNAME'); ?>" value="<?php echo vmText::_('COM_VIRTUEMART_USERNAME'); ?>" onblur="if(this.value=='') this.value='<?php echo addslashes(vmText::_('COM_VIRTUEMART_USERNAME')); ?>';" onfocus="if(this.value=='<?php echo addslashes(vmText::_('COM_VIRTUEMART_USERNAME')); ?>') this.value='';" />
            
          </div>
          <div class="col-md-4 text-center" id="com-form-login-password">
            <label><?php  echo addslashes(vmText::_('COM_VIRTUEMART_PASSWORD')); ?></label>
            <input id="modlgn-passwd" type="password" name="password" class="inputbox" size="18" title="<?php echo vmText::_('COM_VIRTUEMART_PASSWORD'); ?>" value="<?php echo vmText::_('COM_VIRTUEMART_PASSWORD'); ?>" onblur="if(this.value=='') this.value='<?php echo addslashes(vmText::_('COM_VIRTUEMART_PASSWORD')); ?>';" onfocus="if(this.value=='<?php echo addslashes(vmText::_('COM_VIRTUEMART_PASSWORD')); ?>') this.value='';" />
             
          </div>

          <div class="col-md-4 text-center" id="com-form-login-remember">
            <input type="submit" name="Submit" class="addtocart-button" value="<?php echo vmText::_('COM_VIRTUEMART_LOGIN') ?>" />
          </div>
        </div>
    </fieldset>
    <fieldset class="form-group userdata">
    <!-- Segun fila donde ponemos link y recuerdame -->
    <div class= "col-md-12">
      <div class="col-md-4 text-center">
        <div class="col-md-6 text-center">
        <?php
				// Ahora mostramos link para registro en caso de que no tenga.
				// Deberíamos comprobar que no esta registrado para mostralo.
				echo '<a  class="normal" href="index.php?option=com_virtuemart&view=user&layout=editaddress">Crea tu cuenta</a>';
		?>
		</div>
		<div class="col-md-6 text-center">
        <?php
				// Ahora mostramos link de volver a pagina anterior. ( continuar comprando )
				echo '<a  class="normal" href="javascript:history.back(1)"> Continuar Comprando</a>'
        ?>
		</div>
      </div>
      <div class= "col-md-8 text-center">
        <div class="col-md-4">
            <a class="normal" href="<?php echo JRoute::_('index.php?option=com_users&view=remind'); ?>" rel="nofollow">
            <?php echo vmText::_('COM_VIRTUEMART_ORDER_FORGOT_YOUR_USERNAME'); ?></a>
        </div>
        <div class="col-md-4">
          <a class="normal" href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>" rel="nofollow">
          <?php echo vmText::_('COM_VIRTUEMART_ORDER_FORGOT_YOUR_PASSWORD'); ?></a>
        </div>
        <div class="col-md-4">
          <?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
            <label for="remember"><?php echo $remember_me = vmText::_('JGLOBAL_REMEMBER_ME') ?></label>
            <input type="checkbox" id="remember" name="remember" class="inputbox" value="yes" />
            <?php endif; ?>
        </div>
      </div>
    </div>
    </fieldset>
      <input type="hidden" name="task" value="user.login" />
      <input type="hidden" name="option" value="com_users" />
      <input type="hidden" name="return" value="<?php echo base64_encode($url) ?>" />
      <?php echo JHtml::_('form.token'); ?>
    </form>
    </div>
    
    

<?php  
} 
?>

