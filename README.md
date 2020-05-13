# Paprika  

**Paprika** est un projet personnel qui permet à un patron de petite Entreprise de gérer au mieux ses employés  

Il y a 3 types de profil chez Paprika : 

1. L'employé :  
    * Il peut accéder aux missions qui lui sont confiées  

2. Le chef d'équipe (leader) :
    * Il peut dispatcher les missions aux différents employés  

3. Le patron : 
    * Il peut gérer le CRUD de ses employés et celui des actualitées  

Les 3 profils ont en commun le fait de pouvoir changer leur mot de passe et d'accéder aux dernières actualitées de l'Entreprise.  
___
Lors de l'ajout d'un employé, le patron devra indiquer son nom, son prénom, si c'est un homme et si il est leader.  
Si l'employé n'est pas leader, il faudra indiqué dans quelle équipe il travaillera en sélectionnant un chef d'équipe.  
Si il est leader alors une nouvelle équipe sera automatiquement créée et il ne restera qu'à introduire de nouveaux employés
Une fois ajouté, un email sera automatiquement créé avec pour base : nom.prenom@paprika.com.  
Idem concernant le mot de passe qui sera par défaut "paprika". L'employé pourra le changer dès sa première connection  
___  
## Installation

Afin d'utiliser ce projet vous devrez :  
* Effectuer un git clone du projet
* Vous placer à la racine du projet et exécuter : 
```
composer install
```
* Une fois l'installation terminée, vous devrez effectuer les modifications nécessaire dans le fichier .env afin de créer votre BDD.
* Dès que les informations ont été renseignés, veuillez exécuter :
```
php bin/console doctrine:create:database
php bin/console make:migration
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load -n
```



