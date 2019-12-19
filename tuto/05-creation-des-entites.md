# OccazMalin
> Site de petites annonces

## 5. Création des entités

- Base des entités
- Les relations


## 5.1. Base des entités


### 5.1.1 Users

#### 5.1.1.1 Création de l'entité

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

#### 5.1.1.2 Modification de l'entité

##### 5.1.1.2.1 Ajouter les propriétés

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

##### 5.1.1.2.2 Modifier les annotations et méthodes

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










### 5.2. Les relations




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
| `favorites`   | `ManyToMany`  | `Ads`             | no       | no            |
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



<hr>

- [Tuto](./README.md)
- << [Mise en place de l'environnement de développement](04-mise-en-place-de-lenvironnement-de-dev.md)