            Modifier le mot de passe du modérateur
#Pour commencer vous devez posseder les codes d'accés ssh du serveur.
1.Supprimer le cache et les logs avec les commandes suivante
    rm -rf app/cache/* et rm -rf app/logs/*
2.Pour modifier le mot de passe du modérateur il faut utiliser la commande
    php app/console fos:user:change-password
  suivi du nom du modérateur la commande complète ressemble donc à ça
    php app/console fos:user:change-password nom_modérateur
3.Le message suivant s'affiche
    Please enter the new password:
4.Entrez donc le nouveau mot de passe à la suite comme cela
    Please enter the new password: nouveau_mot_de_passe
5.Si le message ci-dessous s'affiche c'est que le mot de passe à bien était modifié
    Changed password for user nom_modérateur
6.Supprimer pour une deuxieme fois le cache et les logs avec les commandes suivante
    rm -rf app/cache/* et rm -rf app/logs/*
