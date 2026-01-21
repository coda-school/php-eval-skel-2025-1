<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Like;
use App\Entity\Tweet;
use App\Entity\User;
use App\Entity\View;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Uid\Uuid;

class AppFixtures extends Fixture
{
    private const BATCH_SIZE = 500;
    private const TARGET_USERS = 2000;

    private const TWEET_CONTENTS = [
        "C'est incroyable ce qu'on peut faire avec Symfony aujourd'hui ! 🚀 #dev #php",
        "Je viens de finir ma série préférée, je suis dévasté... Des recommandations ? 📺",
        "Le café du lundi matin, c'est vraiment la seule raison de se lever. ☕️",
        "Quelqu'un a testé la dernière mise à jour ? C'est une catastrophe ou c'est moi ?",
        "Il fait un temps magnifique pour aller courir... ou rester coder dans le noir. 🤓",
        "Je ne comprends pas pourquoi mon chat me juge quand je mange des pâtes à 3h du matin.",
        "Gros projet en vue, j'ai hâte de vous en dire plus ! 👀",
        "La documentation est mon meilleur ami (et mon pire ennemi parfois).",
        "Rien de tel qu'un bon bug en prod le vendredi soir pour se sentir vivant.",
        "Si je gagnais au loto, je crois que je continuerais quand même à coder. Mentir ? Moi ? Jamais.",
        "PHP 8.4 est une petite pépite, les nouvelles features sont top.",
        "J'ai besoin de vacances, genre sur une île déserte sans wifi (mais avec la 4G quand même).",
        "Pourquoi est-ce que ça marche en local mais jamais en prod ? Le mystère éternel.",
        "Je viens d'apprendre une nouvelle recette de lasagnes, c'est une tuerie ! 🍝",
        "Elon Musk a encore tweeté n'importe quoi, ça ne s'arrête jamais.",
    ];

    private const COMMENT_CONTENTS = [
        "Tellement d'accord avec toi !",
        "Je ne suis pas sûr de comprendre ton point de vue...",
        "Hahaha excellent 😂",
        "C'est faux, tu devrais vérifier tes sources.",
        "Merci pour le partage !",
        "J'ai vécu exactement la même chose hier.",
        "Tu as refait ma journée merci.",
        "N'importe quoi 🙄",
        "Canon ! 🔥",
        "C'est triste à dire mais c'est la vérité.",
        "Premier degré ?",
        "On peut en parler en DM ?",
    ];

    public function __construct(
        private UserPasswordHasherInterface $hasher
    ) {}

