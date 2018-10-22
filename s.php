<?php /***********************************************************************************************************************************/
/*                                                                                                                                       */
/*                                                              REDIRECTIONS                                                             */
/*                                                                                                                                       */
/*****************************************************************************************************************************************/
/* Cette page sert uniquement à effectuer des redirections vers d'autres pages, afin de créer des alias avec des URL plus courtes.       */
/*****************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Profils publics

if(isset($_GET['u']))
  exit(header("Location: ./pages/user/user?id=".intval($_GET['u'])));


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Activité récente

if(isset($_GET['a']))
  exit(header("Location: ./pages/nobleme/activite"));


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Qui est en ligne

if(isset($_GET['o']))
  exit(header("Location: ./pages/nobleme/online"));


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Forum

if(isset($_GET['f']))
{
  if(!intval($_GET['f']))
    exit(header("Location: ./pages/forum/index"));
  else
    exit(header("Location: ./pages/forum/sujet?id=".intval($_GET['f'])));
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Rencontres IRL

if(isset($_GET['irl']))
{
  if(!intval($_GET['irl']))
    exit(header("Location: ./pages/irl/index"));
  else
    exit(header("Location: ./pages/irl/irl?id=".intval($_GET['irl'])));
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// IRC

if(isset($_GET['irc']))
  exit(header("Location: ./pages/irc/index"));


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Miscellanées

if(isset($_GET['m']))
  exit(header("Location: ./pages/quotes/quote?id=".intval($_GET['m'])));


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Tâches

if(isset($_GET['t']))
  exit(header("Location: ./pages/todo/index?id=".intval($_GET['t'])));


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Devblogs

if(isset($_GET['d']))
  exit(header("Location: ./pages/devblog/devblog?id=".intval($_GET['d'])));


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Code de conduite

if(isset($_GET['coc']))
  exit(header("Location: ./pages/doc/coc"));


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Coin des écrivains

if(isset($_GET['e']))
{
  if(!intval($_GET['e']))
    exit(header("Location: ./pages/ecrivains/index"));
  else
    exit(header("Location: ./pages/ecrivains/texte?id=".intval($_GET['e'])));
}
if(isset($_GET['ec']))
{
  exit(header("Location: ./pages/ecrivains/concours?id=".intval($_GET['ec'])));
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Encyclopédie de la culture web

if(isset($_GET['w']))
{
  if(!intval($_GET['w']))
    exit(header("Location: ./pages/nbdb/web"));
  else
    exit(header("Location: ./pages/nbdb/web?id=".intval($_GET['w'])));
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Images de l'encyclopédie de la culture web

if(isset($_GET['wi']))
  exit(header("Location: ./pages/nbdb/web_image?id=".intval($_GET['wi'])));


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Dictionnaire de la culture web

if(isset($_GET['wd']))
{
  if(!intval($_GET['wd']))
    exit(header("Location: ./pages/nbdb/web_dictionnaire"));
  else
    exit(header("Location: ./pages/nbdb/web_dictionnaire?id=".intval($_GET['wd'])));
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Si on a aucune rediretion, on redirige vers la liste des raccourcis

exit(header("Location: ./pages/doc/raccourcis"));