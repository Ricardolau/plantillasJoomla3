<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_contact
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Marker_class: Class based on the selection of text, none, or icons
 * jicon-text, jicon-none, jicon-icon
 */
?>
<div class="contact-address" itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
	<?php if (($this->params->get('address_check') > 0) &&
		($this->contact->address || $this->contact->suburb  || $this->contact->state || $this->contact->country || $this->contact->postcode)) : ?>
	
			<div class="<?php echo $this->params->get('marker_class'); ?>">
				<?php echo $this->params->get('marker_address'); ?>
			</div>
	

		<?php if ($this->contact->address && $this->params->get('show_street_address')) : ?>
	
				<div itemprop="streetAddress">
					<?php echo nl2br($this->contact->address); ?>
					
				</div>
	
		<?php endif; ?>

		<?php if ($this->contact->suburb && $this->params->get('show_suburb')) : ?>
	
				<div itemprop="addressLocality">
					<?php echo $this->contact->suburb; ?>
				</div>
	
		<?php endif; ?>
		<?php if ($this->contact->state && $this->params->get('show_state')) : ?>
	
				<div itemprop="addressRegion">
					<?php echo $this->contact->state; ?>
				</div>
	
		<?php endif; ?>
		<?php if ($this->contact->postcode && $this->params->get('show_postcode')) : ?>
	
				<div itemprop="postalCode">
					<?php echo $this->contact->postcode; ?>
				</div>
	
		<?php endif; ?>
		<?php if ($this->contact->country && $this->params->get('show_country')) : ?>
	
			<div itemprop="addressCountry">
				<?php echo $this->contact->country; ?>
			</div>
	
		<?php endif; ?>
	<?php endif; ?>

<?php if ($this->contact->email_to && $this->params->get('show_email')) : ?>
	
		<div itemprop="email">
			<?php echo nl2br($this->params->get('marker_email')); ?>
		</div>
	
	
		<div>
			<?php echo $this->contact->email_to; ?>
		</div>
	
<?php endif; ?>

<?php if ($this->contact->telephone && $this->params->get('show_telephone')) : ?>
	
		<div>
			<?php echo $this->params->get('marker_telephone'); ?>
		</div>
	
	
		<div class="contact-telephone" itemprop="telephone">
			<?php echo nl2br($this->contact->telephone); ?>
		</div>
	
<?php endif; ?>
<?php if ($this->contact->fax && $this->params->get('show_fax')) : ?>
	
		<div class="<?php echo $this->params->get('marker_class'); ?>">
			<?php echo $this->params->get('marker_fax'); ?>
		</div>
	
	
		<div class="contact-fax" itemprop="faxNumber">
		<?php echo nl2br($this->contact->fax); ?>
		</div>
	
<?php endif; ?>
<?php if ($this->contact->mobile && $this->params->get('show_mobile')) :?>
	
		<div class="<?php echo $this->params->get('marker_class'); ?>">
			<?php echo $this->params->get('marker_mobile'); ?>
		</div>
	
	
		<span itemprop="telephone">
			<?php echo nl2br($this->contact->mobile); ?>
		</span>
	
<?php endif; ?>
<?php if ($this->contact->webpage && $this->params->get('show_webpage')) : ?>
		<div class="contact-webpage">
			<a href="<?php echo $this->contact->webpage; ?>" target="_blank" itemprop="url">
			<?php echo JStringPunycode::urlToUTF8($this->contact->webpage); ?></a>
		</div>
<?php endif; ?>
</div>
