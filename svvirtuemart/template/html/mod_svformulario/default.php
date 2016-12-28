<?php

/*------------------------------------------------------------------------
# SV Formulario
# ------------------------------------------------------------------------
# author                Solucionesvigo.es
# copyright             Libre.
# @license -            http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites:             http://solucionesvigo.es
# Technical Support:    http://ayuda.svigo.es
* -------------------------------------------------------------------------*/

defined('_JEXEC') or die('Restricted access');
	// Creamos variables de parametros de modulo
	$mostrarnombre =  $params->get( 'nombre', '1' );
	$mostrartelephone =  $params->get( 'telephone', '1' );	
	$mostrarsubject =  $params->get( 'subject', '1' );
	$mostrarselectlopd =  $params->get( 'selectlopd', '1' );
	$mostrarselectlopd =  $params->get( 'selectlopd', '1' );
	$showmensaje = $params->get( 'showmensaje', '1' );


	$textolopd  = $params->get( 'lopd', '1' );
	$showdepartment  	     =        $params->get( 'showdepartment', '1' );
    $showsendcopy            =        $params->get( 'showsendcopy', '1' );
    $humantestpram           =        $params->get( 'humantestpram', '1' );
	$sales_address           =        $params->get( 'sales_address', 'sales@yourdomain.com' );
    $support_address         =        $params->get( 'support_address', 'support@yourdomain.com' );
    $billing_address         =        $params->get( 'billing_address', 'billing@yourdomain.com' );
    if  ($svform[resultado] ==''){
    $name                    =        '';
    $email                   =        '';
    $phno                    =        '';
    $subject                 =        '';
    $msg                     =        '';
   
	} else {
	$name                    =     $svform[name];
    $email                   =     $svform[email];
    $phno                    =     $svform[phno];
    $subject                 =     $svform[subject];
    $msg                     =     $svform[msg];	
		
	}
	$selfcopy                =        '';
    $varone                  =        rand(5, 15);
    $vartwo                  =        rand(5, 15);
    $sum_rand                =        $varone+$vartwo;

