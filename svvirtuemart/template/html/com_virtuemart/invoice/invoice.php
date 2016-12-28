<?php
/**
 *
 * Order detail view
 * //index.php?option=com_virtuemart&view=invoice&layout=invoice&format=pdf&tmpl=component&order_number=xx&order_pass=p_yy
 * @package    VirtueMart
 * @subpackage Orders
 * @author Max Milbers, Valerie Isaksen
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: details.php 5412 2012-02-09 19:27:55Z alatak $
 */

defined('_JEXEC') or die('Restricted access');
JHtml::stylesheet('vmpanels.css', JURI::root() . 'components/com_virtuemart/assets/css/');
/* Hay que tener en cuenta que este fichero se utiliza tanto para crear los pdf de los nota de entrega ,como de las facturas.
 * Ademas tambien se utiliza para imprimir los pedidos.
 * Por ello , utilizamor dos variables de $this identificarlos:
 * $this->doctype
 * $this->uselayout
 * 
 * La primera variable nos indica que tipo de documento si es una nota de entrega y factura ( "deliverynote" y "invoice" ),
 * pero con el inconveniente que si es un pedido pone que "invoice" tb , por lo que no podemos diferenciar cuando imprime un pedido
 * cuando crea un pdf de una factura.
 * Por este motivo utilizaremos la segunda variable para identificar esas tres opciones ( tipos de documentos )
 * OTRO PROBLEMA : 
 * Al pulsar en icono de imprimir carga los mismos ficheros , pero no hace caso check de configuracion que marcamos
 * en tienda/Facturas&Emails para que no lo mostrará la cabecera, por lo que no podemos utilizar la caja de cabecera de esa opcion
 * de virtuemart, por ello consideramos que es un error de version, ya que:
 *   - No debería mostrar la cabecera
 *   - Y no debería ser el mismo documento.
 *  CREAMOS VARIABLE DE TIPO DE DOCUMENTO.
 * */
$tipo_documento = $this->uselayout;
if (empty($tipo_documento)) {
    $tipo_documento = 'Imprimir directamente';
    
}
/* Las tres opciones de $tipo_documento puede ser:
 * PEDIDO
 * deliverynote
 * invoice
 * */
 

$virtuemart_vendor_id = $orderDetails['details']['BT']->virtuemart_vendor_id;
$vendorModel = VmModel::getModel('vendor');
$vendedor_clase = $vendorModel->getVendor($virtuemart_vendor_id);
/* Con las anterires instrucciones obtenemos datos de $vendor, ya que hay que tener en cuenta que
 * virtuemart puede tener varios vendedores, por ello obtenemos los datos del vendedor de la orden.
 * Ahora llamando a $vendedor->vendor_store_name : Obtenemos el nombre de la tienda.
 * 					$vendedor->vendor_name: Obtenemos el nombre de vendedor, que puede ser distinto.
 * Los campos del vendedor los podemos obtener del array que genera por campo
 * [name] => 
 * [value] => 
 * [title] => 
 * [type] => 
 * [required] => 
 * [hidden] =>
 * [description] =>
 * Los campos que nos interesa son:
 * 			['phone_1']
 * 			[email]
 * 			[DNICIF]
 * 			[address_1]
 * 			[zip]
 * 			[city]
 * 			
 * 
 * La instruccion es que utilizamos es $vendedor->vendorFields['fields']['campo']['value'] 
 * */
//~ $vendedor_phone1 = $vendedor->vendorFields['fields']['phone_1']['value'];
//~ $vendedor_email = $vendedor->vendorFields['fields']['email']['value'];
//~ $vendedor_DNICIF = $vendedor->vendorFields['fields']['DNICIF']['value'];
//~ $vendedor_address1 = $vendedor->vendorFields['fields']['address_1']['value'];
//~ $vendedor_codpostal = $vendedor->vendorFields['fields']['zip']['value'];
//~ $vendedor_ciudad = $vendedor->vendorFields['fields']['city']['value'];
foreach ($vendedor_clase->vendorFields['fields'] as $field) {
	  	if (!empty($field['value'])) {
			$vendedor[$field['name']] = $field['value'];
			
		}
}
 
/* Tambien podemos obtener la imagen que le tengamos al vendedor, con el siguiente código ya
 * generamos una variable que tiene el código html para mostrar la imagen.
 * Teniendo en cuenta la medida de la imagen se va respetar.
 * */
if (!empty($vendedor_clase->images)) {
			$img = $vendedor_clase->images[0];
			$vendedor['imagen'] = "<div class=\"vendor-image\">".$img->displayIt($img->file_url,'','',false, '', false, false)."</div>";
		}

/* HASTA AQUI OBTENEMOS LOS DATOS DE QUIEN FACTURA */

/* Ahora vamos obtener los datos de a quien facturar del pedido.
 * Hay que tener en cuenta que el nombre, apellidos debemo meterlo en una sola 
 * variable , para poder mostralo juntos como nombre de comprador y ademas
 * poder maquetar a nuestro gusto. */
 
foreach ($this->userfields['fields'] as $field) {
	  	if (!empty($field['value'])) {
			$comprador[$field['name']] = $field['value'];
			
		}
}
/* Con el bucle anterior, leemos todos los campos, como ya sabemos el orden de cada uno
 * y los campos que hay en nuestra tienda es muy facil, pero hay que tenerlo en cuenta, ya que el 
 * orden de los campos en futura instalacion de otras tiendas puede cambiar, por lo que afecta a 
 * este código.
 * Orden de los campos de comprador:
 * [email]
 * [name] = Nombre que quiere mostrar usuario.. 
 * [first_name] = Nombre
 * [middle_name]= Primer apellido
 * [last_name] = Segundo apellido
 * [phone_1] = Telefono
 * [DNICIF]
 * [address_1] = Dirección facturacion , donde pone calle y numero.
 * [zip] = Código postal
 * [city] = Ciudad 
 * [virtuemart_country_id] = País
 * [virtuemart_state_id] = Estado / Region / Provincia / Distrito... 
 * Sabiendo esto y sabiendo que es un array , donde el valor esta value creamo las variables del comprador que 
 * necesitamos.
 * */
 

