<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<!--BEGIN Search Box -->
<div class="SearchVirtuemart">

<form action="<?php echo JRoute::_('index.php?option=com_virtuemart&view=category&search=true&limitstart=0&virtuemart_category_id='.$category_id ); ?>" method="get">
<?php $output = '<input name="keyword" id="mod_virtuemart_search" maxlength="'.$maxlength.'" alt="'.$button_text.'" class="inputbox" type="text" size="'.$width.'" value="'.$text.'"  onblur="if(this.value==\'\') this.value=\''.$text.'\';" onfocus="if(this.value==\''.$text.'\') this.value=\'\';" />';
 $image = JURI::base().'images/iconos/lupa.png' ;
			
			echo '<img class="buscar" style="float:left;" src="'.$image.'"/></label>';	

			if ($button) :
			    if ($imagebutton) :
			        $button = '<input style="vertical-align :middle;height:16px;border: 1px solid #CCC;" type="image" value="'.$button_text.'" class="button'.$moduleclass_sfx.'" src="'.$image.'" onclick="this.form.keyword.focus();"/>';
			    else :
			        $button = '<input type="submit" value="'.$button_text.'" class="button" onclick="this.form.keyword.focus();"/>';
			    endif;

			switch ($button_pos) :
			    case 'top' :
				    $button = $button.'<br />';
				    $output = $button.$output;
				    break;

			    case 'bottom' :
				    $button = '<br />'.$button;
				    $output = $output.$button;
				    break;

			    case 'right' :
				    $output = $output.$button;
				    break;

			    case 'left' :
			    default :
				    $output = $button.$output;
				    break;
			endswitch;
			endif;
			
			echo $output;
?>
		<input type="hidden" name="limitstart" value="0" />
		<input type="hidden" name="option" value="com_virtuemart" />
		<input type="hidden" name="view" value="category" />
		<input type="hidden" name="virtuemart_category_id" value="<?php echo $category_id; ?>"/>
<?php if(!empty($set_Itemid)){
	echo '<input type="hidden" name="Itemid" value="'.$set_Itemid.'" />';
} ?>


	  </form>
</div>
<!-- End Search Box -->