    public function load(ObjectManager $manager): void
    {
        // Augmente la mémoire pour gérer les gros volumes
        ini_set('memory_limit', '1G');

        $faker = Factory::create('fr_FR');

        // On prépare un User "vide" juste pour hasher le mot de passe une seule fois (perf)
        $fixedPassword = $this->hasher->hashPassword(new User(), 'password123');

        // Tableau pour suivre les emails déjà utilisés (anti-doublons)
        $usedEmails = [];

        echo "--- Phase 1 : Création des Users et Tweets ---\n";

        for ($i = 0; $i < self::TARGET_USERS; $i++) {
            $user = new User();
            $firstName = $faker->firstName;
            $lastName = $faker->lastName;

            // --- GESTION DES EMAILS UNIQUES ---
            $cleanFirst = strtolower(iconv('UTF-8', 'ASCII//TRANSLIT', $firstName));
            $cleanLast = strtolower(iconv('UTF-8', 'ASCII//TRANSLIT', $lastName));
            $cleanFirst = preg_replace('/[^a-z0-9]/', '', $cleanFirst);
            $cleanLast = preg_replace('/[^a-z0-9]/', '', $cleanLast);

            $baseEmail = "$cleanFirst.$cleanLast";
            $candidateEmail = $baseEmail . "@test.com";
            $counter = 1;

            // Tant que l'email existe, on ajoute un chiffre
            while (isset($usedEmails[$candidateEmail])) {
                $candidateEmail = $baseEmail . $counter . "@test.com";
                $counter++;
            }
            $usedEmails[$candidateEmail] = true;
            $user->setEmail($candidateEmail);
            // ----------------------------------

            $user->setUsername($faker->userName);
            $user->setPassword($fixedPassword);
            $user->setBio($faker->sentence);
            $user->setTheme('light');
            $user->setCreatedDate($faker->dateTimeBetween('-1 year', 'now'));

            // Grâce à ton patch BaseEntity, on peut mettre null ici sans faire planter Doctrine !
            $user->setCreatedBy(null);

            $manager->persist($user);

            // Création des Tweets pour cet utilisateur
            $nbTweets = rand(2, 10);
            for ($j = 0; $j < $nbTweets; $j++) {
                $tweet = new Tweet();
                $tweet->setUid(Uuid::v4());
                $tweet->setContent($faker->randomElement(self::TWEET_CONTENTS));
                $tweet->setCreatedBy($user); // L'auteur est bien l'utilisateur courant
                $tweet->setCreatedDate($faker->dateTimeBetween($user->getCreatedDate(), 'now'));

                $manager->persist($tweet);
            }

            // Flush régulier pour envoyer en BDD par paquets
            if (($i + 1) % self::BATCH_SIZE === 0) {
                $manager->flush();
            }
        }

        $manager->flush(); // Dernier flush pour être sûr
        $manager->clear(); // On vide la mémoire avant la phase lourde suivante

        echo "--- Phase 2 : Génération des Interactions ---\n";

        // Récupération optimisée de tous les IDs
        $userIds = $manager->getRepository(User::class)->createQueryBuilder('u')->select('u.id')->getQuery()->getSingleColumnResult();
        $tweetIds = $manager->getRepository(Tweet::class)->createQueryBuilder('t')->select('t.id')->getQuery()->getSingleColumnResult();

        $interactionCount = 0;
        $totalTweets = count($tweetIds);

        foreach ($userIds as $userId) {
            // Création d'une référence légère vers l'utilisateur (évite une requête SELECT inutile)
            $userRef = $manager->getReference(User::class, $userId);

            // Nombre de tweets vus par cet utilisateur (random)
            $nbViews = rand(10, 50);

            // Sélection aléatoire des IDs de tweets vus
            if ($totalTweets < $nbViews) {
                $randomKeys = array_keys($tweetIds);
            } else {
                $randomKeys = array_rand($tweetIds, $nbViews);
                if (!is_array($randomKeys)) $randomKeys = [$randomKeys];
            }

            foreach ($randomKeys as $key) {
                $tweetId = $tweetIds[$key];

                // 1. Création de la VUE
                $view = new View();
                $view->setUserId($userId); // Pour ton champ ID brut
                $view->setTweetId($tweetId); // Pour ton champ ID brut
                $view->setCreatedBy($userRef); // Pour BaseEntity
                $view->setCreatedDate(new \DateTime());
                $manager->persist($view);

                // 2. Chance de LIKE (30%)
                if ($faker->boolean(30)) {
                    $like = new Like();
                    $like->setUserId($userId);
                    $like->setTweetId($tweetId);
                    $like->setCreatedBy($userRef);
                    $like->setCreatedDate(new \DateTime());
                    $manager->persist($like);
                }

                // 3. Chance de COMMENTAIRE (5%)
                if ($faker->boolean(5)) {
                    $comment = new Comment();
                    $comment->setTweetId($tweetId);
                    $comment->setCreatedBy($userRef);
                    $comment->setContent($faker->randomElement(self::COMMENT_CONTENTS));
                    $comment->setCreatedDate(new \DateTime());
                    $manager->persist($comment);
                }

                $interactionCount++;
            }

            // Flush et Clear par paquets pour ne pas saturer la RAM
            if ($interactionCount % self::BATCH_SIZE === 0) {
                $manager->flush();
                $manager->clear();
            }
        }

        $manager->flush();
        echo "Terminé ! Fixtures chargées.\n";
    }
}
