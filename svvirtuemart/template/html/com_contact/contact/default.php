<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_contact
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
/*  Aunque selecciones en configuracion de componente formato Slider o tab, este anula
 * ya que el cliente no los solicita y lo presentamos en plano.
 * 
 * */
defined('_JEXEC') or die;

$cparams = JComponentHelper::getParams('com_media');
$tparams = $this->params;
jimport('joomla.html.html.bootstrap');
?>
<?php // Comprobamos que el contacto no este despublicado
if ($this->item->published == 0) : ?>
	<span class="label label-warning"><?php echo JText::_('JUNPUBLISHED'); ?></span>
<?php endif; ?>


<!-- Estoy template html/contact/contact -->
<div class="contact <?php echo $this->pageclass_sfx?>" itemscope itemtype="https://schema.org/Person">
	<?php 	// Insertamos titula de item de la pagina , si en configuracion de item menu lo indicamos...
	if ($tparams->get('show_page_heading')) : ?>
		<h2 class="LetraVerde">
			<?php echo $this->escape($tparams->get('page_heading')); ?>
		</h2>
	<?php
	endif; ?>

	<?php if ($this->contact->name && $tparams->get('show_name')) : ?>
		<div class="page-header">
			<h2 class="LetraVerde">
				<?php if ($this->item->published == 0) : ?>
					<span class="label label-warning"><?php echo JText::_('JUNPUBLISHED'); ?></span>
				<?php endif; ?>
				<span class="contact-name" itemprop="name"><?php echo $this->contact->name; ?></span>
			</h2>
		</div>
	<?php endif; ?>

	<?php $show_contact_category = $tparams->get('show_contact_category'); ?>

	<?php if ($show_contact_category == 'show_no_link') : ?>
		<h3>
			<span class="contact-category"><?php echo $this->contact->category_title; ?></span>
		</h3>
	<?php elseif ($show_contact_category == 'show_with_link') : ?>
		<?php $contactLink = ContactHelperRoute::getCategoryRoute($this->contact->catid); ?>
		<h3>
			<span class="contact-category"><a href="<?php echo $contactLink; ?>">
				<?php echo $this->escape($this->contact->category_title); ?></a>
			</span>
		</h3>
	<?php endif; ?>

	<?php echo $this->item->event->afterDisplayTitle; ?>

	<?php if ($tparams->get('show_contact_list') && count($this->contacts) > 1) : ?>
		<form action="#" method="get" name="selectForm" id="selectForm">
			<?php echo JText::_('COM_CONTACT_SELECT_CONTACT'); ?>
			<?php echo JHtml::_('select.genericlist', $this->contacts, 'id', 'class="inputbox" onchange="document.location.href = this.value"', 'link', 'name', $this->contact->link); ?>
		</form>
	<?php endif; ?>

	<?php if ($tparams->get('show_tags', 1) && !empty($this->item->tags->itemTags)) : ?>
		<?php $this->item->tagLayout = new JLayoutFile('joomla.content.tags'); ?>
		<?php echo $this->item->tagLayout->render($this->item->tags->itemTags); ?>
	<?php endif; ?>

	<?php echo $this->item->event->beforeDisplayContent; ?>
	
	<?php //$presentation_style = $tparams->get('presentation_style'); ?>
	<!-- Formulario de contacto de Petideco  -->
	<div class ="col-md-6 formulario-contacto">

	<?php if ($tparams->get('show_email_form') && ($this->contact->email_to || $this->contact->user_id)) : ?>
		
			<?php echo '<p>' .JText::_('TPL_SVVIRTUEMART_CONTACT_ANTEFORM') . '</p>';
			 ?>
		
		<?php echo $this->loadTemplate('form'); ?>

		
	<?php endif; ?>
	</div>
	
	<!-- Presentamos informacion de contacto -->
	<div class ="col-md-6 datos-contacto">
		<?php // Mostramos misc -> Informacion general del contacto. 
		if ($this->contact->misc && $tparams->get('show_misc')) : 
		?>
			<?php // echo '<h3>' . JText::_('COM_CONTACT_OTHER_INFORMATION') . '</h3>'; ?>
				<div class="contact-miscinfo">
					<?php echo $this->contact->misc; ?>
				</div>
	<?php endif; ?>
		<?php // echo '<h3>' . JText::_('COM_CONTACT_DETAILS') . '</h3>'; ?>
		
		<?php if ($this->contact->image && $tparams->get('show_image')) : ?>
			<div class="imagen-contacto">
				<?php echo JHtml::_('image', $this->contact->image, $this->contact->name, array('align' => 'middle', 'itemprop' => 'image')); ?>
			</div>
		<?php endif; ?>

		<?php if ($this->contact->con_position && $tparams->get('show_position')) : ?>
				<div itemprop="jobTitle">
					<strong><?php echo $this->contact->con_position; ?></strong>
				</div>
		<?php endif; ?>
		
		<?php echo $this->loadTemplate('address'); ?>

		<?php if ($tparams->get('allow_vcard')) : ?>
			<?php echo JText::_('COM_CONTACT_DOWNLOAD_INFORMATION_AS'); ?>
			<a href="<?php echo JRoute::_('index.php?option=com_contact&amp;view=contact&amp;id=' . $this->contact->id . '&amp;format=vcf'); ?>">
			<?php echo JText::_('COM_CONTACT_VCARD'); ?></a>
		<?php endif; ?>

		
	</div>
	

	<?php if ($tparams->get('show_links')) : ?>
		<?php echo $this->loadTemplate('links'); ?>
	<?php endif; ?>

	<?php if ($tparams->get('show_articles') && $this->contact->user_id && $this->contact->articles) : ?>
		
			<?php echo '<h3>' . JText::_('JGLOBAL_ARTICLES') . '</h3>'; ?>
		
			<?php echo $this->loadTemplate('articles'); ?>

	<?php endif; ?>

	<?php if ($tparams->get('show_profile') && $this->contact->user_id && JPluginHelper::isEnabled('user', 'profile')) : ?>
			<?php echo '<h3>' . JText::_('COM_CONTACT_PROFILE') . '</h3>'; ?>
			<?php echo $this->loadTemplate('profile'); ?>
	<?php endif; ?>

	

	<?php echo $this->item->event->afterDisplayContent; ?>
</div>
