# OccazMalin
> Site de petites annonces

## 4. Mise ne place de l'environnement de développement


### 4.1 Mise en place de l'environnement VSCode

#### 4.1.1 Visual Studio Code en mode projet

1. Ouvrir une nouvelle fenêtre de Visual Studio Code.
2. Ajouter le répertoire de votre projet à l'espace de tarvail.  
    `Fichier > Ajoutr un dossier à l'espace de travail`
3. Sauvegarder l'espace de travail  
    `Fichier > Enregistrer l'espace de travail sous...`

#### 4.1.2 Configuration de Debugger For Chrome

1. Ajouter une configuration.  
    `Debug > Ajouter une configuration...`
2. Modifier les paramètres
    ```json
    "url": "http://localhost:8080",
    ```


### 4.2 Test du serveur de développement

```bash
php bin/console server:run *:8080
```


<hr>

- [Tuto](./README.md)
- << [Installation du projet](03-installation-du-projet.md)
- \>> [Création des entités](05-creation-des-entites.md)