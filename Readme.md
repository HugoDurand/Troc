# TROC

Troc est une plateforme web permettant l’échange de biens sur internet.

### Installation

* Télécharger le projet
```sh
git clone https://github.com/HugoDurand/Troc.git
```

* Lancer Docker
```sh
docker-compose up -d
```

* Ouvrir le bash php pour exécuter quelques commandes
```sh
docker-compose exec php-fpm bash
```

* dans le bash, composer install
```sh
composer install
```

* Chargez les fixtures
```sh
php bin/console doctrine:fixtures:load
```

* Lancez le socket
```sh
php bin/console sockets:start-chat
```

* Rendez-vous maintenant sur http://localhost:8080/


> le fichier .env a été uploadé sur le repo volontairement dans le cadre du projet scolaire pour des facilité de connexion a la base de données en ligne