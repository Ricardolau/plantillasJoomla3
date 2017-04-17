<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
	<?php if ($this->params->get('show_page_heading')) : 
		// Entra aquí cuando accedemos a Mi Cuenta y nos logueamos, 
		// por lo que de momento mostramos texto plano
		// que tiene que ser una variables de plantilla.
	?>
		<div class="page-header corona">
			<div class="CategoriaVirtuemart">
				<h1><?php echo ' Deseas de loguear - Gracias por la visita '?></h1>
			</div>
		</div>
	<?php endif; ?>

	<?php if (($this->params->get('logoutdescription_show') == 1 && str_replace(' ', '', $this->params->get('logout_description')) != '')|| $this->params->get('logout_image') != '') : ?>
	<div class="logout-description">
	<?php endif; ?>

		<?php if ($this->params->get('logoutdescription_show') == 1) : ?>
			<?php echo $this->params->get('logout_description'); ?>
		<?php endif; ?>

		<?php if (($this->params->get('logout_image') != '')) :?>
			<img src="<?php echo $this->escape($this->params->get('logout_image')); ?>" class="thumbnail pull-right logout-image" alt="<?php echo JTEXT::_('COM_USER_LOGOUT_IMAGE_ALT')?>"/>
		<?php endif; ?>

	<?php if (($this->params->get('logoutdescription_show') == 1 && str_replace(' ', '', $this->params->get('logout_description')) != '')|| $this->params->get('logout_image') != '') : ?>
	</div>
	<?php endif; ?>
<div class="logout col-md-6 col-md-offset-3 <?php echo $this->pageclass_sfx?>">

	<form action="<?php echo JRoute::_('index.php?option=com_users&task=user.logout'); ?>" method="post" class="form-group">
		<div class="control-group">
			<div class="controls">
				<button type="submit" class="btn btn-primary"><span class="icon-arrow-left icon-white"></span> <?php echo JText::_('JLOGOUT'); ?></button>
			</div>
		</div>
		<input type="hidden" name="return" value="<?php echo base64_encode($this->params->get('logout_redirect_url', $this->form->getValue('return'))); ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</form>
</div>
