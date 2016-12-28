<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_login
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

require_once JPATH_SITE . '/components/com_users/helpers/route.php';

JHtml::_('behavior.keepalive');
JHtml::_('bootstrap.tooltip');

?>
<!-- Estoy default -->
<div>
	<a href="<?php echo JRoute::_('index.php?option=com_users&view=registration&Itemid=' . UsersHelperRoute::getRegistrationRoute()); ?>">
	<?php echo JText::_('MOD_LOGIN_REGISTER'); ?></a>
	<img src="images/iconos/usuario.png" alt="usuario"/>
	<a style="color:#bbb8b3 ;" href="index.php/mi-cuenta"> Mi cuenta</a>
</div>
