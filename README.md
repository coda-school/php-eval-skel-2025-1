# Symfony Docker

A [Docker](https://www.docker.com/)-based installer and runtime for the [Symfony](https://symfony.com) web framework,
with [FrankenPHP](https://frankenphp.dev) and [Caddy](https://caddyserver.com/) inside!

![CI](https://github.com/dunglas/symfony-docker/workflows/CI/badge.svg)

## Getting Started

1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)
2. Run `docker compose build --pull --no-cache` to build fresh images
3. Run `docker compose up --wait` to set up and start a fresh Symfony project

4. Open `https://localhost` in your favorite web browser and [accept
   the auto-generated TLS
   certificate](https://stackoverflow.com/a/15076602/1352334)
5. Run `docker compose down --remove-orphans` to stop the Docker containers.

---

## Instructions spécifiques au projet

Pour lancer le projet si c'est le premier démarage écrivez dans le terminal la commande suivante :
docker compose up --pull --no-cache
puis :
docker compose up -d --wait

sinon

Pour se connecter, utilisez n'importe quel e-mail d'un user, et le mdp : password123
exemple : jacques.guyot@test.com ; password123

### Utilisation de l'IA :

AU départ je souhaitait faire les fixtures manuellement, ce que j'ai commencé à faire, mais j'ai finalement eut un gros problème de conscience, si je faisais que 100 ou 200 users j'allais avoir des tweets tout nul avec 0 vues. Du coup j'ai créé 2000 user (en réalité 20000 mais j'ai limité pour pas que ce soit trop long de reload les fixtures). J'ai envoyé mon code à l'IA en lui expliquant mon besoin, et pour y répondre elle à fait des boucle de 500 users pour limiter les besoins en performances. Du coup j'ai pris le code, que j'ai régulièrement modifié (et que j'ai entièrement analyser pour le comprendre). Malheureusement j'ai manqué de temps pour le remodifier et ajouter automatiquement les followers aléatoires...

---

## Feedbacks de l'équipe

### Ethan :
Ce projet m'a beaucoup plus et je l'ai trouvé très fun au début. J'ai adoré créer les premières pierres du projet, mais malheureusement à partir de la moitié du projet à cause d'un manque cruel d'organisation, de communication et de définition claire des tâches à réaliser l'avancement du projet à été largement retardé. Ces problèmes de communication et de répartition claire des tâches nous à empêcher de finir le projet de la manière souhaiter et nous à contraint à un rush final sur la dernière semaine. Ces problèmes sont principalement dues au fait que le projet soit 100% extra scolaire et qu'il nécessite donc un investissement très important que tout le monde n'a pas la possibilité, ou le volonté de fournir. Le fait que le projet soit extra scolaire rend également plus complexe la demande d'assistance au professeurs, ce qui rends les murs plus durs à passer. En dehors de tous ces problèmes, j'ai beaucoup appris sur symfony plus particulièrement sur les notions dont je n'avais presque aucune maîtrise après bricount (DTO, migrations, controllers), alors j'en garde un bon souvenir, et ce projet m'as appris également énormément sur le leadership et la gestion d'une équipe, que j'ai dû assumer un peu par la force des choses.

### Josserand :
Ce projet était une véritable épreuve pour moi (et la classe) car c'était nôtre premier projet qui avait besoin de front et de back. Je pense que moi comme mon groupe pouvons sortir avec plusieurs amélioration à faire pour nos futurs projets, car pour ce projet nous avons manquer d'organisation et surtout nous avons souffert d'une très mauvaise communication, ce qui nous a obligé de redoubler d'effort pour rendre ce projet à temps. Ce projet m'a également appris à travailler après les cours chez moi notamment en regardant des tutos vidéos ou bien en m'aidant de mes contacts sans oublié l'aide de l'ia pour certain passage (pour comprendre pas pour recopier bêtement)

### Louis :
Bon je vais faire un petit feedback, personnellement le projet m'a beaucoup plus, j'ai utilisé l'ia pour voir à quoi pourrait ressemblerai la page de profil, sinon la vraie page je l'ai fait moi même avec le code de Josserand pour la sidebarre (même si j'ai rencontré beaucoup de difficultés à ce niveau là). Sinon je n'ai rien d'autres à ajouter.

### Florian :
Le projet s’est bien passé et on a réussi à mettre en place les fonctionnalités principales avec Symfony. On a bien travaillé en groupe, même si notre code pourrait être plus optimisé. Un peu de difficulté dans le travail et la conciliation de l’équipe parce que le projet se déroulais à côté de nos cours.

---

## Features

- Production, development and CI ready
- Just 1 service by default
- Blazing-fast performance thanks to [the worker mode of FrankenPHP](https://frankenphp.dev/docs/worker/)
- [Installation of extra Docker Compose services](docs/extra-services.md) with Symfony Flex
- Automatic HTTPS (in dev and prod)
- HTTP/3 and [Early Hints](https://symfony.com/blog/new-in-symfony-6-3-early-hints) support
- Real-time messaging thanks to a built-in [Mercure hub](https://symfony.com/doc/current/mercure.html)
- [Vulcain](https://vulcain.rocks) support
- Native [XDebug](docs/xdebug.md) integration
- Super-readable configuration

**Enjoy!** ## Docs

1. [Options available](docs/options.md)
2. [Using Symfony Docker with an existing project](docs/existing-project.md)
3. [Support for extra services](docs/extra-services.md)
4. [Deploying in production](docs/production.md)
5. [Debugging with Xdebug](docs/xdebug.md)
6. [TLS Certificates](docs/tls.md)
7. [Using MySQL instead of PostgreSQL](docs/mysql.md)
8. [Using Alpine Linux instead of Debian](docs/alpine.md)
9. [Using a Makefile](docs/makefile.md)
10. [Updating the template](docs/updating.md)
11. [Troubleshooting](docs/troubleshooting.md)

## License

Symfony Docker is available under the MIT License.

## Credits

Created by [Kévin Dunglas](https://dunglas.dev), co-maintained by
[Maxime Helias](https://twitter.com/maxhelias) and sponsored by
[Les-Tilleuls.coop](https://les-tilleuls.coop).
