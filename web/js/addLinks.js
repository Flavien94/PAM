$(document).ready(function() {
   // On récupère la balise <div> en question qui contient l'attribut « data-prototype » qui nous intéresse.
   var $container = $('div#event_eventbundle_event_uploadedLinks');

   // On ajoute un lien pour ajouter une nouvelle catégorie
   var $addLink = $('<a href="#" id="add_links" class="btn btn-default btn-add-link">Ajouter un lien</a>');
   $container.append($addLink);

   // On ajoute un nouveau champ à chaque clic sur le lien d'ajout.
   $addLink.click(function(e) {
     addLinks($container);
     e.preventDefault(); // évite qu'un # apparaisse dans l'URL
     return false;
   });

   // On définit un compteur unique pour nommer les champs qu'on va ajouter dynamiquement
   var index = $container.find(':input').length;

   // On ajoute un premier champ automatiquement s'il n'en existe pas déjà un (cas d'une nouvelle annonce par exemple).
   if (index == 0) {
    //  addLinks($container);
   } else {
     // Pour chaque catégorie déjà existante, on ajoute un lien de suppression
     $container.children('div').each(function() {
       addDeleteLink($(this));
     });
   }

   // La fonction qui ajoute un formulaire Categorie
   function addLinks($container) {
     // Dans le contenu de l'attribut « data-prototype », on remplace :
     // - le texte "__name__label__" qu'il contient par le label du champ
     // - le texte "__name__" qu'il contient par le numéro du champ
     var $prototype = $($container.attr('data-prototype').replace(/__name__label__/g, 'Lien n°' + (index+1))
         .replace(/__name__/g, index));

     // On ajoute au prototype un lien pour pouvoir supprimer la catégorie
     addDeleteLink($prototype);

     // On ajoute le prototype modifié à la fin de la balise <div>
     $container.append($prototype);

     // Enfin, on incrémente le compteur pour que le prochain ajout se fasse avec un autre numéro
     index++;
   }

   // La fonction qui ajoute un lien de suppression d'une catégorie
   function addDeleteLink($prototype) {
     // Création du lien
     $deleteLink = $('<a href="#" class="btn btn-danger btn-delete">Supprimer</a>');

     // Ajout du lien
     $prototype.append($deleteLink);

     // Ajout du listener sur le clic du lien
     $deleteLink.click(function(e) {
       $prototype.remove();
       e.preventDefault(); // évite qu'un # apparaisse dans l'URL
       return false;
     });
   }
 });
