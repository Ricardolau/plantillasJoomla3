<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * 
 * Aquí llegamos cuando se genera un advertencia de sistema. 
 * la hace desde .
 * Tipo de advertencias:
 *  		alert-warning ( advertencia )
 * 			alert-error
 * 
 * El comportamiento no siempre se el mismo, ya influyen varios motivos, uno por ejemplo es que no
 * le indique el typo error.
 * Por ejemplo:
 * En formulario de registros no se ejecuta desde el servidor , sino desde el cliente y no le indica el tipo error.
 * 
 * 
 * 
 * 
 * 
 */

defined('_JEXEC') or die;

$msgList = $displayData['msgList'];

?>
<?php if (is_array($msgList) && !empty($msgList)) : ?>
	<div id="system-message-container">
	<?php	// Pruebo a sacar información de  $displayData pero solo muestra la información que 
						// trae $msgList y poco más.
						// 
						// Con la variable $type debería indicar el tipo advertencia, ver tipo adevertencias, en principio de este fichero.
						//
						// El problema surge cuando no indica el typo de advertencia, 
						// como sucede en virtuemart cuando añade un articulo.
						// para ello utilizamo la variabel $msgs
						// 
						// Recopilamos mensaje que puede ser posible :
						// 			[0] => Key folder in safepath unaccessible -> ya indica que es alert-warning
						// 			[0] => Producto añadido con éxito
						
				?>		
	<?php  
	//~ echo '<pre>';
	//~ print_r($displayData);
	//~ echo '</pre>';
	foreach ($msgList as $type => $msgs){
		// Obtenemos el type de error y creamos el TituloType
		if (empty($type)){
				$type		="info";
				$TituloType	= "Informacion";
		}
		if ($type = "notice") {
			$type		="info";
			$TituloType	= "Aviso";
		}
		if ($type == "error"){
				$type		="danger";
				$TituloType	= "Error";
		}
		if ($type == "warning"){
				$type		="danger";
				$TituloType	= "Error";
		}
		
		
		
		
	?>
		<div id="system-message">
			<div class="alert alert-<?php echo $type; ?>">
					<?php // This requires JS so we should add it trough JS. Progressive enhancement and stuff. ?>
					<a class="close" data-dismiss="alert">×</a>

					<?php if (!empty($msgs)) : ?>
						<h4 class="alert-heading"><?php
						if (empty($TituloType)){
							echo JText::_($type); 
						} else {
							echo JText::_($TituloType);
						}
						 ?>
						 </h4>
						<div>
							<?php foreach ($msgs as $msg) : ?>
								<p class="alert-message"><?php echo $msg; ?></p>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
	<?php } ?>
	
</div>
<?php endif; ?>
