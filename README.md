# YouCard

Projet de gestion de cartes à collectionner. Dans le carde d'une formation au framework Symfony Avancée.  
Le but était de faire le site en **One Page** grâce au JQuery.

Le projet à été réalisé avec :

- HTML/CSS
- PHP/Symfony 5
- Git 
- Bootstrap
- MySQL


### Installation

- Configurer le fichier **.env**
- Créer un base de donnée au nom de **youcard**
- Mettre à jour la base de donnée avec le script **youcard.sql**


### Accès user

- E-mail : joshua@gmail.com
- Password : skywalk
 
 ---
 
### Améliorations

- Ajout d'image pour les cartes qui n'ont pas d'images
- Les images peuvent être vide
- Affichage de la liste en dessous du formulaire 
- Ajout de confirmation de **Password**
- Rareté de **Card** avec les changements de couleurs selon ça rareté
- Disposition de l'ajout des cartes dans un deck 
- Suppression des cartes dans un deck par un clique
- Modification et Suppression des entitées **Card**, **Deck**, **Faction** & **Rareté**
- Les images exportées sont en base64
- Mise en place d'un Loader au chargement


### Informations

- Evitez de changer les routes via la barre d'URL.  
- Si la navbar se duplique, veuillez actualiser la page **F5**, et faire comme s'il ne s'était rien passé.  
- Pour actualiser la page, cliquez sur le logo **YouCard** dans la navbar ou encore aller dans la route **/home** ou **/**.  
- Si vous vous retrouvez dans une autre route que **/home** ou **/**, suivez la procedure d'actualisation.
- J'ai fais en sorte que les éléments des listes soient cliquable, afin de naviguer plus simplement.      
- N'oubliez pas de masquer la barre de Symfony, en cliquant sur la croix en bas à droite.


### Avertissement

Lorsque l'on supprime une **Faction**, **toute les cartes de la factions seront supprimé**.  
Lors de la modification d'une carte, si on n'ajoute pas de nouvelle image, il gardera l'ancienne.  
La suppréssion de l'entité **Rarety** n'a pas été mis en place car une carte doit avoir une rareté. 

---

#### Note :

Malheuresement je n'ai pas pu me pencher d'avantage sur le front, dû au manque de temps. 
Etant donnée que je suis en stage et que je travail le soir.

Je suis tout de même ouvert à toute suggestion d'amelioration et de correction dans les commentaires.

Merci.  