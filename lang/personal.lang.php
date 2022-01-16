<?php /***************************************************************************************************************/
/*                                                                                                                   */
/*                            THIS PAGE CAN ONLY BE RAN IF IT IS INCLUDED BY ANOTHER PAGE                            */
/*                                                                                                                   */
// Include only /*****************************************************************************************************/
if(substr(dirname(__FILE__),-8).basename(__FILE__) == str_replace("/","\\",substr(dirname($_SERVER['PHP_SELF']),-8).basename($_SERVER['PHP_SELF']))) { exit(header("Location: ./../../404")); die(); }


/*********************************************************************************************************************/
/*                                                                                                                   */
/*                                                  CV & PORTFOLIO                                                   */
/*                                                                                                                   */
/*********************************************************************************************************************/

// CV: Header
___('cv_name',    'EN', "Éric Bisceglia");
___('cv_name',    'FR', "Éric Bisceglia");
___('cv_title_1', 'EN', "Digital transformer");
___('cv_title_1', 'FR', "Transformation numérique");
___('cv_title_2', 'EN', "Technical manager");
___('cv_title_2', 'FR', "Stratégie & Management");
___('cv_summary', 'EN', <<<EOT
Lives in Paris, France<br>
Born august 26th, 1988<br>
Active in tech since 2007<br>
E-mail: {{link++|mailto:bisceglia.eric@gmail.com|bisceglia.eric@gmail.com||}}<br>
{{link++|cv?french|Click here for the french version|bold underlined|}}
EOT
);
___('cv_summary', 'FR', <<<EOT
Basé à Paris, France<br>
Né le 26 août 1988<br>
Actif dans la tech depuis 2007<br>
E-mail: {{link++|mailto:bisceglia.eric@gmail.com|bisceglia.eric@gmail.com||}}<br>
{{link++|cv?english|Click here for the english version|bold underlined|}}
EOT
);


