<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

/** 
 * Aquí llegamos cuando nos logueamos 
*/

defined('_JEXEC') or die;

// Aquí creamo redirección ya que no queremos que muestre datos cuenta
# Get iop_id from query string
$app = JFactory::getApplication();
$app->redirect($_SERVER['SCRIPT_NAME']);
//~ echo '<pre>';
//~ print_r($app);
//~ echo print_r($_SERVER['SCRIPT_NAME']);
//~ echo '</pre>';




?>
<?php if ($this->params->get('show_page_heading')) : 
	/* Aquí aunque esta dentro de if show page heading 
	 * hay que tener en cuenta que entra cuando ya se logueo o se
	 * registro.
	 * Por este motivo no vamos mostrar el titulo del item... 
	 * motramos testo de tu datos.
	 * */
?>
<div class="page-header corona">
			<div class="CategoriaVirtuemart">
				<h1><?php echo 'Mi cuenta';?></h1>
			</div>
</div>
<?php endif; ?>
<?php if (JFactory::getUser()->id == $this->data->id) : ?>
<ul class="btn-toolbar pull-right">
	<?php 
	/* Mostramos link para editar datos usuario de joomla */
	?>
	<li class="btn-group">
		<a class="btn" href="<?php echo JRoute::_('index.php?option=com_users&task=profile.edit&user_id=' . (int) $this->data->id);?>">
			<span class="icon-user"></span> <?php echo JText::_('COM_USERS_EDIT_PROFILE'); ?></a>
	</li>
	<?php /*
	* 
	* */
	?>
</ul>
<?php endif; ?>
<div class="profile col-md-6 col-md-offset-3<?php echo $this->pageclass_sfx?>">

<?php /* Ahora cargamo la plantilla de mostrar los datos de core.
	   * Que son los datos :
	   * Nombre:
	   * Usuario:
	   * Fecha registro:
	   * Ultima visita:
	   * Para mi estos datos solo son necesarios mostrar los primeros para esta web. */
	echo $this->loadTemplate('core'); 
?>


<?php /* Ahora cargamos la plantilla de parametros para mostrar los datos parametros usuarios.
	   * Editor:
	   * Zona horaria:
	   * Idioma del sitio:
	   * Estilo de la plantilla:
	   * Idioma de administrador:
	   * Sitio de ayuda:
	   * La mayoria de estos datos no son utiles para el usuario */
	echo $this->loadTemplate('params'); 
?>
	
	
<?php /* No lo comprobe pero me imagino que muestra los articulos creado por cada usuario
	   * si fueran editores.. o similar */
	echo $this->loadTemplate('custom'); 
	
	// Ahora ponemos el menu MI CUENTA
	?>
	<div>
		<form action="" method="post" id="login-form" class="form-vertical">
		
		<ul>
		<li><a href="index.php?option=com_virtuemart&amp;view=user&amp;layout=edit&amp;Itemid=327" title="Mantenimiento de cuenta">Informacion de cliente</a></li>	
		<li><a href="index.php?option=com_virtuemart&amp;view=user&amp;layout=editaddress&amp;Itemid=329" title="Direcciones de envi&oacute;">Direcciones de envío</a></li>
		<li><a href="index.php?option=com_virtuemart&amp;view=orders&amp;layout=list&amp;Itemid=328" title="Listado pedidos">Historial de pedidos</a></li>
		<li>
			<div class="logout-button">
			<input type="submit" name="Submit" class="btn btn-primary" value="<?php echo JText::_('JLOGOUT'); ?>" />
			</div>
		</li>
		</ul>
	</div>


</div>
