<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) === str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../404")); die(); }




/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                           RANDOM DUMMY DATA GENERATION                                            */
/*                                                                                                                   */
/*********************************************************************************************************************/
/*                                                                                                                   */
/*  fixtures_lorem_ipsum              Generates a lorem ipsum like sentence.                                         */
/*  fixtures_generate_data            Generates SQL safe random data.                                                */
/*                                                                                                                   */
/*  fixtures_fetch_random_id          Finds a random legitimate id in a table.                                       */
/*  fixtures_fetch_random_value       Finds a random legitimate entry in a table.                                    */
/*                                                                                                                   */
/*  fixtures_check_entry              Check if a table entry already exists.                                         */
/*                                                                                                                   */
/*  fixtures_query_id                 Returns the ID of the latest inserted row.                                     */
/*                                                                                                                   */
/*********************************************************************************************************************/

/**
 * Generates a lorem ipsum like sentence.
 *
 * @param   int     $word_count The number of words the paragraph should contain.
 *
 * @return  string  The randomly generated paragraph.
 */

function fixtures_lorem_ipsum( int $word_count ) : string
{
  // Random words to use in the lorem genertion
  $words = array('lorem', 'lorem', 'lorem', 'ipsum', 'ipsum', 'ipsum', 'dolor', 'dolor', 'sit', 'sit', 'amet', 'consectetur', 'adipisicing', 'elit', 'sed', 'sed', 'do', 'eiusmod', 'tempor', 'incididunt', 'ut', 'labore', 'et', 'et', 'et', 'dolore', 'magna', 'aliqua', 'exercitationem', 'perferendis', 'perspiciatis', 'laborum', 'eveniet', 'sunt', 'iure', 'nam', 'nam', 'nobis', 'eum', 'cum', 'officiis', 'excepturi', 'odio', 'consectetur', 'quasi', 'aut', 'quisquam', 'vel', 'eligendi', 'itaque', 'non', 'odit', 'tempore', 'quaerat', 'dignissimos', 'facilis', 'neque', 'nihil', 'expedita', 'vitae', 'vero', 'ipsum', 'nisi', 'animi', 'cumque', 'pariatur', 'velit', 'modi', 'natus', 'iusto', 'eaque', 'sequi', 'illo', 'sed', 'ex', 'et', 'voluptatibus', 'tempora', 'veritatis', 'ratione', 'assumenda', 'incidunt', 'nostrum', 'placeat', 'aliquid', 'fuga', 'fuga', 'provident', 'praesentium', 'rem', 'necessitatibus', 'suscipit', 'adipisci', 'quidem', 'possimus', 'voluptas', 'debitis', 'sint', 'accusantium', 'unde', 'sapiente', 'voluptate', 'qui', 'aspernatur', 'laudantium', 'soluta', 'amet', 'quo', 'aliquam', 'saepe', 'culpa', 'libero', 'ipsa', 'dicta', 'reiciendis', 'nesciunt', 'doloribus', 'autem', 'impedit', 'minima', 'maiores', 'repudiandae', 'ipsam', 'obcaecati', 'ullam', 'enim', 'totam', 'totam', 'delectus', 'ducimus', 'quis', 'voluptates', 'dolores', 'molestiae', 'harum', 'dolorem', 'quia', 'voluptatem', 'molestias', 'magni', 'distinctio', 'omnis', 'illum', 'dolorum', 'voluptatum', 'ea', 'quas', 'quam', 'corporis', 'quae', 'blanditiis', 'atque', 'deserunt', 'laboriosam', 'earum', 'consequuntur', 'hic', 'cupiditate', 'quibusdam', 'accusamus', 'ut', 'rerum', 'error', 'minus', 'eius', 'ab', 'ad', 'nemo', 'fugit', 'officia', 'at', 'in', 'id', 'quos', 'reprehenderit', 'numquam', 'iste', 'fugiat', 'sit', 'inventore', 'beatae', 'repellendus', 'magnam', 'recusandae', 'quod', 'explicabo', 'doloremque', 'aperiam', 'consequatur', 'asperiores', 'commodi', 'optio', 'dolor', 'labore', 'temporibus', 'repellat', 'veniam', 'architecto', 'est', 'est', 'est', 'esse', 'mollitia', 'nulla', 'a', 'similique', 'eos', 'alias', 'dolore', 'tenetur', 'deleniti', 'porro', 'facere', 'maxime', 'corrupti');

  // Generate a random lorem ipsum
  $lorem_ipsum = '';
  for ($i = 0; $i < $word_count ; $i++)
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
 * @param   string  $type                     Type of data to generate ('int', 'digits', 'string', 'sentence', 'text').
 * @param   int     $min                      The minimum length or amount of data to be generated.
 * @param   int     $max                      The maximum length or amount of data to be generated.
 * @param   bool    $no_periods   (OPTIONAL)  If set, disables periods at the end of sentences.
 * @param   bool    $no_spaces    (OPTIONAL)  If set, strings will not contain spaces.
 *
 * @return  mixed                             The randomly generated content.
 */

function fixtures_generate_data(  string  $type               ,
                                  int     $min                ,
                                  int     $max                ,
                                  bool    $no_periods = false ,
                                  bool    $no_spaces  = false ) : mixed
{
  // Don't generate aything if the min/max values are incorrect
  if($max < 1 || $min > $max)
    return '';

  // Random int between $min and $max
  if($type === 'int')
    return (int)mt_rand($min, $max);

  // Random string of digits
  if($type === 'digits')
  {
    $digits  = '';
    $max_length   = mt_rand($min, $max);
    for ($i = 0; $i < $max_length; $i++)
      $digits .= mt_rand(0,9);
    return $digits;
  }

  // Random string
  if($type === 'string')
  {
    $characters   = "aaaaaabcdeeeeeeefghiiiiiijkllmmnnoooooopqrrsssttuuvwxyz";
    if(!$no_spaces)
      $characters .= "      ";
    $max_length   = mt_rand($min, $max);
    $string  = '';
    for ($i = 0; $i < $max_length; $i++)
      $string .= $characters[mt_rand(0, (strlen($characters) - 1))];
    return $string;
  }

  // Random paragraph
  if($type === 'sentence')
  {
    $sentence = ucfirst(fixtures_lorem_ipsum(mt_rand($min, $max), 1));
    return ($no_periods) ? $sentence : $sentence.'.';
  }

  // Random text
  if($type === 'text')
  {
    $text = '';
    $max_length = mt_rand($min, $max);
    for ($i = 0; $i < $max_length; $i++)
    {
      $text .= ($i) ? '\r\n\r\n' : '';
      $text .= ucfirst(fixtures_lorem_ipsum(mt_rand(100, 400), 1)).'.';
    }
    return $text;
  }
}




/**
 * Finds a random legitimate id in a table.
 *
 * @param   string  $table  The name of the table from which to fetch a random id.
 *
 * @return  int             The ID of an existing entry.
 */

function fixtures_fetch_random_id( string $table ) : int
{
  // Fetch an ID in the database
  $drand = query("  SELECT    $table.id AS 'u_id'
                    FROM      $table
                    ORDER BY  RAND()
                    LIMIT     1 ",
                    fetch_row: true);

   // Return the ID
   return $drand['u_id'];
}




/**
 * Finds a random legitimate entry in a table.
 *
 * @param   string  $table  The name of the table from which to fetch a random entry.
 * @param   string  $field  The name of the field from which the entry will be taken.
 *
 * @return  mixed           The value of an existing field.
 */

function fixtures_fetch_random_value( string  $table  ,
                                      string  $field  ) : mixed
{
  // Fetch an entry in the database
  $drand = query("  SELECT    $table.$field AS 'u_value'
                    FROM      $table
                    ORDER BY  RAND()
                    LIMIT     1 ",
                    fetch_row: true);

   // Return the ID
   return $drand['u_value'];
}




/**
 * Check if a table entry already exists.
 *
 * @param   string  $table  The name of the table to check.
 * @param   string  $field  The name of the field to check.
 * @param   mixed   $value  The value of the field to check.
 *
 * @return  bool            Whether the entry already exists.
 */

function fixtures_check_entry(  string  $table  ,
                                string  $field  ,
                                mixed   $value  ) : bool
{
  // Check for the entry in the database
  $qrand = query("  SELECT    $table.$field AS 'u_value'
                    FROM      $table
                    WHERE     $table.$field LIKE '$value' ");

   // Return whether the entry already exists
   return query_row_count($qrand);
}



/**
 * Returns the ID of the latest inserted row.
 *
 * @return  int   The ID of the latest inserted row.
 */

function fixtures_query_id() : int
{
  return mysqli_insert_id($GLOBALS['db']);
}
