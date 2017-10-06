/******************************************************************************************************************************************
**                                                                                                                                       **
**                                                       /js/register/register.js                                                        **
**                                                   Utilisé avec /pages/user/register                                                   **
**                                                                                                                                       **
******************************************************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Fonction permettant de valider que tout est bien rempli avant de lancer la création d'un compte
// chemin est le chemin jusqu'à la racine du site
//
// Utilisation: onclick="creer_compte('<?=$chemin?>');"

function creer_compte(chemin)
{
  // On part du principe que rien n'est erroné
  erreur = 0;

  // On vérifie que tout soit bien rempli
  if(!dynamique_validate_input("register_pseudo","label_register_pseudo"))
    erreur = 1
  if(!dynamique_validate_input("register_pass_1","label_register_pass_1"))
    erreur = 1
  if(!dynamique_validate_input("register_pass_2","label_register_pass_2"))
    erreur = 1
  if(!dynamique_validate_input("register_email","label_register_email"))
    erreur = 1
  if(!dynamique_validate_input("register_captcha","label_register_captcha"))
    erreur = 1;

  // On veut respecter des longueurs minimum pour le pseudo & pass aussi
  document.getElementById("label_register_pseudo").classList.remove('negatif');
  document.getElementById("label_register_pseudo").classList.remove('texte_blanc');
  document.getElementById("label_register_pass_1").classList.remove('negatif');
  document.getElementById("label_register_pass_1").classList.remove('texte_blanc');
  if(document.getElementById("register_pseudo").value.length < 3)
  {
    document.getElementById("label_register_pseudo").classList.add('negatif');
    document.getElementById("label_register_pseudo").classList.add('texte_blanc');
    erreur = 1;
  }
  if(document.getElementById("register_pseudo").value.length > 18)
  {
    document.getElementById("label_register_pseudo").classList.add('negatif');
    document.getElementById("label_register_pseudo").classList.add('texte_blanc');
    erreur = 1;
  }
  if(document.getElementById("register_pass_1").value.length < 6)
  {
    document.getElementById("label_register_pass_1").classList.add('negatif');
    document.getElementById("label_register_pass_1").classList.add('texte_blanc');
    erreur = 1;
  }

  // On veut s'assurer que pseudo et pass soient identiques
  document.getElementById("label_register_pass_2").classList.remove('negatif');
  document.getElementById("label_register_pass_2").classList.remove('texte_blanc');
  if(document.getElementById("register_pass_1").value != document.getElementById("register_pass_2").value)
  {
    document.getElementById("label_register_pass_2").classList.add('negatif');
    document.getElementById("label_register_pass_2").classList.add('texte_blanc');
    erreur = 1;
  }

  // Et on va vérifier que la réponse aux questions soit bonne
  document.getElementById("label_register_question_1").classList.remove('negatif');
  document.getElementById("label_register_question_1").classList.remove('texte_blanc');
  var temp = document.querySelectorAll('input[name=register_question_1]:checked');
  var temp = (temp.length > 0) ? temp[0].value : null;
  if(temp != 2)
  {
    document.getElementById("label_register_question_1").classList.add('negatif');
    document.getElementById("label_register_question_1").classList.add('texte_blanc');
    erreur = 1;
  }
  document.getElementById("label_register_question_2").classList.remove('negatif');
  document.getElementById("label_register_question_2").classList.remove('texte_blanc');
  var temp = document.querySelectorAll('input[name=register_question_2]:checked');
  var temp = (temp.length > 0) ? temp[0].value : null;
  if(temp != 2)
  {
    document.getElementById("label_register_question_2").classList.add('negatif');
    document.getElementById("label_register_question_2").classList.add('texte_blanc');
    erreur = 1;
  }
  document.getElementById("label_register_question_3").classList.remove('negatif');
  document.getElementById("label_register_question_3").classList.remove('texte_blanc');
  var temp = document.querySelectorAll('input[name=register_question_3]:checked');
  var temp = (temp.length > 0) ? temp[0].value : null;
  if(temp != 2)
  {
    document.getElementById("label_register_question_3").classList.add('negatif');
    document.getElementById("label_register_question_3").classList.add('texte_blanc');
    erreur = 1;
  }
  document.getElementById("label_register_question_4").classList.remove('negatif');
  document.getElementById("label_register_question_4").classList.remove('texte_blanc');
  var temp = document.querySelectorAll('input[name=register_question_4]:checked');
  var temp = (temp.length > 0) ? temp[0].value : null;
  if(temp != 1)
  {
    document.getElementById("label_register_question_4").classList.add('negatif');
    document.getElementById("label_register_question_4").classList.add('texte_blanc');
    erreur = 1;
  }

  // Si y'a une erreur, on s'arrête là
  if(erreur)
    return;
  else
    document.getElementById('register_formulaire').submit();
}