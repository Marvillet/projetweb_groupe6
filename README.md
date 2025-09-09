# Projet Web Photovoltaïque — CIR2 2025

## Objectif

Ce projet a pour but de concevoir et développer une application web de **gestion des installations photovoltaïques** chez les particuliers.
L'application permet de :

* Visualiser les installations via une carte interactive 🗺️
* Rechercher des installations avec filtres 🎛️
* Accéder aux statistiques clés 📊
* Gérer (ajouter/modifier) les installations via un back-office 🔧

---

## Structure du Projet

### Front-end (HTML/CSS/JS)

* Accueil avec statistiques globales
* Formulaire de recherche avec filtres (marque panneau, onduleur, département)
* Tableau de résultats dynamiques (AJAX + API)
* Détail d'une installation
* Carte interactive via Leaflet (OpenStreetMap)

### Back-end (PHP + API REST)

* Interface de gestion : liste, ajout, modification d'installations
* Toutes les URL du back commencent par `/back/`
* Communication via JSON (AJAX)

### Base de données

* Modélisée via MCD/MPD en JMerise
* Contient les entités : `Commune`, `Installation`, `Panneau`, `Onduleur`, `Installateur`
* Script d’import des données à partir de fichiers `.csv` et `.xlsx`

---

## 🗺️ Fonctionnalités Front-end

1. **Accueil**

   * Présentation du projet
   * Statistiques dynamiques :

     * Nombre total d'installations
     * Installations par année, par région
     * Nombre d’installateurs
     * Marques d’onduleurs/panneaux

2. **Recherche**

   * Filtres `select` (limités à 20 éléments aléatoires) :

     * Marque d'onduleur
     * Marque de panneau
     * Département

3. **Affichage des résultats**

   * Liste dynamique des résultats via JavaScript (sans rechargement)
   * Informations : date, nombre de panneaux, surface, puissance, localisation

4. **Détails d’une installation**

   * Page dédiée avec toutes les informations

5. **Carte interactive**

   * Sélection de l’année + du département (20 valeurs max)
   * Affichage des installations avec popup (localité, puissance, lien)

---

## 🛠️ Fonctionnalités Back-end

1. Accueil back
2. Visualisation des données (limitée à 100)
3. Ajout d'une installation
4. Modification d’une installation
5. Détail d'une installation

---

## 🔗 API REST

**Fichier d'entrée** : `/php/request.php`

### 📊 Statistiques

**Base URL** : `/stat`

| Méthode | Endpoint                 | Description                         |
| ------: | ------------------------ | ----------------------------------- |
|     GET | `/total`                 | Statistiques globales.              |
|     GET | `/region?id_reg=`        | Statistiques par région.            |
|     GET | `/annee?id_an=`          | Statistiques par année.             |
|     GET | `/an_reg?id_an=&id_reg=` | Statistiques croisées année/région. |
|     GET | `/installateur`          | Nombre d'installateurs.             |
|     GET | `/onduleur`              | Nombre de types d'onduleurs.        |
|     GET | `/panneau`               | Nombre de types de panneaux.        |

---

### 🏗️ Installations

**Base URL** : `/installation` ✅ *(correction : ce n’était pas correctement orthographié)*

| Méthode | Endpoint | Description                            |
| ------: | -------- | -------------------------------------- |
|     GET | `/int`   | Détails d'une installation via son ID. |
|     GET | `/`      | Liste des 100 premières installations. |

---

### ☀️ Panneaux

**Base URL** : `/panneau`

| Méthode | Endpoint          | Description                  |
| ------: | ----------------- | ---------------------------- |
|     GET | `/marque?marque=` | Recherche par marque.        |
|     GET | `/marque`         | Liste de 20 marques.         |
|     GET | `/modele?modele=` | Recherche par modèle.        |
|     GET | `/modele`         | Liste de 20 modèles.         |
|    POST | `/marque?marque=` | Ajout d'une nouvelle marque. |
|    POST | `/modele?modele=` | Ajout d’un nouveau modèle.   |

---

### ⚡ Onduleurs

**Base URL** : `/onduleur`

| Méthode | Endpoint          | Description           |
| ------: | ----------------- | --------------------- |
|     GET | `/marque?marque=` | Recherche par marque. |
|     GET | `/marque`         | Liste de 20 marques.  |
|     GET | `/modele?modele=` | Recherche par modèle. |
|     GET | `/modele`         | Liste de 20 modèles.  |
|    POST | `/marque?marque=` | Ajout d’une marque.   |
|    POST | `/modele?modele=` | Ajout d’un modèle.    |

---

### 🗺️ Lieux

**Base URL** : `/lieu`

| Méthode | Endpoint             | Description                                      |
| ------: | -------------------- | ------------------------------------------------ |
|     GET | `/departement?dep=`  | Recherche par département.                       |
|     GET | `/departement`       | Liste de 20 départements.                        |
|     GET | `/coord?dep=&annee=` | Coordonnées géographiques par département/année. |
|     GET | `/region`            | Liste des régions.                               |
|     GET | `/commune`           | Liste de 20 communes.                            |

---

### 🔍 Recherche Avancée

**Base URL** : `/recherche`

| Méthode | Endpoint                   | Description                                          |
| ------: | -------------------------- | ---------------------------------------------------- |
|     GET | `?id_ond=&id_pan=&id_dep=` | Recherche combinée : onduleur, panneau, département. |

Toutes les combinaisons sont possibles (seulement `id_dep` et `id_ond`, seulement `id_ond`, etc.).

---

### 🧰 Installateurs

**Base URL** : `/installateur`

| Méthode | Endpoint         | Description                      |
| ------: | ---------------- | -------------------------------- |
|     GET | `/`              | 20 installateurs aléatoires.     |
|     GET | `?filtre=`       | Recherche avec filtre (select2). |
|    POST | `?installateur=` | Ajout d’un installateur.         |

---

### 🔒 Admin

**Base URL** : `/admin`

| Méthode | Endpoint         | Description                             |
| ------: | ---------------- | --------------------------------------- |
|    POST | `/`              | Ajout d'une installation.               |
|     PUT | `/ressource?id=` | Mise à jour d'une ressource spécifique. |
|  DELETE | `/ressource?id=` | Suppression d'une ressource spécifique. |

⚠️ Données à spécifier dans le corps de la requête.

---

## 🧰 Technologies Utilisées

* **Frontend** : HTML, CSS, JS, Bootstrap (optionnel), Leaflet.js
* **Backend** : PHP 7.4 / 8.2, PDO
* **Base de données** : MySQL 5.7 ou PostgreSQL 11
* **Outils** : JMerise, Figma, Git

---

## 🖥️ Déploiement

### Configuration requise

* Apache2
* PHP 7.4 / 8.2
* MySQL 5.7 ou PostgreSQL 11
* Serveur local (XAMPP, WAMP ou VM Debian)

### Lancer le projet

1. Cloner le dépôt
2. Importer la base de données avec le script SQL
3. Placer les fichiers dans `/var/www/html` ou équivalent
4. Lancer Apache et accéder via l’IP de la machine

---

## 🔗 Notre Git

[https://github.com/Marvillet/projetweb\_groupe6](https://github.com/Marvillet/projetweb_groupe6)
