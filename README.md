# OccazMalin
> Le site de petites annonces...


## 1. Préparation du projet

### 1.1 Définition des Entités

#### 1.1.1 Users

- id                            : uuid          : char(36)
- email                         : string 180    : varchar(180)
- password                      : string 255    : varchar(255)
- roles                         : json          : longtext/json
- firstname                     : string 40     : varchar(40)
- lastname                      : string 40     : varchar(40)
- screenname                    : string 40     : varchar(40)
- phone                         : string 20     : varchar(20)
- birthday                      : datetime      : datetime
- language                      : string 2      : char(2)
- isActive                      : boolean       : tinyint(1)
- activationToken               : string 255    : varchar(255)
- passwordToken                 : string 255    : varchar(255)
- passwordTokenExpiration       : datetime      : datetime
- picture                       : ManyToOne     : int(11)
- address                       : ManyToOne     : int(11)

#### 1.1.2 Ads 

- id                            : uuid          : char(36)
- title                         : string 90     : varchar(90)
- slug                          : string 90     : varchar(90)
- price                         : decimal 10,2  : decimal(10,2)
- description                   : text          : longtext
- language                      : string 2      : char(2)
- state                         : string xxx    : enum('new','used','broken')
- date_publish                  : datetime      : datetime
- date_expire                   : datetime      : datetime
- createdBy                     : ManyToOne     : char(36)
- category                      : ManyToOne     : int(11)
- location                      : ManyToOne     : int(11)
- attachments                   : OneToMany     : int(11)

#### 1.1.3 Favorites

- user                          : ManyToOne     : char(36)
- ad                            : ManyToOne     : char(36)

La table Favorites est en réalité une relation **ManyToMany** entre **Users** et **Ads**

#### 1.1.4 Categories

- id                            :               : int(11)
- name                          : string 30     : varchar(30)
- slug                          : string 30     : varchar(30)
- color                         : string 7      : char(7)

#### 1.1.5 Offers

- id                            :               : int(11)
- user                          : ManyToOne     : char(36)
- ad                            : ManyToOne     : char(36)
- price                         : decimal 10,2  : decimal(10,2)
- message                       : text          : text
- offerDate                     : datetime      : datetime

#### 1.1.6 Medias

- id                            :               : int(11)
- type                          : string xxx    : enum('image','video','sound')
- path                          : string 40     : varchar(40)
- createdBy                     : ManyToOne     : char(36)

#### 1.1.7 Attachments

- id                            :               : int(11)
- media                         : ManyToOne     : char(36)
- ad                            : ManyToOne     : char(36)
- title                         : string 80     : varchar(80)

La table Attachments est en réalité une relation **ManyToMany** entre **Medias** et **Ads**
Mais la table Attachments possède un champ additionnel... il convient donc de créer une entité dédiée à la relation entre **Medias** et **Ads**

#### 1.1.8 Addresses

- id                            :               : int(11)
- address                       : string 255    : varchar(255)
- additional                    : string 255    : varchar(255)
- postalcode                    : string 10     : varchar(10)
- city                          : string 80     : varchar(80)
- region                        : string 80     : varchar(80)
- country                       : string 2      : char(2)


### 1.2 Router

```txt
Homepage :              /
Ads :                   /
Ads (by category) :     /?categ=categ-slug
Ads (by user) :         /?user=xxxxxx
Create Ad :             /ad
Ad details :            /ad/{id}
Ad edit :               /ad/{id}/edit
Ad delete :             /ad/{id}/delete
Add ad to favorites :   /ad/{id}/favorites

Login :                 /login
Registration :          /register
Account activation :    /activate?token=xxxxxxx
Lost Password :         /forgotten-password
Reset Password :        /reset-password?token=xxxxxxx
Renew Password :        /renew-password
User profile/account :  /account
User ads :              /my-ads
User favorites :        /favorites

Terms :                 /legal
Contact :               /contact
```


## 2. Installation du projet

### 2.1 Installation de la base Symfony

```bash
composer create-project symfony/skeleton <my-project> "4.4.*"
cd <my-project>
```

### 2.2 Installation des dépendances

#### 2.2.1 Installation des dépendances Back

```bash
composer require symfony/flex
composer require symfony/console
composer require symfony/dotenv
composer require symfony/framework-bundle
composer require symfony/yaml
```

```bash
composer require symfony/web-server-bundle --dev
composer require symfony/maker-bundle --dev
composer require doctrine/doctrine-fixtures-bundle --dev 
composer require profiler --dev
composer require symfony/orm-pack
composer require annotations
composer require form
composer require validator
composer require twig-bundle
composer require security-csrf
composer require symfony/swiftmailer-bundle
composer require security
composer require symfony/translation
composer require encore
composer require claviska/simpleimage
composer require gedmo/doctrine-extensions
composer require ramsey/uuid-doctrine
```