?>
    <link rel="stylesheet" href="modules/mod_svformulario/tmpl/lib/svformulario.css" media="screen" />
  
    <script type="text/javascript">
				
		function validar() 
		{
		  var ok = false;
		  var numeroint = document.Svformulario.human_test.value ;
		  var f =  document.Svformulario.sum_test.value ;
		  expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		  var email = document.Svformulario.email.value ;
		  var msg = "";
		  
			  // Compruebo si el numero introducido es el correcto.
			  if(numeroint != f)
			  {
				
				var msg = "Suma bien \n"
			  } 
			  
			 if ( !expr.test(email) ){
				var msg = msg + "Error: La dirección de correo " + email + " es incorrecta.";
			 }
			// Aquí compruebo si msg tiene datos 
			if (msg !="")
			{
				if(ok == false)
				alert(msg);
				return ok
			 }
		}
	</script>
	<?php if  (isset ($svform['resultado'])) {
	// Texto que se muestra despues de enviar formulario antes de enviar	
	?>
    <div class="SVFormDespuesEnvio">
    <h4 class="Rojo" ><?php echo $svform['resultado'];?></h4>
    <?php echo $svform['resultado2'];
    ?>
	
    </div>
    <?php } else {
		// Texto que se muestra al mostrar formulario antes de enviar
		?>
		<div class="SVFormAntesEnvio">
		<h4 class="Rojo"><?php echo JText::_('MOD_SVFORMULARIO_MENSAJE_ANTES');?></h4>
    </div>
	<?php
		} ?>
    <?php
    /* No debemos cambiar id Svformulario ya que lo utilizamod en script para controlar si
			metio datos antes de enviar la formulario. */; ?>
    <div id="Svformulario">
		<?php
		//$app = JFactory::getDocument();
		/*echo '<pre>';
		print_r ($module->title);
		echo '</pre>';
		* los campos del formulario si le ponemos disabled quedan dehabilitados, 
		* por lo que si el formulario ya fue envía entonces deberíamos sustituir
		* required por disabled
		* Y hay campos que no se deberían mostrar, como
		* copia y control spam 
		* */
		if (!isset ($svform['resultado'])) {
			$estado = ' required';
		}else{
			$estado = ' disabled';
		}
		?>
		<div class="col-md-12">
		<form name="form Svformulario" id="form" method="post" action="<?php $_SERVER['PHP_SELF']?>" onsubmit="return validar(this)">
            <?php if($showdepartment=='1') : ?>
              <div class="form-group department">
              <label><?php echo JText::_('MOD_SVFORMULARIO_DEPARTMENT'); ?></label>
              <select name="dept" class="text">
              	<option value="sales"><?php echo JText::_('MOD_SVFORMULARIO_SALES'); ?></option>
              	<option value="support"><?php echo JText::_('MOD_SVFORMULARIO_SUPPORT'); ?></option>
              	<option value="billing"><?php echo JText::_('MOD_SVFORMULARIO_BILLING'); ?></option>
              </select>
              </div>
            <?php endif; ?>
            <?php if($mostrarnombre=='1') : ?>
            <!-- Presentacion de nombre -->
            <div class="form-group name">
            <label class="name"><?php echo JText::_('MOD_SVFORMULARIO_NAME'); ?></label>
            <input class="form-control" name="name" type="text" value="<?php echo $name; ?>" <?php echo $estado; ?> />
            </div>
			<?php endif; ?>
			<!-- Presentacion de email -->
            <div class="form-group email">
            <label class="email"><?php echo JText::_('MOD_SVFORMULARIO_EMAIL'); ?></label>
            <input class="form-control" name="email" type="text" value="<?php echo $email; ?>" <?php echo $estado; ?> />
            </div>
            <?php if($mostrartelephone=='1') : ?>
			<!-- Presentacion de telefono -->
            <div class="form-group phno">
            <label class="phno"><?php echo JText::_('MOD_SVFORMULARIO_TELEPHONE'); ?></label>
            <input class="text" name="phno" type="text" value="<?php echo $phno; ?>" pattern="[0-9]{9}" <?php echo $estado; ?> />
            </div>
			<?php endif; ?>
           
            <?php if($mostrarsubject=='1') : ?>
			<!-- Presentacion de Subjecto -->
			<div class="form-group subject">
            <label class="subject"><?php echo JText::_('MOD_SVFORMULARIO_SUBJECT'); ?></label>
            <input class="text" name="subject" type="text" value="<?php echo $subject; ?>" <?php echo $estado; ?> />
            </div>
			<?php endif; ?>

            <?php if($showmensaje =='1') {?>
   			<!-- Presentacion de Mensaje -->
            <div class="form-group msg">
            <label class="msg"><?php echo JText::_('MOD_SVFORMULARIO_MESSAGE'); ?></label>
            <textarea class="text" name="msg" <?php echo $estado; ?> ><?php echo $msg; ?></textarea>
            </div>
            <?php } else { ?>
			<textarea style="display:none" class="text" name="msg" disabled ><?php echo ' Sin activar mensaje en configuracion ';?></textarea>
	
			<?php } ?>


			<?php if($mostrarselectlopd=='1') : ?>
			<!-- Presentacion de Lopd -->
				<div class="form-group lopd">
                 <label class="lopd"><?php echo $textolopd; ?></label>
                </div>
            <?php endif; ?>
 
 
            <?php
             if  (!isset ($svform['resultado'])) {
				 if($showsendcopy=='1') : ?>
				<!-- Presentacion de Envio de Copia -->
					<div class="checkbox">
					<input style="margin: 0px 0px 0px -5px;" type="checkbox" name="selfcopy" <?php if($selfcopy == "yes") echo "checked='checked'"; ?> value="yes" />
					<label><?php echo 'Deseo recibir ofertas por email'; ?></label>
					</div>
				<?php endif; ?>
				<?php if($humantestpram=='1') : ?>
				<!-- Presentacion de Control de Spam -->
				<div class="form-group humantest">
					<label for='message'><?php echo JText::_('MOD_SVFORMULARIO_HUMANTEST'); ?></label>
					<?php echo '<b>'.$varone.'+'.$vartwo.'=</b>'; ?>
					<input id="human_test" name="human_test" size="3" type="text" class="text">
					<input type="hidden" id="sum_test" name="sum_test" value="<?php echo $sum_rand; ?>" />
				</div>
				<?php endif; 
			}	?>
            
            <?php
             if  (!isset ($svform['resultado'])) {?>
            <div class ="form-group enviar"></div>
                <input class="LinkBtnVerde" type="submit" name="submit" value="<?php echo JText::_('MOD_SVFORMULARIO_SUBMIT'); ?>" id="submit" <?php echo $estado; ?>/>
           </div>
           <?php } ?>   
        </form>
		</div>

      
    </div>
