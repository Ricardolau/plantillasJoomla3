<?php

defined('_JEXEC') or die;

$app = JFactory::getApplication();
$app             = JFactory::getApplication();
$doc             = JFactory::getDocument();
$user            = JFactory::getUser();
$this->language  = $doc->language;
$this->direction = $doc->direction;

// Getting params from template
$params = $app->getTemplate(true)->params;

// Detecting Active Variables
$option   = $app->input->getCmd('option', '');
$view     = $app->input->getCmd('view', '');
$layout   = $app->input->getCmd('layout', '');
$task     = $app->input->getCmd('task', '');
$itemid   = $app->input->getCmd('Itemid', '');
$sitename = $app->get('sitename');

JHtml::_('bootstrap.framework');
// Load optional RTL Bootstrap CSS
// RTL es idioma de derecha izquierda, como arabe...
//~ JHtml::_('bootstrap.loadCss', false, $this->direction);




/*	Quitamos el Bootstrap que carga joomla.			;
 * 		¡ Ya lo hicimos !							;
 * 	No la cargamos en la plantilla, ya como véis en	;
 *  en las lineas comentadas.						;
 *  Pero creo que hay extensiones y modulos que 	;
 * 	cargan bootstrap, por eso la siguiente linea.	;
 *  Pero la carga igual...							; 
 *  Cargo bootstrap y luego quito en las lineas que ;
 *  siguen a esta nota.								;
 *	
 * */
 
// Hay que tener en cuanta que puede generar errores ya que muchas
// extensiones trabajan con ellas, espero que las que utilicemos no... 
unset($this->_scripts[JURI::root(true).'/media/jui/js/bootstrap.min.js']);

// Bueno ahora cargamos bootstrap antes css del template... 

// Add Stylesheets
$doc->addStyleSheet($this->baseurl . '/templates/' . $this->template . '/css/bootstrap.min.css');
// Ahora compilamos less si no existe el fichero css
// Si queremos volver a compilar solo tenemos que eliminar el fichero ccs
$ficheroCSS = JPATH_BASE  . '/templates/' . $this->template . '/css/svbasic.css';

// Compilamos CSS si no existe CSS o si opición de parametro Compilar Less es SI
if (file_exists($ficheroCSS) == false || $params['compilarLess'] == 1) {
	$less = new JLess;
	$less->setFormatter(new JLessFormatterJoomla);
	$templates = array(
		JPATH_BASE . '/templates/'.$this->template .'/less/svbasic.less' => $ficheroCSS);
	foreach ($templates as $source => $output)
	{
		try
		{
			$less->compileFile($source, $output);
		}
		catch (Exception $e)
		{
			echo $e->getMessage();
		}
	}
}
$doc->addStyleSheetVersion($this->baseurl . '/templates/' . $this->template . '/css/svbasic.css');

// Add JavaScript
$doc->addScript($this->baseurl . '/templates/' . $this->template . '/js/bootstrap.min.js');

?>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >

<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

<jdoc:include type="head" />

</head>

<body>

<div class="container">
	<div class="row Cabecera">
	<header>
		<?php if ($this->countModules('position-0')>0 or  $this->countModules('position-01')>0): ?>
			<div>
				<div class="col-xs-7 col-md-5">
				<jdoc:include type="modules" name="position-0" style="BS" /> 
				</div>
				<div class="col-md-5 col-md-offset-2">
					<jdoc:include type="modules" name="position-01" style="BS" /> 
				</div>
			</div>
			<div class="separador"></div>
		<?php endif; ?>
		<?php if ($this->countModules('position-1')>0 ): ?>
				<div>
					<jdoc:include type="modules" name="position-1" style="xhtml" /> 
				</div>
				<div class="separador"></div>
		<?php endif; ?>

		<?php if ($this->countModules('position-6')>0): ?>
			<div>
			<jdoc:include type="modules" name="position-6" style="xhtml" /> 
			</div>
		<?php endif; ?>

		 <?php if ($this->countModules('position-3')>0): ?>
			<div>
			<jdoc:include type="modules" name="position-3" style="xhtml"/>
			</div>
		<?php endif; ?>
		
	</header>
 	</div>
 	<div class="separador"></div>
 	<?php if ($this->countModules('position-4')>0 || $this->countModules('position-5')>0 || $this->countModules('position-6')>0): ?>
	<div>
		<div>
		<jdoc:include type="modules" name="position-4" style="xhtml" />
		</div>
		<div>
		<jdoc:include type="modules" name="position-5" style="xhtml" />
		</div>
	</div>
	<!-- Fin de contenedor de Contenedor Slider -->
	<?php endif; ?>
  	<div class="cleared"></div>
	
	<div class="row Content">
  		<div>
		<jdoc:include type="modules" name="position-2" style="xhtml" />
		</div>
  		<div class="container col-md-12">
		<article>
			<jdoc:include type="message" />
			<jdoc:include type="component" />
		</article>
		</div>
  	</div>
  	<div class="clear"></div>
	<div class="row Pie">
		<footer>
			<jdoc:include type="modules" name="position-7"  style="xhtml" />
		</footer>
  	</div>
	<div class="row PieDespues">
		<jdoc:include type="modules" name="position-8" style="xhtml" />
  	</div>
</div>
<div class="debug">
	<jdoc:include type="modules" name="debug"  />
</div>
</body>
</html>
