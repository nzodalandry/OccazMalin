# OccazMalin
> Site de petites annonces

## 3. Installation du projet

### 3.1 Installation de la base Symfony

```bash
composer create-project symfony/skeleton <my-project> "4.4.*"
cd <my-project>
```

### 3.2 Installation des dépendances

#### 3.2.1 Installation des dépendances Back

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
composer require stof/doctrine-extensions-bundle
composer require ramsey/uuid-doctrine
```

#### 3.2.2 Installation des dépendances Front

```bash
npm install bootstrap
npm install jquery
npm install popper.js
```

#### 3.2.3 Installation de Yarn

```bash
yarn install
```


### 3.3 Configuration des bundles

#### 3.3.1 `stof/doctrine-extensions-bundle`

```yaml
stof_doctrine_extensions:
    default_locale: en
    orm:
        default:
            sluggable: true
```


### 3.4 Initialisation de GIT

#### 3.4.1 Initialisation de GIT

```bash
git init
```


#### 3.4.2 Création de la copie du fichier d'environement

Pour Unix :

```bash
cp .env .env.dist
```

Pour Windows :

```bash
copy .env .env.dist
```


#### 3.4.3 Ignorer les fichiers pour GIT

Dans le fichier `.gitignore`, ajouter :
- `.env`


#### 3.4.4 Préparer le remote (GitHub)

1. Identifiez-vous sur https://github.com/
2. Créez nouveau dépôt
    - renseigner le Nom
    - renseigner la Description
    - dépôt public
3. Créez le premier commit
    ```bash
    git checkout -b develop
    git add *
    git add .env.dist
    git add .gitignore
    git commit -m 'initial commit'
    git remote add origin https://github.com/<USER>/<repository>.git
    git push --set-upstream origin develop
    ```


### 3.4 Installation de la base de données

#### 3.4.1 Configuration du fichier `.env`

_!!! Attention à votre version de SQL !!!_

```yaml
DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7
```

#### 3.4.2 Création de la base de données

```bash
php bin/console doctrine:database:create
```



<hr>

- [Tuto](./README.md)
- << [Définition des spécifications technique](./02-definition-des-specifications-technique.md)
- \>> [Mise en place de l'environnement de développement](04-mise-en-place-de-lenvironnement-de-dev.md)