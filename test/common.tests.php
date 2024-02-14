<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) === str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*                  These tests should only be ran through `tests.php` at the root of the project.                   */
/*                                                                                                                   */
/*********************************************************************************************************************/
// Limit page access rights
user_restrict_to_administrators();

// Only allow this page to be ran in dev mode
if(!$GLOBALS['dev_mode'])
  exit(header("Location: ."));

// Include required files
include_once './inc/bbcodes.inc.php';




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                inc/bbcodes.inc.php                                                */
/*                                                                                                                   */
/*                                                      BBCODES                                                      */
/*                                                                                                                   */
/*********************************************************************************************************************/
// Parse BBCodes

// Process some BBCodes
$test = bbcodes("[b][quote=test][url]https://nobleme.com[/url][/quote][/b]");

// Define the expected result
$expectations = '<span class="bold"><div class="tinypadding_top"><div class="bbcode_quote_body"><div class="bbcode_quote_title">Quote by test :</div><hr class="bbcode_quote_separator"><a class="bold" href="https://nobleme.com">https://nobleme.com</a></div></div></span>';

// Expect the test to be processed properly
$test_results['bbcodes'] = test_assert( value:        $test                         ,
                                        type:         'string'                      ,
                                        expectation:  $expectations                 ,
                                        success:      "BBCodes parsed"              ,
                                        failure:      "BBCodes parsed incorrectly"  );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Parse NBCodes

// Process some NBCodes
$test = nbcodes("[page:test|internal][image-nsfw:image.png|left|description]");

// Define the expected result
$expectations = '<a class="nbcode_dead_link noglow" href="pages/compendium/test">internal</a><div class="nbcode_floater nbcode_floater_left"><a href="pages/compendium/image?name=image.png" class="noglow"><img class="nbcode_blur_2" onmouseover="unblur(this);" src="img/compendium/image.png" alt="image.png"></a><br>description</div>';

// Expect the test to be processed properly
$test_results['nbcodes'] = test_assert( value:        $test                         ,
                                        type:         'string'                      ,
                                        expectation:  $expectations                 ,
                                        success:      "NBCodes parsed"              ,
                                        failure:      "NBCodes parsed incorrectly"  );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Remove BBCodes

// Process some BBCodes
$test = bbcodes_remove("[b][quote=test][url]https://nobleme.com[/url][/quote][/b]");

// Define the expected result
$expectations = "test: https://nobleme.com";

// Expect the test to be processed properly
$test_results['unbbcodes'] = test_assert( value:        $test                         ,
                                          type:         'string'                      ,
                                          expectation:  $expectations                 ,
                                          success:      "BBCodes removed"             ,
                                          failure:      "BBCodes removed incorrectly" );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Remove NBCodes

// Process some NBCodes
$test = nbcodes_remove("[page:test|internal][image-nsfw:image.png|left|description]");

// Define the expected result
$expectations = "internalimage.png - description
";

// Expect the test to be processed properly
$test_results['unnbcodes'] = test_assert( value:        $test                         ,
                                          type:         'string'                      ,
                                          expectation:  $expectations                 ,
                                          success:      "NBCodes removed"             ,
                                          failure:      "NBCodes removed incorrectly" );