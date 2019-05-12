/******************************************************************************************************************************************
**                                                                                                                                       **
**                                 Fonction écrivant du texte dans un textarea pour la page d'erreur 404                                 **
**                                                                                                                                       **
*******************************************************************************************************************************************
**                                                                                                                                       **
**  Exemple d'utilisation :                                                                                                              **
**                                                                                                                                       **
**  <body id="body" onLoad="ecrire_404();">                                                                                              **
**                                                                                                                                       **
*******************************************************************************************************************************************
**                                                                                                                                       **
**         L'idée d'origine vient de ThArGos. Je ne sais pas s'il l'avait réalisé lui-même ou s'il avait pris du code tout fait.         **
**                   Vu qu'il ne se sert plus d'une 404 du genre sur son site web, je lui ai piqué l'idée (géniale) :)                   **
**                                                                                                                                       **
******************************************************************************************************************************************/

// On commence par mettre le texte à display dans un array
var texte404=new Array(
"",
"",
"",
"In A.D. 2101",
"War was beginning.",
"",
"",
"",
"Captain: What happen?",
"Mechanic: Somebody set up us the bomb.",
"Operator: We get signal.",
"Captain: What!!",
"Operator: Main screen turn on.",
"Captain: It's you!!",
"",
"404: How are you gentlemen!!",
"404: All your errors are belong to us.",
"404: You are on the way to being lost.",
"Captain: What you say!!",
"404: You have no chance to survive make your time.",
"404: Ha ha ha ha...",
"",
"Operator: Captain!!",
"Captain: Take off every 'Zig'!!",
"Captain: You know what you doing.",
"Captain: Move 'Zig'.",
"Captain: For great justice.",
"",
"",
"",
"",
"",
"",
"",
"Erreur 404 : 'Zig' introuvable",
"",
"",
""
);

// On initialise les variables
var index=0; text_pos=0;
var str_length=texte404[0].length;
var contents, row;

// Puis on parcourt l'array
function ecrire_404()
{
  // Initialisation
  contents='';
  row=Math.max(0,index-7);
  while(row<index)
    contents += texte404[row++] + '\r\n';

  // On print dans le textarea
  document.getElementById('text404').value = contents + texte404[index].substring(0,text_pos) + "_";
  if(text_pos++==str_length)
  {
    text_pos=0;
    index++;
    if(index!=texte404.length)
    {
      // On passe à la ligne suivante
      str_length=texte404[index].length;
      setTimeout("ecrire_404()",500);
    }
  }
  else
    // On passe au caractère suivant
    setTimeout("ecrire_404()",40);

}