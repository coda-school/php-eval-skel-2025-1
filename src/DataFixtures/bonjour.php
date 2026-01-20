<?php

namespace App\bonjour;

use App\Entity\Comment;
use App\Entity\Like;
use App\Entity\Tweet;
use App\Entity\User;
use App\Entity\View;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    // Tu peux définir ici des constantes si tu veux des contenus fixes
    private const array TWEET_CONTENTS = [
        "Je viens de terminer ma première installation de Symfony 7.4, c'est vraiment fluide ! #Symfony #PHP",
        "Le café est prêt, le terminal est ouvert. C'est parti pour une journée de debug.",
        "Pourquoi est-ce que ça marche en local mais pas sur Docker ? Le mystère reste entier.",
        "Rien de tel qu'un bon refactoring pour se sentir l'âme d'un artiste.",
        "Est-ce que quelqu'un a testé les nouvelles fonctionnalités de PHP 8.4 ? Le gain de performance est impressionnant.",
        "Mon code fonctionne. Je ne sais pas pourquoi, mais il fonctionne. Je ne touche plus à rien.",
        "Apprendre Symfony, c'est un peu comme apprendre à piloter un avion. C'est dur au début, mais après on va vite.",
        "Le CSS est à la fois mon meilleur ami et mon pire ennemi.",
        "Je viens de découvrir un bug qui datait d'il y a 3 mois. Comment est-ce que ça tournait en prod ?",
        "La documentation est votre meilleure amie. Lisez-la.",
        "Un développeur qui ne fait pas de tests unitaires est un aventurier qui s'ignore.",
        "Quelqu'un a une astuce pour bien organiser ses services dans Symfony ?",
        "Je déteste quand mon IDE me suggère des trucs inutiles alors que je sais exactement ce que je veux.",
        "Le mode sombre devrait être obligatoire sur toutes les applications, c'est une question de santé publique.",
        "Git commit -m 'fix'... 15 fois de suite. On a tous été là.",
        "La sensation de résoudre un bug complexe après 4 heures de recherche est inégalable.",
        "Est-ce que les développeurs frontend dorment vraiment ?",
        "Ma stack préférée du moment : PHP 8.4, Symfony et Tailwind CSS.",
        "Je rêve en JSON. C'est grave docteur ?",
        "L'importance de nommer ses variables correctement ne sera jamais assez soulignée.",
        "Un petit 'composer update' et paf, plus rien ne marche. Classique.",
        "Le télétravail a changé ma vie, mais mon chat pense que je suis son employé à plein temps.",
        "Quelqu'un peut m'expliquer la différence entre un bon et un mauvais développeur sans parler de code ?",
        "C'est lundi, mais le code n'attend pas.",
        "Je viens de passer 2 heures sur une virgule manquante. Ma vie est passionnante.",
        "Le design pattern 'Singleton' est-il vraiment utile ou juste un piège ?",
        "Plus je code, moins je comprends comment Internet tient encore debout.",
        "C'est quoi votre raccourci clavier préféré sur VS Code ?",
        "J'ai essayé de coder sans café ce matin. J'ai tenu 12 minutes.",
        "Les pipelines CI/CD qui échouent sans raison apparente, c'est mon cardio du matin.",
        "Symfony 7.4 est enfin là ! Qui fait la mise à jour dès aujourd'hui ?",
        "La règle d'or : ne jamais déployer un vendredi à 17h.",
        "Un jour, j'écrirai une documentation parfaite. Mais ce n'est pas pour aujourd'hui.",
        "Le concept d'Entity Manager dans Doctrine est parfois magique, parfois frustrant.",
        "Pourquoi le centrage d'une div est-il toujours un sujet de débat en 2025 ?",
        "Mon bureau est bien rangé. Ça veut dire que je n'ai pas encore commencé à travailler.",
        "Est-ce que vous utilisez plutôt les Annotations ou les Attributes dans vos entités ?",
        "Le déploiement en prod s'est passé sans accroc. Je m'inquiète.",
        "Apprendre une nouvelle technologie, c'est comme recommencer un niveau de jeu vidéo.",
        "Les réunions qui auraient pu être un simple mail, on en parle ?",
        "J'ai besoin d'un nouveau clavier mécanique. Mes voisins me détestent déjà.",
        "Le SQL est un langage magnifique quand on sait s'en servir.",
        "Les stagiaires sont souvent plus dégourdis qu'on ne le pense. Donnez-leur une chance !",
        "La cybersécurité n'est pas une option, c'est une nécessité absolue.",
        "Quelqu'un a déjà réussi à configurer Xdebug du premier coup ?",
        "Le code legacy, c'est comme un vieux grenier. On a peur de ce qu'on va y trouver.",
        "J'adore voir mes tests passer au vert un par un.",
        "Un bon développeur est celui qui sait chercher sur Google, c'est 80% du job.",
        "Pourquoi mon cerveau décide de résoudre mes bugs à 3h du matin ?",
        "Le framework est un outil, pas une religion.",
        "Je viens de supprimer 500 lignes de code inutiles. Quel soulagement !",
        "La simplicité est la sophistication suprême, même en développement.",
        "Comment gérez-vous votre équilibre vie pro / vie perso en étant dev ?",
        "L'IA va-t-elle remplacer les développeurs ? Pour l'instant, elle n'arrive même pas à faire un code sans bug.",
        "Le terminal est mon foyer. Le GUI est mon bureau de passage.",
        "Une petite pause café avant de s'attaquer à l'API.",
        "Les formulaires Symfony sont puissants, mais la courbe d'apprentissage est réelle.",
        "Je déteste les merge conflicts. Surtout quand c'est ma faute.",
        "C'est quoi votre thème préféré sur PhpStorm ?",
        "La programmation fonctionnelle me donne parfois mal à la tête, mais c'est fascinant.",
        "Un petit tweet pour dire que j'adore Symfony et la communauté PHP !",
        "Le hardware coûte cher, mais le mauvais software coûte encore plus cher.",
        "Qui utilise encore jQuery en 2025 ? Avouez-le !",
        "Le déploiement continu, c'est le futur du développement logiciel.",
        "Je viens de découvrir une fonctionnalité cachée dans PHP que je ne connaissais pas.",
        "Les logs sont vos yeux quand tout devient sombre.",
        "Rien n'est plus permanent qu'une solution temporaire en informatique.",
        "Le pair programming est une excellente méthode pour apprendre vite.",
        "Est-ce que vous préférez travailler dans le calme ou avec de la musique ?",
        "Le chocolat aide à coder. C'est prouvé scientifiquement (par moi-même).",
        "Ma motivation est proportionnelle à la qualité de mon setup.",
        "Le code est de la poésie pour ceux qui savent le lire.",
        "Je ne comprends pas les gens qui codent sans indentation.",
        "Un bug trouvé est un bug qui ne sera plus là demain.",
        "Le cloud c'est juste l'ordinateur de quelqu'un d'autre, mais en plus cher.",
        "Je suis en train de préparer une présentation sur Symfony pour mon équipe.",
        "L'architecture hexagonale, c'est compliqué mais ça change tout sur le long terme.",
        "Un petit tutoriel sur les DataFixtures arrivera bientôt sur mon blog !",
        "La patience est la vertu principale d'un bon débuggeur.",
        "Les frameworks JS changent toutes les semaines, PHP reste solide comme un roc.",
        "Je viens de passer au clavier AZERTY après 10 ans de QWERTY. C'est dur.",
        "L'open source est ce qui rend notre métier si beau.",
        "Merci à tous ceux qui répondent aux questions sur Stack Overflow.",
        "Une pensée pour tous les serveurs qui tournent dans le froid pour nous.",
        "Le déploiement automatisé m'a sauvé tellement de temps cette année.",
        "Je suis enfin passé à la fibre ! Mes 'composer install' vont à la vitesse de la lumière.",
        "Le design de mon application Twitter est presque terminé. Qu'en pensez-vous ?",
        "La sécurité CSRF est déjà intégrée dans Symfony, un souci de moins !",
        "Je me demande si je devrais utiliser API Platform pour mon prochain projet.",
        "Les micro-services sont géniaux, jusqu'à ce que le réseau tombe.",
        "Coder, c'est 10% d'écriture et 90% de compréhension de ce qu'on a écrit.",
        "Mon chat vient de marcher sur mon clavier et a fait un 'git push force'. Au secours.",
        "Le refactoring n'est pas une perte de temps, c'est un investissement.",
        "Les commentaires dans le code doivent expliquer 'pourquoi', pas 'comment'.",
        "Je suis accro aux raccourcis clavier. La souris est mon ennemie.",
        "Symfony Maker Bundle me fait gagner un temps fou sur la création des entités.",
        "Le typage strict en PHP 8 est une bénédiction.",
        "Comment rester à jour avec toutes les sorties technologiques ?",
        "La gestion des dépendances avec Composer est tellement plus simple qu'avant.",
        "Un petit 'var_dump' et on voit tout de suite plus clair.",
        "Je cherche un mentor pour progresser sur Doctrine. Des volontaires ?",
        "La communauté Symfony est vraiment l'une des meilleures au monde.",
        "Ne jamais sous-estimer le pouvoir d'une bonne nuit de sommeil pour résoudre un problème.",
        "Mon application Twitter commence à avoir de l'allure !",
        "Le frontend avec AssetMapper dans Symfony 7 est une vraie alternative à Webpack.",
        "Je viens d'apprendre à utiliser les Uuids pour mes entités, c'est plus sécurisé !",
        "Le contenu d'un tweet est limité à 280 caractères, c'est le défi du jour.",
        "Les fixtures sont essentielles pour tester son application avec des données réelles.",
        "Pourquoi le temps passe si vite quand on code ?",
        "La programmation est un langage universel.",
        "Je suis fier de mon code aujourd'hui. C'est rare, alors je le dis.",
        "L'optimisation prématurée est la racine de tous les maux.",
        "Un petit pas pour le dev, un grand pas pour l'application.",
        "Les interfaces nous permettent de créer du code vraiment découplé.",
        "Je viens de découvrir le bundle 'Maker', c'est magique pour générer du code !",
        "Le déploiement sur FrankerPHP est vraiment rapide.",
        "Ma base de données est enfin synchronisée avec mes entités.",
        "Le développement web est une aventure quotidienne.",
        "Je suis en train de configurer les accès de sécurité dans mon fichier security.yaml.",
        "Le système de login fonctionne ! Alice peut enfin se connecter.",
        "Un tweet, deux tweets, trois tweets... ma base se remplit !",
        "Le métier de développeur demande une curiosité constante.",
        "J'adore voir les logs Symfony défiler dans mon terminal.",
        "Une petite pensée pour tous ceux qui débuggent de la production aujourd'hui.",
        "Le framework Symfony offre tellement de composants utiles comme 'Uid' ou 'Validator'.",
        "Le Twig Bundle permet de créer des templates magnifiques très simplement.",
        "Ma bio Twitter est maintenant plus consistante grâce à Faker !",
        "L'intégration de Doctrine Migrations facilite énormément la gestion de la BDD.",
        "Est-ce que vous utilisez des fixtures pour vos tests unitaires ?",
        "Le développement est un marathon, pas un sprint.",
        "Je viens d'ajouter le support du mode sombre sur mon clone Twitter.",
        "Le fichier .env permet de gérer ses configurations sans les versionner.",
        "L'utilisation de PHP 8.4 apporte vraiment de la modernité à mon projet.",
        "Le typage des propriétés dans mes entités me permet d'éviter bien des erreurs.",
        "Doctrine ORM 3.5 est une version très stable pour ce projet.",
        "Le bundle Twig Extra apporte des filtres vraiment pratiques.",
        "Je teste actuellement la validation des formulaires avec Symfony Validator.",
        "L'Asset Mapper simplifie la gestion des fichiers JS et CSS sans Node.js.",
        "Je suis impressionné par la rapidité de chargement des pages Twig.",
        "Mon code est propre, bien indenté et commenté. Je suis prêt pour la revue de code.",
        "Le système de routing de Symfony est d'une flexibilité incroyable.",
        "J'ai hâte de voir mon application Twitter en ligne.",
        "Le développement backend est passionnant, surtout avec Symfony.",
        "Je viens d'ajouter une fonctionnalité de 'Like' sur les tweets.",
        "Les commentaires sur les tweets permettent d'engager la discussion.",
        "Le profil utilisateur affiche enfin les bonnes informations.",
        "La gestion des avatars est la prochaine étape de mon projet.",
        "Je me demande si je devrais ajouter des hashtags cliquables.",
        "Le framework Symfony me permet de me concentrer sur la logique métier.",
        "Chaque ligne de code écrite est une leçon apprise.",
        "Le terminal est mon meilleur allié pour lancer les commandes Symfony.",
        "La console Symfony est vraiment riche en commandes utiles.",
        "Je viens de migrer mes données vers une base de données plus performante.",
        "La sécurité est au cœur de mon application grâce au Security Bundle.",
        "Je teste la réactivité de mon interface avec plusieurs utilisateurs simulés.",
        "Les fixtures permettent de voir si la pagination fonctionne correctement.",
        "Le développement web demande de la rigueur et de la passion.",
        "Je suis content d'avoir choisi Symfony pour ce projet de clone Twitter.",
        "Le code source est disponible sur mon GitHub pour les curieux !",
        "Une petite pause et je reprends le développement des notifications.",
        "Le système de recherche par mots-clés est en cours de développement.",
        "J'utilise les composants de Symfony pour garantir la qualité de mon code.",
        "Le fichier composer.json est le cœur de mon projet PHP.",
        "Je surveille les performances de mon application avec le Web Profiler.",
        "L'injection de dépendances simplifie énormément mes contrôleurs.",
        "Je suis en train de peaufiner le design responsive pour mobile.",
        "Le développement est un art qui se pratique au quotidien.",
        "Je suis ravi de partager mes progrès sur ce projet avec vous.",
        "Le clonage de Twitter est un excellent exercice pour apprendre Symfony.",
        "Chaque bug corrigé me rapproche de la version finale.",
        "L'utilisation de Docker facilite le partage de mon environnement de dev.",
        "Je suis attentif aux retours des utilisateurs pour améliorer mon app.",
        "Le contenu est roi, même sur un clone de réseau social.",
        "Je m'amuse beaucoup à coder ces fonctionnalités de tweets.",
        "Le framework Symfony est vraiment un choix robuste pour le web.",
        "Je prépare déjà la prochaine mise à jour de mon application.",
        "Le succès d'un projet réside dans les détails du code.",
        "Je suis fier de la structure de mes entités Doctrine.",
        "L'utilisation de PHP 8.4 permet d'écrire un code plus court et lisible.",
        "Le composant Symfony Console est parfait pour mes scripts de maintenance.",
        "Je teste actuellement l'envoi de mails avec Symfony Mailer.",
        "Le système de thèmes (clair/sombre) est un vrai plus pour l'expérience utilisateur.",
        "Je suis en train de documenter mon API pour les futurs développeurs.",
        "Le développement web est une fenêtre ouverte sur le monde.",
        "Je suis impatient de voir les premiers vrais tweets sur ma plateforme.",
        "La gestion des erreurs est cruciale pour une bonne expérience utilisateur.",
        "J'utilise le composant Stopwatch pour mesurer le temps d'exécution.",
        "Le bundle Twig est indispensable pour le rendu de mes vues.",
        "Je suis en train de tester les migrations de base de données.",
        "Le projet avance bien, je suis dans les temps pour la livraison.",
        "Je me sens de plus en plus à l'aise avec l'écosystème Symfony.",
        "Le code est le reflet de la pensée du développeur.",
        "Je termine cette liste de tweets par un message d'encouragement à tous les devs !",
        "Dernier tweet de test pour vérifier que tout fonctionne parfaitement."
    ];



    private array $generatedUsers = [];
    private array $generatedTweets = [];

    private UserPasswordHasherInterface $hasher;
    private ObjectManager $manager;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;
        $this->generatedUsers = [];
        $this->generatedTweets = [];


        $this->generatedUsers[] = $this->generateUser("Alice", "alice@twitter.fr", "alice", "Je suis Alice");
        $this->generatedUsers[] = $this->generateUser("Bob", "bob@twitter.fr", "bob", "Fan de tech");

        for (){};


        foreach ($this->generatedUsers as $user) {
            $this->generatedTweets[] = $this->generateTweet($user, "Bienvenue sur mon profil !");
            $nb_tweet = random_int(2, 30);
            for ($i = 0; $i < $nb_tweet; $i++) {
                $this->generatedTweets[] = $this->generateTweet($user, self::TWEET_CONTENTS[random_int(0, count(self::TWEET_CONTENTS) - 1)]);
            }
        }


        foreach ($this->generatedTweets as $tweet) {
            $randomUser = $this->generatedUsers[random_int(0, count($this->generatedUsers) - 1)];

            $this->generateLike($tweet, $randomUser);
            $this->generateView($tweet, $randomUser);

            if ($random === 10) {
                $this->generateComment($tweet, $randomUser, "Super tweet !");
            }
        }
    }


    private function generateUser(string $username, string $email, string $password, string $bio): User
    {
        $user = new User();

        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPassword($this->hasher->hashPassword($user, $password));
        $user->setBio($bio);

        $this->manager->persist($user);
        $this->manager->flush(); // Important : pour générer l'ID tout de suite

        return $user;
    }

    private function generateTweet(User $author, string $content): Tweet
    {
        $tweet = new Tweet();

        $tweet->setCreatedBy($author);
        $tweet->setContent($content);

        $this->manager->persist($tweet);
        $this->manager->flush();

        return $tweet;
    }

    private function generateLike(Tweet $tweet, User $user): Like
    {
        $like = new Like();
        // TODO: Setters
        // Astuce : $like->setTweetId($tweet->getId());
        // Astuce : $like->setUserId($user->getId());

        $this->manager->persist($like);
        $this->manager->flush();

        return $like;
    }

    private function generateComment(Tweet $tweet, User $author, string $content): Comment
    {
        $comment = new Comment();
        // TODO: Setters ($content, tweet_id, etc.)

        $this->manager->persist($comment);
        $this->manager->flush();

        return $comment;
    }

    private function generateView(Tweet $tweet, User $viewer): View
    {
        $view = new View();
        // TODO: Setters

        $this->manager->persist($view);
        $this->manager->flush();

        return $view;
    }
}
