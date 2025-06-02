# 🌞 Projet Web Photovoltaïque — CIR2 2025

## 🎯 Objectif

Ce projet a pour but de concevoir et développer une application web de **gestion des installations photovoltaïques** chez les particuliers.  
L'application permet de :
- Visualiser les installations via une carte interactive 🗺️
- Rechercher des installations avec filtres 🎛️
- Accéder aux statistiques clés 📊
- Gérer (ajouter/modifier) les installations via un back-office 🔧

---

## 🧱 Structure du Projet

### Front-end (HTML/CSS/JS)
- Accueil avec statistiques globales
- Formulaire de recherche avec filtres (marque panneau, onduleur, département)
- Tableau de résultats dynamiques (AJAX + API)
- Détail d'une installation
- Carte interactive via Leaflet (OpenStreetMap)

### Back-end (PHP + API REST)
- Interface de gestion : liste, ajout, modification d'installations
- Toutes les URL back commencent par `/back/`
- Communication via JSON (AJAX)

### Base de données
- Modélisée via MCD/MPD en JMerise
- Contient les entités : `Commune`, `Installation`, `Panneau`, `Onduleur`, `Installateur`
- Script d’import des données à partir de fichiers `.csv` et `.xlsx`

---

## 🗺️ Fonctionnalités Frontend

1. **Accueil**
    - Présentation du projet
    - Statistiques dynamiques :
        - Total installations
        - Installations par année, région
        - Nombre d’installateurs
        - Marques d’onduleurs/panneaux

2. **Recherche**
    - Filtres `select` (limités à 20 éléments aléatoires) :
        - Marque onduleur
        - Marque panneau
        - Département

3. **Affichage des résultats**
    - Liste dynamique des résultats via JavaScript (sans rechargement)
    - Informations : date, nb panneaux, surface, puissance, localisation

4. **Détails d’une installation**
    - Page dédiée avec toutes les informations

5. **Carte interactive**
    - Sélection année + département (20 valeurs max)
    - Affichage des installations avec popup (localité, puissance, lien)

---

## 🛠️ Fonctionnalités Backend

1. Accueil back
2. Visualisation des données (limitée à 100)
3. Ajout d'une installation
4. Modification d’une installation
5. Détail d'une installation

---

## 🔗 API REST

| Méthode | URL               | Description                     |
|--------|-------------------|----------------------------------|
| GET    | `/api/installations`   | Liste filtrée                  |
| GET    | `/api/installation/{id}` | Détail d'une installation     |
| POST   | `/api/installation`     | Création d'une installation   |
| PUT    | `/api/installation/{id}`| Modification                  |
| DELETE | `/api/installation/{id}`| Suppression                   |

---

## 🧰 Technologies Utilisées

- **Frontend** : HTML, CSS, JS, Bootstrap (optionnel), Leaflet.js
- **Backend** : PHP 7.4 / 8.2, PDO
- **Base de données** : MySQL 5.7 ou PostgreSQL 11
- **Outils** : JMerise, Figma, Git

---

## 🖥️ Déploiement

### Configuration requise
- Apache2
- PHP 7.4 / 8.2
- MySQL 5.7 ou PostgreSQL 11
- Serveur local (XAMPP, WAMP ou VM Debian)

### Lancer le projet
1. Cloner le dépôt
2. Importer la base de données avec le script SQL
3. Placer les fichiers dans `/var/www/html` ou équivalent
4. Lancer Apache et accéder via l’IP de la machine

---

