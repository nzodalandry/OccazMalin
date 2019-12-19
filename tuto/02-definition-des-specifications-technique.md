# OccazMalin
> Site de petites annonces

## 2. Définition des spécifications technique

Dans ce chapitre, nous allons définir la base de données et les classes du site.

- Base de données
- Routes
- Controleurs


### 2.1 Base de données

Nous allons définir les tables, champs et propriétés de la base de données et leurs equivalent Symfony.


#### 2.1.1 Users

Gestion des utilisateurs membre de l'application.


| Propriété                 | Typage Symfony    | Typage SQL    | Null ?    | Défaut    |
|---------------------------|-------------------|---------------|-----------|-----------|
| id                        | uuid              | char(36)      | -         |           |
| email                     | string 180        | varchar(180)  | no        |           |
| password                  | string 255        | varchar(255)  | no        |           |
| roles                     | json              | longtext/json | no        |           |
| firstname                 | string 40         | varchar(40)   | no        |           |
| lastname                  | string 40         | varchar(40)   | no        |           |
| screenname                | string 40         | varchar(40)   | no        |           |
| phone                     | string 20         | varchar(20)   | yes       |           |
| birthday                  | datetime          | datetime      | no        |           |
| language                  | string 2          | char(2)       | no        |           |
| isActive                  | boolean           | tinyint(1)    | no        | false     |
| activationToken           | string 255        | varchar(255)  | yes       |           |
| passwordToken             | string 255        | varchar(255)  | yes       |           |
| passwordTokenExpiration   | datetime          | datetime      | yes       |           |
| picture                   | ManyToOne         | int(11)       | yes       |           |
| address                   | ManyToOne         | int(11)       | yes       |           |




#### 2.1.2 Ads 

Gestion des annonces de l'application.


| Propriété                 | Typage Symfony    | Typage SQL    | Null ?    | Défaut    |
|---------------------------|-------------------|---------------|-----------|-----------|
| id                        | uuid              | char(36)      | -         |           |
| title                     | string 90         | varchar(90)   | no        |           |
| slug                      | string 90         | varchar(90)   | no        |           |
| price                     | decimal 10,2      | decimal(10,2) | no        |           |
| description               | text              | longtext      | no        |           |
| language                  | string 2          | char(2)       | no        |           |
| state                     | string xxx        | enum('new','used','broken')| no | new |
| date_publish              | datetime          | datetime      | no        |           |
| date_expire               | datetime          | datetime      | no        |           |
| createdBy                 | ManyToOne         | char(36)      | no        |           |
| category                  | ManyToOne         | int(11)       | no        |           |
| location                  | ManyToOne         | int(11)       | no        |           |
| attachments               | OneToMany         | int(11)       | yes       |           |

#### 2.1.3 Favorites

Permet de lister les annonces misent en favoris par les membres.


| Propriété                 | Typage Symfony    | Typage SQL    | Null ?    | Défaut    |
|---------------------------|-------------------|---------------|-----------|-----------|
| user                      | ManyToOne         | char(36)      | no        |           |
| ad                        | ManyToOne         | char(36)      | no        |           |

La table Favorites est en réalité une relation **ManyToMany** entre **Users** et **Ads**

#### 2.1.4 Categories

Liste des catégories pour le classement des annonces.


| Propriété                 | Typage Symfony    | Typage SQL    | Null ?    | Défaut    |
|---------------------------|-------------------|---------------|-----------|-----------|
| id                        |                   | int(11)       | -         |           |
| name                      | string 30         | varchar(30)   | no        |           |
| slug                      | string 30         | varchar(30)   | no        |           |
| color                     | string 7          | char(7)       | no        |           |

#### 2.1.5 Offers

Liste des offres deposée par les membres, sur les annonces pour lesquelles ils portent un interêt.


