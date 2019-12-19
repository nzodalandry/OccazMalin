# OccazMalin
> Site de petites annonces

## 6. Les Fixtures


### 6.1. Qu'est ce que c'est ?

Fixtures (jeu de données) est un ensemble de données qui permet d’avoir un environnement de développement proche d’un environnement de production avec des fausses données.


### 6.2. Installation du bundle

```bash
composer require orm-fixtures --dev
composer require doctrine/doctrine-fixtures-bundle --dev (sans symfony/flex)
```

L'option `--dev` permet d'utiliser le bundle uniquement en environnement de développement.


### 6.3. Création d'une Fixture

#### 6.3.1 Création de la fixtures

Création des fixtures pour les catégories.

```bash
php bin/console make:fixtures CategoriesFixtures
```

La commande crée le fichier :

- `created: src/DataFixtures/CategoriesFixtures.php`

#### 6.3.2 Import des classes

Importer l'entité `Categories`

```php
use App\Entity\Categories;
```

#### 6.3.3. Définitions des données

```php
const CATEGORIES = [
    ["Immobilier", "#00FF00"],
    ["Auto / Moto", "#F6B26B"],
    ["High-Tech", "#CC0000"],
    ["Spiritueux", "#660000"],
];
```

#### 6.3.4. Création des entités

Dans la méthodes `load`, on boucle sur la liste des categories, puis on affecte les valeurs aux propriétés de l'entité.

```php
public function load(ObjectManager $manager)
{
    foreach (self::CATEGORIES as $value)
    {
        $category = new Categories;
        $category->setName( $value[0] );
        $category->setColor( $value[1] );
        $manager->persist($category);
    }

    $manager->flush();
}
```


#### 6.3.5. Chargement des fixtures

```bash
php bin/console doctrine:fixtures:load
```

Attention, les données de la base de données seront ré-initialisées.


### 6.4. Création des Fixtures avec relations

Rappel de la logique des relations

- Les annonces dépendent des **utilisateurs** (`createdBy`), des **catégories** et **adresses** (`location`).
- Les **utilisateurs** peuvent dépendres des **adresses**.

Nous devons donc ajouter les données dans la base de données dans l'ordre suivant :

1. Catégories et Adresses
2. Utilisateurs
3. Annonces


#### 6.4.1 `CategoriesFixtures`

> source : [src/DataFixtures/CategoriesFixtures.php](./../src/DataFixtures/CategoriesFixtures.php)


##### 6.4.1.1 Création de la fixture
Création des fixtures pour les catégories.

```bash
php bin/console make:fixtures CategoriesFixtures
```

La commande crée le fichier :

- `created: src/DataFixtures/CategoriesFixtures.php`

##### 6.4.1.2 Import des classes

Importer l'entité `Categories`

```php
use App\Entity\Categories;
```

##### 6.4.1.3. Définitions des données

```php
const CATEGORIES = [
    ["Immobilier", "#00FF00"],
    ["Auto / Moto", "#F6B26B"],
    ["High-Tech", "#CC0000"],
    ["Spiritueux", "#660000"],
];
```

##### 6.4.1.4. Création des entités

Dans la méthodes `load`, on boucle sur la liste des categories, puis on affecte les valeurs aux propriétés de l'entité.

```php
public function load(ObjectManager $manager)
{
    foreach (self::CATEGORIES as $key => $value)
    {
        $category = new Categories;
        $category->setName( $value[0] );
        $category->setColor( $value[1] );
        $manager->persist($category);
    }

    $manager->flush();
}
```

##### 6.4.1.5 Classes parent et interface

Modifier la classe parent `AbstractFixture` et implémenter l'interface `OrderedFixtureInterface`.

```php
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class CategoriesFixtures extends AbstractFixture implements OrderedFixtureInterface
// ...
```

##### 6.4.1.6 Definir des références

Les référence permettent de retrouver l'entité dans d'autres fixtures.

```php
foreach (self::CATEGORIES as $key => $value)
{
    $category = new Categories;
    $category->setName( $value[0] );
    $category->setColor( $value[1] );

    $this->addReference('categ-'.$key, $category);
    
    $manager->persist($category);
}
```

##### 6.4.1.7 Definir l'ordre d'execution des fixtures

L'implémentation de l'inteface `OrderedFixtureInterface` nous impose d'ajouter la méthode `getOrder`.  

Cette méthode permet au gestionnaire de chargement des Fixtures de definir l'ordre de chargement des fixture, et donc de conserver une logique dans les relations.  
Dans notre cas, les catégories doivent être ajoutées en base de données avant la création des annonces.

```php
/**
 * Get the order of this fixture
 * @return integer
 */
public function getOrder()
{
    return 1;
}
```