#### 2.2.2 Installation des dépendances Front

```bash
npm install bootstrap
npm install jquery
npm install popper.js
```

#### 2.2.3 Installation de Yarn

```bash
yarn install
```

#### 2.2.4 Mise en place de l'environnement VSCode

1. Ouverture du répertoire **my-project** en mode projet sur VSCode.
2. Configuration de Debugger For Chrome

#### 2.2.5 Test du serveur de développement

```bash
php bin/console server:run *:8004
```


#### 2.2.6 Création de la copie `.env.dist`

Pour Unix :

```bash
cp .env .env.dist
```

Pour Windows :

```bash
copy .env .env.dist
```


### 2.3 Initialisation de GIT

#### 2.3.1 Initialisation de GIT

```bash
git init
```

#### 2.3.2 Ignorer les fichiers pour GIT

Dans le fichier `.gitignore`, ajouter :
- `.env`


#### 2.3.3 Préparer le remote (GitHub)

1. Identifiez-vous sur https://github.com/
2. Créez nouveau dépôt
    - renseigner le Nom
    - renseigner la Description
    - dépôt public
3. Créez le premier commit
    - `git checkout -b develop`
    - `git add *`
    - `git add .env.dist`
    - `git add .gitignore`
    - `git commit -m 'initial commit'`
    - `git remote add origin https://github.com/<USER>/<repository>.git`
    - `git push --set-upstream origin develop`


### 2.4 Installation de la base de données

#### 2.4.1 Configuration du fichier `.env`

_!!! Attention à votre version de SQL !!!_

```yaml
DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7
```

#### 2.4.2

```bash
php bin/console doctrine:database:create
```

## 3. Création des entités

### 3.1 Users

#### 3.1.1 Création de l'entité

```bash
php bin/console make:user Users
```

Repondre au question du terminal :

```
The name of the security user class (e.g. User) [User]: Users
Do you want to store user data in the database (via Doctrine)? (yes/no) [yes]:
Enter a property name that will be the unique "display" name for the user (e.g. email, username, uuid) [email]:
Does this app need to hash/check user passwords? (yes/no) [yes]:
```

#### 3.1.2 Modification de l'entité

##### 3.1.2.1 Ajouter les propriétés

- firstname
- lastname
- screenname
- phone
- birthday
- language
- isActive
- activationToken
- passwordToken
- passwordTokenExpiration

```bash
php bin/console make:entity Users
```

##### 3.1.2.2 Modifier les annotations et méthodes

Dans le fichier `src/Entity/Users.php` :

1. Import de la l'interface UUID

    ```php
    use Ramsey\Uuid\UuidInterface as UUID;
    ```
2. Ajouter l'annotation `HasLifecycleCallbacks`
    ```php
    /**
    * @ORM\Entity(repositoryClass="App\Repository\UsersRepository")
    * @ORM\HasLifecycleCallbacks()
    */
    class Users implements UserInterface
    ```
3. Modifier le type de l'ID
    ```php
    /**
    * @var \Ramsey\Uuid\UuidInterface
    *
    * @ORM\Id
    * @ORM\Column(type="uuid", unique=true)
    * @ORM\GeneratedValue(strategy="CUSTOM")
    * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
    */
    private $id;
    ```
4. Definir un type `char(2)` pour la base de données.
    ```php
    /**
    * @ORM\Column(type="string", length=2, options={"fixed"=true})
    */
    private $language;
    ```
5. Definir la valeur par défaut de la propriété `$isActive`
    ```php
    private $isActive = false;
    ```
6. Modifier le type de la méthode `getId`
    ```php
    public function getId(): ?uuid
    {
        return $this->id;
    }
    ```
7. Modifier la méthode `setScreenname`
    ```php
    /**
    * @ORM\PrePersist
    */
    public function setScreenname(): self
    {
        $this->screenname = $this->firstname;
        $this->screenname.= " ";
        $this->screenname.= substr($this->lastname, 0, 1).".";

        return $this;
    }
    ```

##### 3.1.2.3 Ajouter le type UUID à Doctrine

Modifier la config de Doctrine `config/packages/doctrine.yaml` :

```yaml
doctrine:
    dbal:
        types:
            uuid:  Ramsey\Uuid\Doctrine\UuidType
```

### 3.2 Ads

#### 3.2.1 Création de l'entité

Ajouter les propriétés : 

- title
- slug
- price
- description
- language
- state
- date_publish
- date_expire

```bash
php bin/console make:entity Ads
```

#### 3.2.2 Modification de l'entité

Dans le fichier `src/Entity/Ads.php` :

1. Import des dépendances
    ```php
    use Ramsey\Uuid\UuidInterface as UUID;
    use Gedmo\Mapping\Annotation as Gedmo;
    ```