| Propriété                 | Typage Symfony    | Typage SQL    | Null ?    | Défaut    |
|---------------------------|-------------------|---------------|-----------|-----------|
| id                        |                   | int(11)       | -         |           |
| user                      | ManyToOne         | char(36)      | no        |           |
| ad                        | ManyToOne         | char(36)      | no        |           |
| price                     | decimal 10,2      | decimal(10,2) | no        |           |
| message                   | text              | text          | yes       |           |
| offerDate                 | datetime          | datetime      | no        |           |

#### 2.1.6 Medias

Liste des médias (images/vidéos).


| Propriété                 | Typage Symfony    | Typage SQL    | Null ?    | Défaut    |
|---------------------------|-------------------|---------------|-----------|-----------|
| id                        |                   | int(11)       | -         |           |
| type                      | string xxx        | enum('image','video','sound')| |      |
| path                      | string 40         | varchar(40)   |           |           |
| createdBy                 | ManyToOne         | char(36)      |           |           |

#### 2.1.7 Attachments

Table de liaison des médias sur des annonces.


| Propriété                 | Typage Symfony    | Typage SQL    | Null ?    | Défaut    |
|---------------------------|-------------------|---------------|-----------|-----------|
| id                        |                   | int(11)       | -         |           |
| media                     | ManyToOne         | char(36)      |           |           |
| ad                        | ManyToOne         | char(36)      |           |           |
| title                     | string 80         | varchar(80)   |           |           |

La table Attachments est en réalité une relation **ManyToMany** entre **Medias** et **Ads**
Mais la table Attachments possède un champ additionnel... il convient donc de créer une entité dédiée à la relation entre **Medias** et **Ads**

#### 2.1.8 Addresses

Stockage des adresses. Adresse des membres et localisation des annonces.


| Propriété                 | Typage Symfony    | Typage SQL    | Null ?    | Défaut    |
|---------------------------|-------------------|---------------|-----------|-----------|
| id                        |                   | int(11)       | -         |           |
| address                   | string 255        | varchar(255)  |           |           |
| additional                | string 255        | varchar(255)  |           |           |
| postalcode                | string 10         | varchar(10)   |           |           |
| city                      | string 80         | varchar(80)   |           |           |
| region                    | string 80         | varchar(80)   |           |           |
| country                   | string 2          | char(2)       |           |           |



### 2.2 Routes

| Page                                  | Path                              | Nom de route      |
|---------------------------------------|-----------------------------------|-------------------|
| Page d'accueil                        | `/`                               | `homepage`        |
| Mentions légales                      | `/terms-of-use`                   | `legal`           |
| Contact                               | `/contact`                        | `contact`         |
|                                       |                                   |                   |
| Identification                        | `/login`                          | `login`           |
| Inscription                           | `/register`                       | `register`        |
| Activation du compte                  | `/activate?token={token}`         | `activate`        |
| Oublie du mot de passe                | `/forgotten-password`             | `forgotten-password` |
| RAZ du mot de passe                   | `/reset-password?token={token}`   | `reset-password`  |
| Modification du mot de passe          | `/renew-password`                 | `renew-password`  |
|                                       |                                   |                   |
| Profile utilisateur                   | `/account`                        | `account:index`   |
| Annonces publiée par l'utilisateur    | `/account/favorites`              | `account:favorites` |
| Annonces favorites                    | `/account/ads`                    | `account:ads`     |
|                                       |                                   |                   |
| Liste des annonces                    | `/ads`                            | `ads:index`       |
| - par catégorie                       | `/ads?categ={slug}`               | `ads:index`       |
| - par auteur                          | `/ads?user={id}`                  | `ads:index`       |
| Ajouter une annonce                   | `/ad`                             | `ads:create`      |
| Détails d'une annonce                 | `/ad/{id}`                        | `ads:read`        |
| Modifier une annonce                  | `/ad/{id}/edit`                   | `ads:update`      |
| Supprimer une annonce                 | `/ad/{id}/delete`                 | `ads:delete`      |
| Ajouter une annonce en favoris        | `/ad/{id}/favorites`              | `ads:favorites`   |



### 2.3 Controleurs

<hr>

- [Tuto](./README.md)
- << [Brief](./01-brief.md)
- \>> [Installation du projet](03-installation-du-projet.md)