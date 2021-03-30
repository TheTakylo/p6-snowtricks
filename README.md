# p6-snowtricks

[![SymfonyInsight](https://insight.symfony.com/projects/9f22b07b-46ba-4af1-b013-30768a785d8b/mini.svg)](https://insight.symfony.com/projects/9f22b07b-46ba-4af1-b013-30768a785d8b)

Lien du repository: https://github.com/TheTakylo/p6-snowtricks

Lien Symfony Insight: https://insight.symfony.com/projects/9f22b07b-46ba-4af1-b013-30768a785d8b

Lien du site: https://p6-snowtricks.sebastien-thuret.fr

# Installation

## Récupération des sources

```
git clone git@github.com:TheTakylo/p6-snowtricks.git
```

### Installation des dépendences via composer

```
composer install
```

## Configuration du projet

Configurer dans le fichier **.env**:
 - DATABASE_URL
 - MAILER_URL

## Créer et remplir la base de données

#### Créer la base de données
```
php bin/console doctrine:database:create
```

#### Créer les tables
```
php bin/console doctrine:schema:create
```

#### Charges les fixtures
```
php bin/console doctrine:fixtures:load
```

# Identifiants:

#### Compte 1:
- **Email:** admin@admin.fr
- **Mot de passe:** admin

#### Compte 2:
- **Email:** admin2@admin.fr
- **Mot de passe:** admin2
