# Examen2024
Correction de l'examen national de 2024
## ⚙️ Configuration de l’environnement

Afin de gérer les informations sensibles de connexion à la base de données, il est recommandé d’utiliser un fichier **`.env`**.

### Étapes :

1. Crée un fichier nommé **`.env`** à la racine du projet (au même niveau que **`.gitignore`**).
2. Ajoute les informations de connexion à la base de données dans ce fichier :

```env
SERVEUR=localhost
UTILISATEUR=root
MOTDEPASSE=
DBNAME=
PORT=3306
