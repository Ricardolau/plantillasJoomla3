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
<div class="registration-complete<?php echo $this->pageclass_sfx;?>">
	<?php if ($this->params->get('show_page_heading')) : ?>
	<h1>
		<?php echo ' REGISTRO CON EXITO'; ?>
	</h1>
	<pre>
	<?php echo ' Texto que definamos , teniendo en cuenta que no está logueado, y que tiene que activar su cuenta con el email';?>
	</pre>
	<?php endif; ?>
</div>
