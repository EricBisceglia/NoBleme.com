<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                             FIXTURES FOR THE DATABASE                                             */
/*                                                                                                                   */
/*********************************************************************************************************************/
/*                                                                                                                   */
/*                    These fixtures are data meant to be used locally when working on the website                   */
/*       They should/will never be run on a production environment, so don't worry too much about their conents      */
/*                                                                                                                   */
/*               Word of warning: This page WILL fail its execution if not included from fixtures.php                */
/*                                                                                                                   */
/*********************************************************************************************************************/
// Only allow this page to be ran in dev mode, it wouldn't be nice to accidentally wipe production data, would it?
include_once './inc/configuration.inc.php';
if(!$GLOBALS['dev_mode'])
  exit(header("Location: ."));




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                      FUNCTIONS REQUIRED TO INSERT FIXTURES                                        */
/*                                                                                                                   */
/*********************************************************************************************************************/

/**
 * Generates a lorem ipsum like sentence.
 *
 * @param   int     $word_count The number of words the paragraph should contain.
 *
 * @return  string              The randomly generated paragraph.
 */

function fixtures_lorem_ipsum($word_count, $punctuation=null)
{
  // Random words to use in the lorem genertion
  $words = array('lorem', 'lorem', 'lorem', 'ipsum', 'ipsum', 'ipsum', 'dolor', 'dolor', 'sit', 'sit', 'amet', 'consectetur', 'adipisicing', 'elit', 'sed', 'sed', 'do', 'eiusmod', 'tempor', 'incididunt', 'ut', 'labore', 'et', 'et', 'et', 'dolore', 'magna', 'aliqua', 'exercitationem', 'perferendis', 'perspiciatis', 'laborum', 'eveniet', 'sunt', 'iure', 'nam', 'nam', 'nobis', 'eum', 'cum', 'officiis', 'excepturi', 'odio', 'consectetur', 'quasi', 'aut', 'quisquam', 'vel', 'eligendi', 'itaque', 'non', 'odit', 'tempore', 'quaerat', 'dignissimos', 'facilis', 'neque', 'nihil', 'expedita', 'vitae', 'vero', 'ipsum', 'nisi', 'animi', 'cumque', 'pariatur', 'velit', 'modi', 'natus', 'iusto', 'eaque', 'sequi', 'illo', 'sed', 'ex', 'et', 'voluptatibus', 'tempora', 'veritatis', 'ratione', 'assumenda', 'incidunt', 'nostrum', 'placeat', 'aliquid', 'fuga', 'fuga', 'provident', 'praesentium', 'rem', 'necessitatibus', 'suscipit', 'adipisci', 'quidem', 'possimus', 'voluptas', 'debitis', 'sint', 'accusantium', 'unde', 'sapiente', 'voluptate', 'qui', 'aspernatur', 'laudantium', 'soluta', 'amet', 'quo', 'aliquam', 'saepe', 'culpa', 'libero', 'ipsa', 'dicta', 'reiciendis', 'nesciunt', 'doloribus', 'autem', 'impedit', 'minima', 'maiores', 'repudiandae', 'ipsam', 'obcaecati', 'ullam', 'enim', 'totam', 'totam', 'delectus', 'ducimus', 'quis', 'voluptates', 'dolores', 'molestiae', 'harum', 'dolorem', 'quia', 'voluptatem', 'molestias', 'magni', 'distinctio', 'omnis', 'illum', 'dolorum', 'voluptatum', 'ea', 'quas', 'quam', 'corporis', 'quae', 'blanditiis', 'atque', 'deserunt', 'laboriosam', 'earum', 'consequuntur', 'hic', 'cupiditate', 'quibusdam', 'accusamus', 'ut', 'rerum', 'error', 'minus', 'eius', 'ab', 'ad', 'nemo', 'fugit', 'officia', 'at', 'in', 'id', 'quos', 'reprehenderit', 'numquam', 'iste', 'fugiat', 'sit', 'inventore', 'beatae', 'repellendus', 'magnam', 'recusandae', 'quod', 'explicabo', 'doloremque', 'aperiam', 'consequatur', 'asperiores', 'commodi', 'optio', 'dolor', 'labore', 'temporibus', 'repellat', 'veniam', 'architecto', 'est', 'est', 'est', 'esse', 'mollitia', 'nulla', 'a', 'similique', 'eos', 'alias', 'dolore', 'tenetur', 'deleniti', 'porro', 'facere', 'maxime', 'corrupti');

  // Generate a random lorem ipsum
  $lorem_ipsum = '';
  for ($i = 0 ; $i < $word_count ; $i++)
  {
    $lorem_ipsum .= ($i) ? ' ' : '';
    $lorem_ipsum .= $words[array_rand($words, 1)];
  }

  // Return the lorem ipsum
  return $lorem_ipsum;
}




