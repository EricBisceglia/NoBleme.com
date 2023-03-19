<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                                                       SETUP                                                       */
/*                                                                                                                   */
// File inclusions /**************************************************************************************************/
include_once './../../inc/includes.inc.php';          # Core
include_once './../../actions/integrations.act.php';  # Actions
include_once './../../lang/integrations.lang.php';    # Translations




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                    API OUTPUT                                                     */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fetch the list of IRC channels

$irc_channels_list = irc_channels_list( format: 'api' );




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Output the channel list list as JSON

// Send headers announcing a json output
header("Content-Type: application/json; charset=UTF-8");

// Output the IRC channels
echo sanitize_api_output($irc_channels_list);