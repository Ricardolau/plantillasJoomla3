<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidator');

?>
<!-- Estoy en registro /default -->
<script language="javascript">
function myValidator(f, t) {
  f.task.value = t; //this is a method to set the task of the form on the fTask.
  if (document.formvalidator.isValid(f)) {
  f.submit();
  return true;
  } else {
  var msg = '<?php echo addslashes (JText::_ ('COM_VIRTUEMART_USER_FORM_MISSING_REQUIRED_JS')); ?>';
  alert(msg + ' ');
  }
  return false;
}
 
function callValidatorForRegister() {
	document.getElementById('jform_name').value = document.getElementById('jform_username').value 
	document.getElementById('jform_email2').value = document.getElementById('jform_email1').value 

   return myValidator(member-registration, true);
 
}
</script>
	<?php if ($this->params->get('show_page_heading')) : 
		// Presentamos el item menu
	?>
		<div class="page-header corona">
			<div class="CategoriaVirtuemart">
				<h1><?php echo $this->escape($this->params->get('page_heading'));?></h1>
			</div>
		</div>
	<?php endif; ?>
<div class="registration col-md-6 col-md-offset-3 <?php echo $this->pageclass_sfx?>">

	<form  name="member-registration" id="member-registration" action="<?php echo JRoute::_('index.php?option=com_users&task=registration.register'); ?>" method="post" class="form-validate" enctype="multipart/form-data">
		<?php // Iterate through the form fieldsets and display each one. ?>
		<fieldset>
			<legend><?php echo JText::_('COM_USERS_REGISTRATION_DEFAULT_LABEL');?></legend>
			<div class="form-group control-group">
				<div class="control-label">
				<span class="spacer">
					<span class="before"></span>
					<span class="text">
						<label id="jform_spacer-lbl" class="">
						<?php echo JText::_('COM_USERS_REGISTER_REQUIRED');?>
						</label>
					</span>
					<span class="after"></span>
				</span>
				</div>
				<div class="controls"></div>
			</div>
																		
																				
			<div class="form-group control-group">
				<div class="control-label">
					<label data-original-title="<?php echo JText::_('COM_USERS_DESIRED_USERNAME');?>" 
					id="jform_username-lbl" for="jform_username" class="hasTooltip required" title="">
					<?php echo JText::_('COM_USERS_REGISTER_USERNAME_LABEL');?>
					<span class="star">&nbsp;*</span>
					</label>
				</div>
				<div class="controls">
					<input name="jform[username]" id="jform_username" 
					value="" class="validate-username required" size="30" required="required" aria-required="true" type="text">
				</div>
			</div>
															
																
			<div class="form-group control-group">
				<div class="control-label">
					<label data-original-title="<?php echo JText::_('COM_USERS_REGISTER_EMAIL1_DESC');?>" id="jform_email1-lbl" 
					for="jform_email1" class="hasTooltip required" title="">
					<?php echo JText::_('COM_USERS_REGISTER_EMAIL1_LABEL');?>
					<span class="star">&nbsp;*</span>
					</label>
				</div>
				<div class="controls">
					<input name="jform[email1]" class="validate-email required" id="jform_email1" 
					value="" size="30" required="required" aria-required="true" type="email">
				</div>
			</div>
																		
			
			<div class="form-group control-group">
				<div class="control-label">
					<label data-original-title="<?php echo JText::_('COM_USERS_DESIRED_PASSWORD');?>" 
					id="jform_password1-lbl" for="jform_password1" class="hasTooltip required" title="">
					<?php echo JText::_('COM_USERS_PROFILE_PASSWORD1_LABEL');?>
					<span class="star">&nbsp;*</span>
					</label>
				</div>
				<div class="controls">
					<input name="jform[password1]" id="jform_password1" 
					value="" autocomplete="off" class="validate-password required" size="30" maxlength="99" required="required" aria-required="true" type="password">							
				</div>
			</div>
			<div class="form-group control-group">
				<div class="control-label">
					<label data-original-title="<?php echo JText::_('COM_USERS_PROFILE_PASSWORD2_DESC');?>"  id="jform_password2-lbl" 
					for="jform_password2" class="hasTooltip required" title="">
					<?php echo JText::_('COM_USERS_REGISTER_PASSWORD2_LABEL');?>
					<span class="star">&nbsp;*</span>
					</label>														</div>
				<div class="controls">
					<input name="jform[password2]" id="jform_password2" value="" autocomplete="off" class="validate-password required" size="30" maxlength="99" required="required" aria-required="true" type="password">
				</div>
			</div>																	
			
															
		<?php foreach ($this->form->getFieldsets() as $fieldset): ?>
			<?php $fields = $this->form->getFieldset($fieldset->name);?>
			<?php if (count($fields)):?>
				<?php // If the fieldset has a label set, display it as the legend. ?>
				<?php if (isset($fieldset->label)): ?>
					<legend></legend>
				<?php endif;?>
				<?php // Iterate through the fields in the set and display them. ?>
				<?php foreach ($fields as $field) : ?>
					<?php // If the field is hidden, just display the input. ?>
					
					<?php if ($field->hidden): ?>
						<?php echo $field->input;?>

					<?php endif;?>
				<?php endforeach;?>

			<?php endif;?>
		<?php endforeach;?>
		</fieldset>

		<div class="control-group">
			<div class="controls ">
				<button type="submit" class="btn btn-primary validate" onclick="javascript:callValidatorForRegister()"><?php echo JText::_('JREGISTER');?></button>
				<a class="btn" href="<?php echo JRoute::_('');?>" title="<?php echo JText::_('JCANCEL');?>"><?php echo JText::_('JCANCEL');?></a>
				<input type="hidden" name="option" value="com_users" />
				<input type="hidden" name="task" value="registration.register" />
				<input type="hidden" name="jform[name]" id="jform_name" value="">
				<input type="hidden" name="jform[email2]" id="jform_email2" value="">							
				
			</div>
		</div>
		<?php echo JHtml::_('form.token');?>
	</form>
</div>
