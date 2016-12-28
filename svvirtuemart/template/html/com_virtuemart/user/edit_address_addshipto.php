<?php
/**
 *
 * Enter address data for the cart, when anonymous users checkout
 *
 * @package	VirtueMart
 * @subpackage User
 * @author Max Milbers
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: edit_address_addshipto.php 7499 2013-12-18 15:11:51Z Milbo $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

/* Buscamos la forma poder atraer listado direcciones del usuario, teniendo en cuenta que:
 *  La dirección principal la clasifica como  [address_type] => BT
 *  y las direcciones secundarias son  [address_type] => ST
 * Lo hacemos es crear nuevamente el objeto:
 * $ObjetoUsuario= VmModel::getModel('user');
 * Y con $ObjetoUsuario->getUserAddressList ($ObjetoUsuario->getId (), 'ST')
 * Mostramos :
 * 		- Añadir otra direccion
 * 		- Lista de las direcciones que tenemos creadas 
 * 
 * */
 /* Obtenemos datos de direcciones */
 /* Código nuevo para mostrar lista de direcciones */
    // Creamos nuevo objeto 
    $LinkComun ='index.php?option=com_virtuemart&view=user&task=';
	$ObjetoUsuario= VmModel::getModel('user');
	$DireccionPrincipal = $ObjetoUsuario->getUserAddressList ($ObjetoUsuario->getId (),'BT');
	$htmlDirPrincipal  = 	
							'<strong>Direccion Principal:</strong> '.$DireccionPrincipal[0]->address_1
							.$DireccionPrincipal[0]->address_2
							.' - '.$DireccionPrincipal[0]->city
							.' - '.$DireccionPrincipal[0]->zip;
	$DireccionesSecundarias = $ObjetoUsuario->getUserAddressList ($ObjetoUsuario->getId (),'ST');
	// Link para añadir nueva direccion
	$addLink = '<a  class="details" href="' . JRoute::_ ( $LinkComun.'addST&new=1&addrtype=ST&virtuemart_user_id[]=' . $ObjetoUsuario->getId (). '&Itemid=329',$this->useXHTML,$this->useSSL).'">Nueva Direccion</a> ';
	$CantDirecciones = count($DireccionesSecundarias);
	
	$IdUsuario = $ObjetoUsuario->getId ();
  
 
?>
<?php // Comprobamos que el usuario sea el mismo , sino no mostramos nada 
if ($this->userDetails->virtuemart_user_id == $IdUsuario){

?>
<h2>
<?php echo '<span class="userfields_info">' .vmText::_('TPL_SVVIRTUEMART_VIRTUE_LISTDIRECCIONES').'</span>'; ?>
</h2>
    
<fieldset>
    
    
    
    <div class="lista-direcciones">
    <?php 
    //~ echo $this->lists['shipTo']; //Este es como lo mostraba antess..... 
    ?>
    
    <?php 	echo $htmlDirPrincipal.'<br/>'; ?>
    
    <?php
    // Mostramos la direcciones que tiene el usuario creadas
	$i = 0;
    for ($i = 0; $i < $CantDirecciones; $i++) {
	$idDireccion		=	$DireccionesSecundarias[$i]->virtuemart_userinfo_id;
    $NombreDireccion	=	$DireccionesSecundarias[$i]->address_type_name;
	$htmlDirSecundaria  = 	
							'<strong>'.$NombreDireccion.': </strong>'.$DireccionesSecundarias[$i]->address_1
							.$DireccionesSecundarias[$i]->address_2
							.' - '.$DireccionesSecundarias[$i]->city
							.' - '.$DireccionesSecundarias[$i]->zip;
	
	
	// Para realizar links...
	
	$LinkEditar 	=  	$LinkComun
					.'addST&addrtype=ST&virtuemart_user_id[]=' 
					. $IdUsuario
					. '&virtuemart_userinfo_id=' . $idDireccion.'&Itemid=329';
					
    $LinkEliminar	=	$LinkComun
					.'removeAddressST&virtuemart_user_id[]=' 
					. $IdUsuario
					. '&virtuemart_userinfo_id=' . $idDireccion;
    echo 	$htmlDirSecundaria.' <a href="'.$LinkEditar.'"><span class="glyphicon glyphicon-edit"> </span>Editar</a>'
			.' <a href="'.$LinkEliminar.'&Itemid=329"><span class="glyphicon glyphicon-trash"> </span>Eliminar</a><br/>';
    
    
	}
    
    echo $addLink.'<br/>';

	?>
    </div>

</fieldset>
<?php 
	
}
?>