/**
 * Generates SQL safe random data.
 *
 * @param   string  $type   Type of data to be generated ('int', 'digits', 'string', 'sentence', 'text').
 * @param   int     $min    The minimum length or amount of data to be generated.
 * @param   int     $max    The maximum length or amount of data to be generated.
 *
 * @return  string          The randomly generated content.
 */

function fixtures_generate_data($type, $min, $max)
{
  // Don't do aything if the min/max values are incorrect
  if($max < 1 || $min > $max)
    return;

  // Random int between $min and $max
  if($type == 'int')
    return mt_rand($min, $max);

  // Random string of digits
  if($type == 'digits')
  {
    $temp_number  = '';
    $max_length   = mt_rand($min, $max);
    for ($i = 0; $i < $max_length; $i++)
      $temp_number .= mt_rand(0,9);
    return $temp_number;
  }

  // Random string
  if($type == 'string')
  {
    $characters   = "aaaaaabcdeeeeeeefghiiiiiijkllmmnnoooooopqrrsssttuuvwxyz      ";
    $max_length   = mt_rand($min, $max);
    $temp_string  = '';
    for ($i = 0; $i < $max_length; $i++)
      $temp_string .= $characters[mt_rand(0, (strlen($characters) - 1))];
    return $temp_string;
  }

  // Random paragraph
  if($type == 'sentence')
    return ucfirst(fixtures_lorem_ipsum(mt_rand($min, $max), 1)).'.';

  // Random text
  if($type == 'text')
  {
    $temp_text  = '';
    $max_length = mt_rand($min, $max);
    for ($i = 0; $i < $max_length; $i++)
    {
      $temp_text .= ($i) ? '\r\n\r\n' : '';
      $temp_text .= ucfirst(fixtures_lorem_ipsum(mt_rand(100, 400), 1)).'.';
    }
    return $temp_text;
  }
}




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                       USERS                                                       */
/*                                                                                                                   */
/*********************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Create default users with no password and varied access rights for testing purposes

query(" INSERT INTO users
        SET         users.id                  = 1             ,
                    users.nickname            = 'Admin'       ,
                    users.password            = ''            ,
                    users.is_administrator    = 1             ");
query(" INSERT INTO users
        SET         users.id                  = 2             ,
                    users.nickname            = 'Global_mod'  ,
                    users.password            = ''            ,
                    users.is_global_moderator = 1             ");
query(" INSERT INTO users
        SET         users.id                  = 3             ,
                    users.nickname            = 'Moderator'   ,
                    users.password            = ''            ,
                    users.is_moderator        = 1             ,
                    users.moderator_rights    = 'forum'       ,
                    users.moderator_title_en  = 'Forum'       ,
                    users.moderator_title_fr  = 'Forum'        ");
query(" INSERT INTO users
        SET         users.id                  = 4             ,
                    users.nickname            = 'User'        ,
                    users.password            = ''            ");
query(" INSERT INTO users
        SET         users.id                  = 5             ,
                    users.nickname            = 'Prude'       ,
                    users.password            = ''            ");
query(" INSERT INTO users
        SET         users.id                  = 6             ,
                    users.nickname            = 'Banned'      ,
                    users.password            = ''            ,
                    users.is_banned_until     = 1918625619    ,
                    users.is_banned_because   = 'Fixture'     ");

query(" INSERT INTO users_profile
        SET         users_profile.fk_users      = 1                     ,
                    users_profile.email_address = 'admin@localhost'     ,
                    users_profile.created_at    = '1111239420 '         ");
query(" INSERT INTO users_profile
        SET         users_profile.fk_users      = 2                     ,
                    users_profile.email_address = 'globalmod@localhost' ,
                    users_profile.created_at    = '1111239420 '         ");
query(" INSERT INTO users_profile
        SET         users_profile.fk_users      = 3                     ,
                    users_profile.email_address = 'moderator@localhost' ,
                    users_profile.created_at    = '1111239420 '         ");
query(" INSERT INTO users_profile
        SET         users_profile.fk_users      = 4                     ,
                    users_profile.email_address = 'user@localhost'      ,
                    users_profile.created_at    = '1111239420 '         ");
query(" INSERT INTO users_profile
        SET         users_profile.fk_users      = 5                     ,
                    users_profile.email_address = 'prude@localhost'     ,
                    users_profile.created_at    = '1111239420 '         ");
query(" INSERT INTO users_profile
        SET         users_profile.fk_users      = 6                     ,
                    users_profile.email_address = 'banned@localhost'    ,
                    users_profile.created_at    = '1111239420 '         ");

query(" INSERT INTO users_stats
        SET         users_stats.fk_users = 1 ");
query(" INSERT INTO users_stats
        SET         users_stats.fk_users = 2 ");
query(" INSERT INTO users_stats
        SET         users_stats.fk_users = 3 ");
query(" INSERT INTO users_stats
        SET         users_stats.fk_users = 4 ");
query(" INSERT INTO users_stats
        SET         users_stats.fk_users = 5 ");
query(" INSERT INTO users_stats
        SET         users_stats.fk_users = 6 ");

query(" INSERT INTO users_settings
        SET         users_settings.fk_users = 1           ,
                    users_settings.show_nsfw_content  = 1 ");
query(" INSERT INTO users_settings
        SET         users_settings.fk_users = 2           ,
                    users_settings.show_nsfw_content  = 1 ");
query(" INSERT INTO users_settings
        SET         users_settings.fk_users = 3           ,
                    users_settings.show_nsfw_content  = 1 ");
query(" INSERT INTO users_settings
        SET         users_settings.fk_users = 4           ,
                    users_settings.show_nsfw_content  = 1 ");
query(" INSERT INTO users_settings
        SET         users_settings.fk_users = 5           ,
                    users_settings.show_nsfw_content  = 0 ,
                    users_settings.hide_tweets        = 1 ,
                    users_settings.hide_youtube       = 1 ,
                    users_settings.hide_google_trends = 1 ");
query(" INSERT INTO users_settings
        SET         users_settings.fk_users = 6           ");




///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Mass create users through fixtures

// Determine the number of users to generate
$user_count = mt_rand(500,1000);
for($i = 0 ; $i < $user_count; $i ++)
{
  // Generate random data
  $username     = ucfirst(fixtures_generate_data('string', 3, 15));
  $current_ip   = fixtures_generate_data('int', 0, 255).'.'.fixtures_generate_data('int', 0, 255).'.'.fixtures_generate_data('int', 0, 255).'.'.fixtures_generate_data('int', 0, 255);
  $email        = $username.'@localhost';
  $created_at   = mt_rand(1111239420, time());
  $last_visit   = mt_rand($created_at, time());
  $birthday     = (mt_rand(0,4) < 4) ? '0000-00-00' : mt_rand(1980, 2010).'-'.mt_rand(1,12).'-'.mt_rand(1,28);
  $languages    = (mt_rand(0,5) < 5) ? '' : 'EN';
  $languages   .= (mt_rand(0,5) < 5) ? '' : 'FR';
  $gender       = (mt_rand(0,5) < 5) ? '' : ucfirst(fixtures_generate_data('string', 2, 8));
  $lives_at     = (mt_rand(0,6) < 6) ? '' : ucfirst(fixtures_generate_data('string', 10, 15));
  $occupation   = (mt_rand(0,6) < 6) ? '' : ucfirst(fixtures_generate_data('string', 10, 15));
  $profile_text = (mt_rand(0,5) < 5) ? '' : ucfirst(fixtures_generate_data('text', 1, 10));

  // Check if the nickname was already generated
  $dcheck = mysqli_fetch_array(query("  SELECT  users.id
                                        FROM    users
                                        WHERE   users.nickname LIKE '$username' "));

  // Ensure nicknames don't get generated twice
  if(!$dcheck['id'])
  {
    // Generate the users
    query(" INSERT INTO users
            SET         users.nickname            = '$username'   ,
                        users.password            = ''            ,
                        users.last_visited_at     = '$last_visit' ,
                        users.current_ip_address  = '$current_ip' ");

    // Fetch the id of the generated users
    $user_id = query_id();

    // Generate the rest of the user data
    query(" INSERT INTO users_profile
            SET         users_profile.fk_users          = '$user_id'      ,
                        users_profile.email_address     = '$email'        ,
                        users_profile.created_at        = '$created_at '  ,
                        users_profile.birthday          = '$birthday'     ,
                        users_profile.spoken_languages  = '$languages'    ,
                        users_profile.gender            = '$gender'       ,
                        users_profile.lives_at          = '$lives_at'     ,
                        users_profile.occupation        = '$occupation'   ,
                        users_profile.profile_text      = '$profile_text' ");

    query(" INSERT INTO users_settings
            SET         users_settings.fk_users = '$user_id' ");

    query(" INSERT INTO users_stats
            SET         users_stats.fk_users = '$user_id' ");
  }
}