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
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Prepare the padding depending on whether the BBCode editor is shown vertically or horizontally

$padding_editor_spacing = (isset($editor_line_break)) ? ' spaced_right' : ' spaced';
$padding_editor_left    = (isset($editor_line_break)) ? ' bigspaced_left' : '';
$padding_editor_top     = (isset($editor_line_break)) ? ' tinypadding_top' : '';




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Make button presses update a real time output preview if requested

$preview_path     ??= $path;
$preview_onclick  = (isset($preview_output)) ? "preview_bbcodes('".$editor_target_element."', '".$preview_output."', '".$preview_path."');" : '';




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Make the icons dark if needed

$icon_dark = ($mode == 'light') ? '_dark' : '';




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Display the BBCode editor                                                                                         ?>

<div class="nowrap">

  <img class="pointer valign_middle tinypadding_bot<?=$padding_editor_left.$padding_editor_top.$padding_editor_spacing?>" src="<?=$path?>img/bbcodes/bold<?=$icon_dark?>.svg" alt="B" title="<?=__('bold')?>" onclick="editor_bold('<?=$editor_target_element?>', 'bold');<?=$preview_onclick?>">

  <img class="pointer valign_middle tinypadding_bot<?=$padding_editor_top.$padding_editor_spacing?>" src="<?=$path?>img/bbcodes/underlined<?=$icon_dark?>.svg" alt="U" title="<?=__('underlined')?>" onclick="editor_bold('<?=$editor_target_element?>', 'underlined');<?=$preview_onclick?>">

  <?php if(isset($editor_line_break)) { ?>
  <br>
  <?php } ?>

  <img class="pointer valign_middle tinypadding_bot<?=$padding_editor_left.$padding_editor_spacing?>" src="<?=$path?>img/bbcodes/quote<?=$icon_dark?>.svg" alt="Q" title="<?=__('quote')?>" onclick="editor_bold('<?=$editor_target_element?>', 'quote', '<?=__('quote_prompt')?>');<?=$preview_onclick?>">

  <img class="pointer valign_middle tinypadding_bot<?=$padding_editor_spacing?>" src="<?=$path?>img/bbcodes/spoiler<?=$icon_dark?>.svg" alt="S" title="<?=__('spoiler')?>" onclick="editor_bold('<?=$editor_target_element?>', 'spoiler', '<?=__('spoiler_prompt')?>');<?=$preview_onclick?>">

  <?php if(isset($editor_line_break)) { ?>
  <br>
  <?php } ?>

  <img class="pointer valign_middle tinypadding_bot<?=$padding_editor_left.$padding_editor_spacing?>" src="<?=$path?>img/bbcodes/link<?=$icon_dark?>.svg" alt="L" title="<?=__('link')?>" onclick="editor_bold('<?=$editor_target_element?>', 'link', '<?=__('link_prompt')?>', '<?=__('link_prompt_2')?>');<?=$preview_onclick?>">

  <img class="pointer valign_middle tinypadding_bot<?=$padding_editor_spacing?>" src="<?=$path?>img/bbcodes/image<?=$icon_dark?>.svg" alt="I" title="<?=__('image')?>" onclick="editor_bold('<?=$editor_target_element?>', 'image', '<?=__('image_prompt')?>');<?=$preview_onclick?>">

</div>