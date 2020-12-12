<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*                  Include this page to get a WYSYWIG-ish editor for BBCodes inside your content.                   */
/*                                                                                                                   */
/*********************************************************************************************************************/
// Prepare the padding depending on whether the BBCode editor is shown vertically or horizontally
$padding_editor_spacing = (isset($editor_line_break)) ? ' spaced_right' : ' spaced';
$padding_editor_left    = (isset($editor_line_break)) ? ' bigspaced_left' : '';
$padding_editor_top     = (isset($editor_line_break)) ? ' tinypadding_top' : '';


/*********************************************************************************************************************/
// Display the BBCode editor                                                                                         ?>

<div class="nowrap">

  <img class="pointer valign_middle tinypadding_bot<?=$padding_editor_left.$padding_editor_top.$padding_editor_spacing?>" src="<?=$path?>img/bbcodes/bold.svg" alt="B" title="<?=__('bold')?>" onclick="editor_bold('<?=$editor_target_element?>', 'bold');">

  <img class="pointer valign_middle tinypadding_bot<?=$padding_editor_top.$padding_editor_spacing?>" src="<?=$path?>img/bbcodes/underlined.svg" alt="U" title="<?=__('underlined')?>" onclick="editor_bold('<?=$editor_target_element?>', 'underlined');">

  <?php if(isset($editor_line_break)) { ?>
  <br>
  <?php } ?>

  <img class="pointer valign_middle tinypadding_bot<?=$padding_editor_left.$padding_editor_spacing?>" src="<?=$path?>img/bbcodes/quote.svg" alt="Q" title="<?=__('quote')?>" onclick="editor_bold('<?=$editor_target_element?>', 'quote', '<?=__('quote_prompt')?>');">

  <img class="pointer valign_middle tinypadding_bot<?=$padding_editor_spacing?>" src="<?=$path?>img/bbcodes/spoiler.svg" alt="S" title="<?=__('spoiler')?>" onclick="editor_bold('<?=$editor_target_element?>', 'spoiler', '<?=__('spoiler_prompt')?>');">

  <?php if(isset($editor_line_break)) { ?>
  <br>
  <?php } ?>

  <img class="pointer valign_middle tinypadding_bot<?=$padding_editor_left.$padding_editor_spacing?>" src="<?=$path?>img/bbcodes/link.svg" alt="L" title="<?=__('link')?>" onclick="editor_bold('<?=$editor_target_element?>', 'link', '<?=__('link_prompt')?>', '<?=__('link_prompt_2')?>');">

  <img class="pointer valign_middle tinypadding_bot<?=$padding_editor_spacing?>" src="<?=$path?>img/bbcodes/image.svg" alt="I" title="<?=__('image')?>" onclick="editor_bold('<?=$editor_target_element?>', 'image', '<?=__('image_prompt')?>');">

</div>