2. Modifier le type de l'ID
    ```php
    /**
    * @var \Ramsey\Uuid\UuidInterface
    *
    * @ORM\Id
    * @ORM\Column(type="uuid", unique=true)
    * @ORM\GeneratedValue(strategy="CUSTOM")
    * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
    */
    private $id;
    ```
3. Automatisation du slug
    ```php
    /**
     * @ORM\Column(type="string", length=90)
     * @Gedmo\Slug(fields={"title"})
     */
    private $slug;
    ```
4. Definir un type `char(2)` pour la base de données.
    ```php
    /**
     * @ORM\Column(type="string", length=2, options={"fixed"=true})
     */
    private $language;
    ```
5. Definire des valeurs par défaut dans le constructeur
    ```php
    public function __construct()
    {
        $this->datePublish = new \DateTime();
        $this->dateExpire = $this->datePublish->add(new \DateInterval('P15D'));
    }
    ```
6. Modifier le type de la méthode `getId`
    ```php
    public function getId(): ?uuid
    {
        return $this->id;
    }
    ```

### 3.3 Categories

#### 3.3.1 Création de l'entité

Ajouter les propriétés : 

- name
- slug
- color

```bash
php bin/console make:entity Categories
```

#### 3.3.2 Modification de l'entité

Dans le fichier `src/Entity/Categories.php` :

1. Automatisation du slug
    ```php
    /**
     * @ORM\Column(type="string", length=30)
     * @Gedmo\Slug(fields={"name"})
     */
    private $slug;
    ```
2. Definir un type `char(2)` pour la base de données.
    ```php
    /**
     * @ORM\Column(type="string", length=7, options={"fixed"=true})
     */
    private $color;
    ```

### 3.4 Offers

#### 3.4.1 Création de l'entité

Ajouter les propriétés : 

- price
- message
- offerDate

```bash
php bin/console make:entity Offers
```

### 3.5 Medias

#### 3.5.1 Création de l'entité

Ajouter les propriétés : 

- type
- path

```bash
php bin/console make:entity Medias
```

### 3.6 Attachments

#### 3.6.1 Création de l'entité

Ajouter les propriétés : 

- title

```bash
php bin/console make:entity Attachments
```

### 3.7 Addresses

#### 3.7.1 Création de l'entité

Ajouter les propriétés : 

- address
- additional
- postalcode
- city
- region
- country

```bash
php bin/console make:entity Addresses
```

#### 3.7.2 Modification de l'entité

Dans le fichier `src/Entity/Addresses.php` :

1. Definir un type `char(2)` pour la base de données.
    ```php
    /**
     * @ORM\Column(type="string", length=7, options={"fixed"=true})
     */
    private $country;
    ```


## 4. Ajout des relations

Occupons nous des relations `OneToOne`, `ManyToOne` et `ManyToMany`.  
Les relations `OneToMany` seront gérée automatiquement par symfony lors de la création d'une relation `ManyToOne`


### 4.1 Les relations de l'entité `Users`

#### 4.1.1 Ajouter les relations

- favorites
- picture
- address

```bash
php bin/console make:entity Users
```

| Propriété     | Relation      | Classes           | Nullable | access/update |
|---------------|---------------|-------------------|----------|---------------|
| `favorites`   | `ManyToMany`  | `Ads`             |          | no            |
| `picture`     | `ManyToOne`   | `Medias`          | yes      | yes > users   |
| `address`     | `ManyToOne`   | `Addresses`       | yes      | no            |

#### 4.1.2 Modifier les annotations

1. Ajouter l'annotation `JoinTable` qui permet de definir le nom de la table de liaison.
    ```php
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Ads")
     * @ORM\JoinTable(name="favorites")
     */
    private $favorites;
    ```


### 4.2 Les relations de l'entité `Ads`

#### 4.2.1 Ajouter les relations

- createdBy
- category
- location

```bash
php bin/console make:entity Ads
```

| Propriété     | Relation      | Classes           | Nullable | access/update |
|---------------|---------------|-------------------|----------|---------------|
| `createdBy`   | `ManyToOne`   | `Users`           | no       | yes > ads     |
| `category`    | `ManyToOne`   | `Categories`      | no       | yes > ads     |
| `location`    | `ManyToOne`   | `Addresses`       | no       | no            |


### 4.3 Les relations de l'entité `Offers`

#### 4.3.1 Ajouter les relations

```bash
php bin/console make:entity Offers
```


### 4.4 Les relations de l'entité `Medias`

#### 4.4.1 Ajouter les relations

```bash
php bin/console make:entity Medias
```


### 4.5 Les relations de l'entité `Attachments`

#### 4.5.1 Ajouter les relations

```bash
php bin/console make:entity Attachments
```
