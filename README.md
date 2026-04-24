# 🏥 Système de Gestion de Cabinet Médical (SGC)

![Laravel](https://img.shields.io/badge/Laravel-12-red)
![PHP](https://img.shields.io/badge/PHP-8.2-blue)
![Status](https://img.shields.io/badge/Status-Production-green)
![License](https://img.shields.io/badge/License-MIT-lightgrey)

---

## 📖 Présentation

Le **Système de Gestion de Cabinet Médical (SGC)** est une application web moderne, sécurisée et évolutive conçue pour digitaliser et optimiser la gestion quotidienne d’un cabinet médical.

Elle permet une gestion fluide et centralisée des interactions entre :

* 👨‍⚕️ Médecins
* 🧑‍💼 Personnel administratif
* 🧑‍🤝‍🧑 Patients

🎯 **Objectif :** Améliorer l’efficacité opérationnelle, réduire les tâches administratives et garantir la confidentialité des données médicales.

---

## ✨ Fonctionnalités clés

### 🔐 Authentification & gestion des accès

* Système sécurisé basé sur les rôles :

  * Administrateur
  * Médecin
  * Secrétaire
  * Patient
* Gestion des permissions

### 📅 Gestion intelligente des rendez-vous

* Calendrier interactif
* Statuts des consultations (confirmé, annulé, en attente)
* Organisation optimisée des plannings

### 🧾 Dossier patient numérique

* Historique médical complet
* Prescriptions
* Comptes rendus de consultation

### 📧 Système de notifications par email

* Confirmation de rendez-vous
* Rappels automatiques
* Réinitialisation de mot de passe

### 🛡 Sécurité avancée

* Redirection HTTPS automatique
* Protection CSRF
* Hashage sécurisé avec Bcrypt
* Respect des bonnes pratiques de sécurité web

---

## 🛠 Stack technologique

| Catégorie       | Technologie          |
| --------------- | -------------------- |
| Backend         | Laravel 12 (PHP 8.2) |
| Base de données | MySQL                |
| Frontend        | Blade + Tailwind CSS |
| Dépendances     | Composer, NPM        |
| Infrastructure  | Railway              |

---

## 🏗 Architecture

Le projet suit une architecture **MVC (Modèle - Vue - Contrôleur)** garantissant une séparation claire des responsabilités.

* **Modèles** : Gestion des données via Eloquent ORM
* **Contrôleurs** : Logique métier et traitement des requêtes
* **Middlewares** :

  * Sécurité HTTPS
  * Gestion des rôles et accès

---

## 🚀 Installation

```bash
git clone https://github.com/Abdelghanikemmissa/System-de-Gestion-de-cabinet-Medical
cd System-de-Gestion-de-cabinet-Medical
composer install
npm install
npm run build
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
```

---

## ⚙️ Configuration des emails

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=votre_email@gmail.com
MAIL_PASSWORD=votre_mot_de_passe
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=votre_email@gmail.com
MAIL_FROM_NAME="Cabinet Médical"
```

---

## ☁️ Déploiement

L’application est prête pour un déploiement cloud via **Railway**.

🔗 **Accéder à l’application en ligne :**
👉 [https://system-de-gestion-de-cabinet-medical-production.up.railway.app/]

* Configuration via variables d’environnement
* Mode production :

```env
APP_ENV=production
APP_DEBUG=false
```

---

## 🛡 Sécurité

Le système implémente plusieurs mécanismes de protection :

* 🔒 HTTPS forcé (middleware personnalisé)
* 🔐 Protection contre les attaques CSRF
* 🔑 Hashage des mots de passe
* 🧱 Architecture sécurisée

---

## ⚙️ Commandes utiles

---

## 🤝 Contribution

Les contributions sont encouragées.

```bash
git checkout -b feature/ma-fonctionnalite
git commit -m "Ajout fonctionnalité"
git push origin feature/ma-fonctionnalite
```

Puis créer une **Pull Request**.

---

## 🚀 Améliorations futures

* Notifications SMS / WhatsApp
* Tableau de bord analytique
* Téléconsultation
* API mobile

---

## 📄 Licence

Projet open-source sous licence MIT.

---

💡 *Développé pour moderniser la gestion des cabinets médicaux et améliorer l'expérience patient.*
