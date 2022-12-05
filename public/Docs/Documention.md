ToDoList
========

# Comment procéder pour apporter des amélioration à un projet :

## Créer une copie locale du projet en suivant le fichier README.md qui est à la racine de l'application

## Créer une Issue sur Github

## Créer une nouvelle branche Git avant de commencer à développer :
git checkout -b [nouvellebranche]

### Suivez le principe d'une branche par nouvelle fonctionnalité et n''hésitez pas a commiter régulièrement

### Créer de nouveaux tests si nécessaires et vérifiez avec phpunit que vous n'avez cassé aucun test existant.

### Lorsque vous aurez termimer votre développement et que tout fonctionnera comme il convient vérifier que vous respectez bien vous respectez le MVC(Modèle-vue-contrôleur) ainsi que les  normes :

#### PSR-1 que l'on pourrait résumer ainsi:

- Les fichiers DOIVENT utiliser uniquement les balises <?php et <?= .

- Les fichiers DOIVENT utiliser uniquement du code PHP en UTF-8 sans BOM.

- Les fichiers DEVRAIENT déclarer des symboles (classes, fonctions, constantes, etc.) OU causer un effet de bord (générer une sortie, modifier les paramètres .ini, etc.) mais ne DEVRAIENT PAS faire les deux.

- Les Namespaces et classes DOIVENT suivre un PSR “autoloading” [PSR-0, PSR-4].

- Les noms de classes DOIVENT être déclarés en UpperCamelCase.

- Les constantes de classes DOIVENT être déclarées en majuscules avec un séparateur underscore.

- Les noms de Méthodes DOIVENT être déclarés en camelCase.


#### PSR-4 avec ces spécification

- Le terme “classe” se réfère à toutes les classes, interfaces et traits, et autres structures similaires.

- Un nom de classe totalement qualifié a la forme suivante :

\<NamespaceName>(\<SubNamespaceNames>)*\<ClassName>
- Un nom de classe totalement qualifié DOIT avoir un namespace principal, également appelé “vendor namespace”.

- Un nom de classe totalement qualifié PEUT avoir un ou plusieurs nom de "sous namespaces".

- Un nom de classe totalement qualifié DOIT se terminer par un nom de classe.

- Les underscores n'ont pas de signification dans le nom de classe totalement qualifié.

- Les caractères alphabétiques dans le nom de classe totalement qualifié PEUVENT être toute combinaison de majuscules et minuscules.

- Tous les noms de classes DOIVENT être référencés dans un modèle sensible à la casse.

- Lors du chargement d'un fichier qui correspond à un nom de classe totalement qualifié…

- Une série continue d'un ou plusieurs namespaces et sous namespaces, sans compter le séparateur d'espace de noms principal, dans le nom de classe pleinement qualifié (un «préfixe d'espace de noms») correspond à au moins un «répertoire de base».

- Les noms de sous-namespaces contigus après le «préfixe d'espace de noms» correspondent à un sous-répertoire dans un «répertoire de base», dans lequel les séparateurs d'espaces de noms représentent des séparateurs de répertoires. Le nom du sous-répertoire DOIT correspondre à la casse des noms de sous-namespaces.

- Le nom de la classe correspond à un nom de fichier se terminant par .php. Le nom de fichier DOIT correspondre à la casse du nom de classe.

- Les implémentations d'autoloader NE DOIVENT PAS lancer d'exceptions, NE DOIVENT PAS déclencher d'erreurs de quelque niveau que ce soit et NE DEVRAIENT PAS renvoyer de valeur.

source : `https://nouvelle-techno.fr/articles/bonnes-pratiques-php-psr-1-et-psr-4`

## Faites un push avec la commande :
git push origin [nom de la branche]

## Sur github faites un Pull Request et liez-la au l'issue créer