if ($this->_layout == "invoice") {
	$document = JFactory::getDocument();
	$document->setTitle(vmText::_('COM_VIRTUEMART_ORDER_PRINT_PO_NUMBER') . ' ' . $this->orderDetails['details']['BT']->order_number . ' ' . $this->vendor->vendor_store_name);
}

$vendorCompanyName = (!empty($this->vendor->vendorFields["fields"]["company"]["value"])) ? $this->vendor->vendorFields["fields"]["company"]["value"] : $this->vendor->vendor_store_name;

if(!empty($this->vendor->vendor_letter_css)) { ?>
	<style type="text/css">
		<?php echo $this->vendor->vendor_letter_css; ?>
	</style>
<?php }

$this->vendor->vendor_letter_header_image;

if ($this->headFooter) {
    ?>
<style><?php echo $this->vendor->vendor_letter_css; ?></style>
<div class="vendor-details-view">
<?php echo ($this->format=="html")?$this->replaceVendorFields($this->vendor->vendor_letter_header_html, $this->vendor):$this->vendor->vendor_letter_header_html; ?>
</div>

<div class="vendor-description">
<?php /*echo $this->vendor->vendor_store_desc.'<br>';


    	foreach($this->vendorAddress as $userfields){

         foreach($userfields['fields'] as $item){
             if(!empty($item['value'])){
                 if($item['name']==='agreed'){
                     $item['value'] =  ($item['value']===0) ? vmText::_('COM_VIRTUEMART_USER_FORM_BILLTO_TOS_NO'):vmText::_('COM_VIRTUEMART_USER_FORM_BILLTO_TOS_YES');
                 }
             ?><!-- span class="titles"><?php echo $item['title'] ?></span -->
                         <span class="values vm2<?php echo '-'.$item['name'] ?>" ><?php echo $this->escape($item['value']) ?></span>
                     <?php if ($item['name'] != 'title' and $item['name'] != 'first_name' and $item['name'] != 'middle_name' and $item['name'] != 'zip') { ?>
                         <br class="clear" />
                     <?php
                 }
             }
         }
     }*/
?></div> <?php
}


if ($this->print) {
	/* Aunque cambie la siguiente linea por <body> sigue generando el pdf, 
	 * pero al nombre de la factura y el pdf le añade la fecha.*/
    ?>
	<body onload="javascript:print();">
	

<?php   }
/* Mostramos el tipo de documento, aunque no hace falta en siguiente versiones
 * puede que nos haga falta */
echo '<small>Tipo de documento:'.$tipo_documento.'</small>';
// Mostramos imagen 
echo $vendedor['imagen'];
/* Creamos tabla para mostrar datos de vendedor y comprador */

echo '<table border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td>';
echo '<strong>'.$vendorCompanyName.'</strong><br/>';
echo $vendedor['first_name'].' '.$vendedor['middle_name'].' '.$Vendedor['last_name'].'<br/>';
echo $vendedor['phone_1'].'<br/>' ;
echo $vendedor['email'].'<br/>' ;
echo 'Cif o NIF:'.$vendedor['DNICIF'].'<br/>';
echo $vendedor['address_1'].'<br/>';
echo $vendedor['zip'].'-'.$vendedor['city'].'<br/>';
echo $vendedor['virtuemart_state_id'].'-'.$vendedor['virtuemart_country_id'].'<br/>';

echo '</td><td>';
echo "<strong>Sus datos:</strong><br/>";
echo $comprador['first_name'].' '.$comprador['middle_name'].' '.$comprador['last_name'].'<br/>';
echo $comprador['phone_1'].'<br/>';
echo $comprador['email'].'<br/>';
echo 'Cif o NIF:'.$comprador['DNICIF'].'<br/>';
echo $comprador['address_1'].'<br/>';
echo $comprador['zip'].'-'.$comprador['city'].'<br/>';
echo $comprador['virtuemart_state_id'].'-'.$comprador['virtuemart_country_id'].'<br/>';


//~ echo '<pre>';
//~ print_r($vendedor_clase->vendorFields);
//~ echo '</pre>';

echo '</td></tr></tbody></table>';

?>

<div class='spaceStyle'>
    <?php
    echo $this->loadTemplate('order');
    ?>
</div>

<div class='spaceStyle'>
    <?php
    if ($this->print) {
		echo $this->loadTemplate('items');
    } else {
        $tabarray = array('items'=>'COM_VIRTUEMART_ORDER_ITEM', 'history'=>'COM_VIRTUEMART_ORDER_HISTORY');
		shopFunctionsF::buildTabs( $this, $tabarray);
    }
    ?>
</div>
<br clear="all"/><br/>
    <?php    
if ($this->headFooter) {
    echo ($this->format=="html")?$this->replaceVendorFields($this->vendor->vendor_letter_footer_html, $this->vendor):$this->vendor->vendor_letter_footer_html;
}

if ($this->vendor->vendor_letter_add_tos) {?>
<div class="invoice_tos" <?php if ($this->vendor->vendor_letter_add_tos_newpage) { ?> style="page-break-before: always"<?php } ?>>
    <?php echo $this->vendor->vendor_terms_of_service; ?>
</div>
<?php }

if ($this->print) { ?>
</body>
<?php
} ?>