// CV: Career
___('cv_career',              'EN', "Career");
___('cv_career',              'FR', "Carrière");
___('cv_career_years',        'EN', <<<EOT
2020<br>
2018<br>
2016<br>
2015<br>
2010<br>
2009<br>
2007
EOT
);
___('cv_career_years',        'FR', <<<EOT
2020<br>
2018<br>
2016<br>
2015<br>
2010<br>
2009<br>
2007
EOT
);
___('cv_career_companies',    'EN', <<<EOT
Freelance strategy consulting<br>
{{external|https://www.wynd.eu/fr/|Wynd}} - Head of TMA<br>
{{external|http://www.mtd-finance.fr/|MTD Finance}} - Head of technology<br>
Freelance technical consulting<br>
{{external|http://www.mtd-finance.fr/|MTD Finance}} - Lead developer<br>
{{external|http://www.mecamatic.fr/|Mécamatic}} - Solo full stack developer<br>
Freelance game development
EOT
);
___('cv_career_companies',    'FR', <<<EOT
Consultant stratégie freelance<br>
{{external|https://www.wynd.eu/fr/|Wynd}} - Responsable TMA<br>
{{external|http://www.mtd-finance.fr/|MTD Finance}} - Responsable informatique<br>
Consultant technique freelance<br>
{{external|http://www.mtd-finance.fr/|MTD Finance}} - Lead développeur<br>
{{external|http://www.mecamatic.fr/|Mécamatic}} - Développeur full stack<br>
Développement de jeux en freelance
EOT
);
___('cv_career_descriptions', 'EN', <<<EOT
Expertise - Processes - Problem solving<br>
Management - Processes - Budgets<br>
Product management - Outsourcing<br>
Expertise - Problem solving<br>
PHP - MySQL - JavaScript<br>
Perl - FileMaker - AppleScript<br>
Flash - ActionScript
EOT
);
___('cv_career_descriptions', 'FR', <<<EOT
Expertise - Process - Pérennisation<br>
Management - Process - Budgets<br>
Gestion de produit - Externalisation<br>
Expertise - Résolution de problèmes<br>
PHP - MySQL - JavaScript<br>
Perl - FileMaker - AppleScript<br>
Flash - ActionScript
EOT
);


// CV: Skills
___('cv_skills',          'EN', "Skillset");
___('cv_skills',          'FR', "Compétences");
___('cv_skills_name',     'EN', <<<EOT
Strengths<br>
Technical expertise<br>
Technical management<br>
Fields of work<br>
Languages
EOT
);
___('cv_skills_name',     'FR', <<<EOT
Points forts<br>
Expertise technique<br>
Management technique<br>
Domaines de compétence<br>
Langues parlées
EOT
);
___('cv_skills_details',  'EN', <<<EOT
Experience ; Communication ; Customer facing ; Action plans ; Zen at all times<br>
Digital transformation ; Software & database architecture ; GDPR & Privacy laws<br>
Operational processes ; ITIL ; Human resources ; Budget planning ; Agility<br>
Technology ; Finance ; Accounting ; Legal ; Steel industry ; Retail<br>
Native french ; Fluent english ; Basic german, russian, spanish
EOT
);
___('cv_skills_details',  'FR', <<<EOT
Expérience ; Communication ; Facing client ; Plans d'action ; Zen à toute épreuve<br>
Transformation numérique ; Architecture logicielle ; RGPD & Vie privée<br>
Process opérationnels ; ITIL ; Ressources humaines ; Budgets ; Agilité<br>
Technologie ; Finance ; Patrimonial ; Comptabilité ; Industrie ; Retail<br>
Français natif ; Bilingue anglais ; Bases d'allemand, russe, espagnol
EOT
);
___('cv_skills_mobile',   'EN', <<<EOT
Experience ; Communication ; Customer facing<br>
Digital transformation ; GDPR & Privacy laws<br>
Operational processes ; ITIL ; Human resources<br>
Technology ; Finance ; Accounting ; Retail<br>
Native french ; Fluent english
EOT
);
___('cv_skills_mobile',   'FR', <<<EOT
Expérience ; Communication ; Facing client<br>
Transformation numérique ; RGPD & Vie privée<br>
Process opérationnels ; ITIL ; Agilité<br>
Technologie ; Finance ; Patrimonial ; Retail<br>
Français natif ; Bilingue anglais
EOT
);


// CV: Afterword
___('cv_afterword',   'EN', 'Personal afterword');
___('cv_afterword',   'FR', 'Message personnel');
___('cv_afterword_1', 'EN', <<<EOT
After a decade as a developer, I changed my career path towards C-level management and technical expertise, mostly in startups trying to stabilize their growth and their activity.
EOT
);
___('cv_afterword_1', 'FR', <<<EOT
Après avoir été développeur pendant une décennie, j'ai changé la trajectoire de ma carrière vers du management exécutif et de la transmisison d'expertise technique, principalement au sein de startups cherchant à stabiliser leur croissance et pérenniser leur activité.
EOT
);
___('cv_afterword_2', 'EN', <<<EOT
Ethics are key to my approach of work. I see a strong link between embracing diversity and successful projects. Individual growth without elevating others is collective failure.
EOT
);
___('cv_afterword_2', 'FR', <<<EOT
Mon approche du monde du travail est indissociable de mes valeurs éthiques. Il est important pour moi de faire grandir mes équipes, humainement comme professionnellement, et cela nécessite un contexte sain.
EOT
);
___('cv_afterword_3', 'EN', <<<EOT
Other than computer programming (still my main passion), I am passionate about literature, history, social and political sciences, ergonomics and game design. I also manage the archives of my father, photographer and writer {{external|https://www.jazzhot.net/PBEvents.asp?ItmID=23592|Jacques Bisceglia}}.
EOT
);
___('cv_afterword_3', 'FR', <<<EOT
Outre la programmation informatique (toujours une passion forte), je suis passionné de littérature, histoire, sciences sociales et politiques, ainsi que par l'ergonomie et le game design. Je gère les archives photographiques et littéraires de mon père, {{external|https://www.jazzhot.net/PBEvents.asp?ItmID=23592|Jacques Bisceglia}}.
EOT
);
___('cv_afterword_4', 'EN', <<<EOT
Feel free to contact me by mail at {{link++|mailto:bisceglia.eric@gmail.com|bisceglia.eric@gmail.com|bold|}} and to add me on {{external|https://www.linkedin.com/in/eric-bisceglia-82bb91173/|LinkedIn}}.
EOT
);
___('cv_afterword_4', 'FR', <<<EOT
N'hésitez pas à me contacter par mail : {{link++|mailto:bisceglia.eric@gmail.com|bisceglia.eric@gmail.com|bold|}} ainsi qu'à m'ajouter sur {{external|https://www.linkedin.com/in/eric-bisceglia-82bb91173/|LinkedIn}}.
EOT
);