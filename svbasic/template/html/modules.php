<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.beez3
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;


function modChrome_carpinteroForm($module, &$params, &$attribs)
{
	$headerLevel = isset($attribs['headerLevel']) ? (int) $attribs['headerLevel'] : 3;
	if (!empty ($module->content)) { ?>
<div class="1moduletable<?php echo htmlspecialchars($params->get('moduleclass_sfx')); ?>">
<?php if ($module->showtitle) { ?> 
<h3><?php echo $module->title; ?></h3>
<?php }; ?> 
<?php echo $module->content; ?>
</div>
<?php };
}


function modChrome_BS($module, &$params, &$attribs)
{
	$headerLevel = isset($attribs['headerLevel']) ? (int) $attribs['headerLevel'] : 3;
	if (!empty ($module->content)) { ?>
	<div class="moduletable<?php echo htmlspecialchars($params->get('moduleclass_sfx')); ?>">
	<?php if ($module->showtitle) { ?> 
	<h3><?php echo $module->title; ?></h3>
	<?php }; ?> 
	<?php 
	
	echo $module->content; 
	?>
	</div>
<?php };
}





