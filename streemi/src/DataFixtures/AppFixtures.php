<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Episode;
use App\Entity\Language;
use App\Entity\Movie;
use App\Entity\Playlist;
use App\Entity\PlaylistSubcription;
use App\Entity\Serie;
use App\Entity\Season;
use App\Entity\Subscription;
use App\Entity\SubscriptionHistory;
use App\Entity\User;
use App\Enum\CommentStatusEnum;
use App\Enum\UserAccountStatusEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Category;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class AppFixtures extends Fixture
{

    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        $this->getCategories($manager);
        $this->getLanguages($manager);
        $this->getMovies($manager);
        $this->getSeries($manager);
        $this->getUsers($manager);
        $this->getComments($manager);
        $this->getSubscriptions($manager);
        $this->getSubscriptionHistory($manager);
        $this->getPlaylists($manager);

        $manager->flush();
    }

    public function getCategories(ObjectManager $manager): array
{
    $category = new Category();
    $category->setName('aventure');
    $category->setLabel('Aventure');
    $manager->persist($category);

    $category2 = new Category();
    $category2->setName('action');
    $category2->setLabel('Action');
    $manager->persist($category2);

    $category3 = new Category();
    $category3->setName('Comédie');
    $category3->setLabel('Comédie');
    $manager->persist($category3);

    $category4 = new Category();
    $category4->setName('Science-fiction');
    $category4->setLabel('Science-fiction');
    $manager->persist($category4);

    // Sauvegarder les catégories dans la base de données
    $manager->flush();

    // Retourner les catégories
    return [$category, $category2, $category3, $category4];
}

    public function getLanguages(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $languageObjects = [];

        $languages = [
            ['name' => 'Francais', 'code' => 'FR'],
            ['name' => 'Anglais', 'code' => 'EN'],
            ['name' => 'Espagnol', 'code' => 'ES'],
            ['name' => 'Portugais', 'code' => 'PT'],
            ['name' => 'Italien', 'code' => 'IT'],
            ['name' => 'Japonais', 'code' => 'JP'],
            ['name' => 'Chinois', 'code' => 'CN'],
            ['name' => 'Russe', 'code' => 'RU'],
            ['name' => 'Arabe', 'code' => 'AR'],
            ['name' => 'Hindi', 'code' => 'HI'],
            ['name' => 'Deutsch', 'code' => 'DE'],
            ['name' => 'Néerlandais', 'code' => 'NL'],
            ['name' => 'Turc', 'code' => 'TR'],
            ['name' => 'Coréen', 'code' => 'KR'],
            ['name' => 'Vietnamien', 'code' => 'VN'],
            ['name' => 'Thailandais', 'code' => 'TH'],
            ['name' => 'Grec', 'code' => 'GR'],
            ['name' => 'Polonais', 'code' => 'PL'],
            ['name' => 'Tchèque', 'code' => 'CZ'],
            ['name' => 'Slovaque', 'code' => 'SK'],
        ];

        foreach ($languages as $language) {
            $l = new Language();
            $l->setName($language['name']);
            $l->setCode($language['code']);

            $languageObjects[$language['code']] = $language;
            $manager->persist($l);

        }

    }

    public function getMovies(ObjectManager $manager): array
    {

        $categories = $this->getCategories($manager);

        #Create array of 10 movies 

        $movies = [
            ['title' => 'Star Wars', 'short_description' => 'Star Wars: The Force Awakens', 'duration' => '100', 'long_description' => 'The Force Awakens is a 2015 sci-fi action film directed by George Lucas and written by Doug McKeithan, Hugh Hawking, and Ben Kubrick. It is the sequel to Star Wars: The Empire Strikes Back, and the sequel to Star Wars: The Force Awakens.', 'cover_image' => 'https://picsum.photos/id/230/400/550', 'release_date' => '1998-05-25', 'language' => 'FR', "category" => $categories[1]],
            ['title' => 'The Matrix', 'short_description' => 'The Matrix', 'duration' => '150', 'long_description' => 'The Matrix is a 1999 science fiction action film written and directed by the Wachowskis, starring Keanu Reeves, Laurence Fishburne, Carrie-Anne Moss, Hugo Weaving, and Joe Pantoliano.', 'cover_image' => 'https://picsum.photos/id/231/400/550', 'release_date' => '1999-03-31', 'language' => 'EN', "category" => $categories[1]],
            ['title' => 'The Lord of the Rings', 'short_description' => 'The Lord of the Rings', 'duration' => '110', 'long_description' => 'The Lord of the Rings is a film series of three epic fantasy adventure films directed by Peter Jackson, based on the novel written by J. R. R. Tolkien.', 'cover_image' => 'https://picsum.photos/id/232/400/550', 'release_date' => '2001-12-19', 'language' => 'EN', "category" => $categories[2]],
            ['title' => 'Harry Potter', 'short_description' => 'Harry Potter', 'duration' => '124', 'long_description' => 'Harry Potter is a British-American film series based on the eponymous novels by author J. K. Rowling. The series is distributed by Warner Bros. and consists of eight fantasy films.', 'cover_image' => 'https://picsum.photos/id/233/400/550', 'release_date' => '2001-11-16', 'language' => 'EN', "category" => $categories[2]],
            ['title' => 'The Hobbit', 'short_description' => 'The Hobbit', 'duration' => '139', 'long_description' => 'The Hobbit is a film series consisting of three high fantasy adventure films directed by Peter Jackson. They are based on the 1937 novel The Hobbit by J. R. R. Tolkien.', 'cover_image' => 'https://picsum.photos/id/234/400/550', 'release_date' => '2012-12-14', 'language' => 'EN', "category" => $categories[3]],
            ['title' => 'Pirates of the Caribbean', 'short_description' => 'Pirates of the Caribbean', 'duration' => '95', 'long_description' => 'Pirates of the Caribbean is a series of fantasy swashbuckler films produced by Jerry Bruckheimer and based on Walt Disney\'s theme park attraction of the same name.', 'cover_image' => 'https://picsum.photos/id/235/400/550', 'release_date' => '2003-07-09', 'language' => 'EN', "category" => $categories[0]],
        ];
        $result = [];
        foreach ($movies as $movieData) {
            $movie = new Movie();
            $movie->setTitle($movieData['title']);
            $movie->setShortDescription($movieData['short_description']);
            $movie->setLongDescription($movieData['long_description']);
            $movie->setDuration($movieData['duration']);
            $movie->setCoverImage($movieData['cover_image']);
            $movie->setReleaseDate(new \DateTime($movieData['release_date']));
            $movie->addCategory($movieData['category']);

            $manager->persist($movie);

            $result[] = $movie;
        }
        $manager->flush();
        return $result;
    }

    public function getSeries(ObjectManager $manager): array
    {

        $categories = $this->getCategories($manager);

        $series = [
            ['title' => 'Star Wars', 'short_description' => 'Star Wars: The Force Awakens', 'long_description' => 'The Force Awakens is a 2015 sci-fi action film directed by George Lucas and written by Doug McKeithan, Hugh Hawking, and Ben Kubrick. It is the sequel to Star Wars: The Empire Strikes Back, and the sequel to Star Wars: The Force Awakens.', 'cover_image' => 'https://picsum.photos/id/236/400/550', 'release_date' => '1998-05-25', 'language' => 'FR', "category" => $categories[1]],
            ['title' => 'The Matrix', 'short_description' => 'The Matrix', 'long_description' => 'The Matrix is a 1999 science fiction action film written and directed by the Wachowskis, starring Keanu Reeves, Laurence Fishburne, Carrie-Anne Moss, Hugo Weaving, and Joe Pantoliano.', 'cover_image' => 'https://picsum.photos/id/237/400/550', 'release_date' => '1999-03-31', 'language' => 'EN', "category" => $categories[1]],
            ['title' => 'The Lord of the Rings', 'short_description' => 'The Lord of the Rings', 'long_description' => 'The Lord of the Rings is a film series of three epic fantasy adventure films directed by Peter Jackson, based on the novel written by J. R. R. Tolkien.', 'cover_image' => 'https://picsum.photos/id/238/400/550', 'release_date' => '2001-12-19', 'language' => 'EN', "category" => $categories[2]],
            ['title' => 'Harry Potter', 'short_description' => 'Harry Potter', 'long_description' => 'Harry Potter is a British-American film series based on the eponymous novels by author J. K. Rowling. The series is distributed by Warner Bros. and consists of eight fantasy films.', 'cover_image' => 'https://picsum.photos/id/239/400/550', 'release_date' => '2001-11-16', 'language' => 'EN', "category" => $categories[2]],
            ['title' => 'The Hobbit', 'short_description' => 'The Hobbit', 'long_description' => 'The Hobbit is a film series consisting of three high fantasy adventure films directed by Peter Jackson. They are based on the 1937 novel The Hobbit by J. R. R. Tolkien.', 'cover_image' => 'https://picsum.photos/id/240/400/550', 'release_date' => '2012-12-14', 'language' => 'EN', "category" => $categories[3]],
            ['title' => 'Pirates of the Caribbean', 'short_description' => 'Pirates of the Caribbean', 'long_description' => 'Pirates of the Caribbean is a series of fantasy swashbuckler films produced by Jerry Bruckheimer and based on Walt Disney\'s theme park attraction of the same name.', 'cover_image' => 'https://picsum.photos/id/241/400/550', 'release_date' => '2003-07-09', 'language' => 'EN', "category" => $categories[0]],
        ];
        $result = [];
        foreach ($series as $serieData) {
            $serie = new Serie();
            $serie->setTitle($serieData['title']);
            $serie->setShortDescription($serieData['short_description']);
            $serie->setLongDescription($serieData['long_description']);
            $serie->setCoverImage($serieData['cover_image']);
            $serie->setReleaseDate(new \DateTime($serieData['release_date']));
            $serie->addCategory($serieData['category']);
            $manager->persist($serie);

            for ($j = 0; $j < random_int(1, 5); $j++) {

                $season = new Season();
                $season->setSeasonNumber(($j + 1));
                $season->setSerie($serie);
                $manager->persist($season);

                for ($k = 0; $k < random_int(1, 10); $k++) {
                    $episode = new Episode();
                    $episode->setTitle('Episode ' . ($k + 1));
                    $episode->setDuration((new \DateTime())->add(new \DateInterval('PT' . random_int(1, 24) . 'H')));
                    $episode->setReleaseDate((new \DateTime())->sub(new \DateInterval('P' . random_int(1, 30) . 'D')));
                    $episode->setSeason($season);
                    $manager->persist($episode);
                }

            }
            $result[] = $serie;
            $manager->flush();
        }
        return $result;
    }



    public function getUsers(ObjectManager $manager): array
    {
        $users = [];
        $usernames = ['alice', 'bob', 'charlie', 'dave', 'eve'];
        $statuses = [
            UserAccountStatusEnum::VALID,
            UserAccountStatusEnum::BLOCKED,
            UserAccountStatusEnum::DELETED,
            UserAccountStatusEnum::BANNED,
            UserAccountStatusEnum::PENDING,
        ];

        foreach ($usernames as $key => $username) {
            $user = new User();
            $user->setUsername($username);
            $user->setEmail($username . '@example.com');

            // Utilisez un encodeur de mot de passe si nécessaire
            $hashedPassword = $this->passwordHasher->hashPassword($user, 'password123');
            // Exemple : $encodedPassword = $encoder->encodePassword($user, $plainPassword);
            $user->setPassword($hashedPassword);
            $user->setRoles(['ROLE_USER']);

            // Assigner un statut de compte de façon cyclique
            $user->setAccountStatus($statuses[$key % count($statuses)]);

            $manager->persist($user);
            $users[] = $user;
        }

        $manager->flush();

        return $users;
    }

    public function getComments(ObjectManager $manager): array
    {
        $users = $this->getUsers($manager);
        $movies = $this->getMovies($manager);
        $series = $this->getSeries($manager);

        $commentsData = [
            ['content' => 'Amazing movie!', 'author' => $users[0], 'movie' => $movies[0], 'status' => CommentStatusEnum::VALID],
            ['content' => 'Great series!', 'author' => $users[1], 'serie' => $series[1], 'status' => CommentStatusEnum::PENDING],
            ['content' => 'Loved the plot twist!', 'author' => $users[2], 'movie' => $movies[1], 'status' => CommentStatusEnum::VALID],
            ['content' => 'Disappointed with the ending.', 'author' => $users[3], 'serie' => $series[2], 'status' => CommentStatusEnum::REJECTED],
            ['content' => 'Character development was excellent!', 'author' => $users[4], 'serie' => $series[3], 'status' => CommentStatusEnum::VALID],
            ['content' => 'Not what I expected.', 'author' => $users[0], 'movie' => $movies[2], 'status' => CommentStatusEnum::PENDING],
            ['content' => 'Best series of the year!', 'author' => $users[1], 'serie' => $series[4], 'status' => CommentStatusEnum::VALID],
            ['content' => 'It had its moments.', 'author' => $users[2], 'movie' => $movies[3], 'status' => CommentStatusEnum::PENDING],
            ['content' => 'Really gripping story!', 'author' => $users[3], 'serie' => $series[1], 'status' => CommentStatusEnum::VALID],
            ['content' => 'Could have been better.', 'author' => $users[4], 'movie' => $movies[4], 'status' => CommentStatusEnum::REJECTED],
        ];


        $comments = [];
        foreach ($commentsData as $data) {
            $comment = new Comment();
            $comment->setContent($data['content']);
            $comment->setAuthor($data['author']);
            $comment->setStatus($data['status']);

            if (isset($data['movie'])) {
                $comment->setMedia($data['movie']);
            } elseif (isset($data['serie'])) {
                $comment->setMedia($data['serie']);
            }

            $manager->persist($comment);
            $comments[] = $comment;
        }

        return $comments;
    }


    public function getSubscriptions(ObjectManager $manager): array
    {
        $users = $this->getUsers($manager);
        $subscriptions = [];

        // Abonnement mensuel
        $monthlySubscription = new Subscription();
        $monthlySubscription->setName('Mensuel');
        $monthlySubscription->setDuration(1); // 1 mois
        $monthlySubscription->setPrice(1 * 10); // Prix pour 1 mois
        $monthlySubscription->setDescription('Abonnement de courte durée');
        $manager->persist($monthlySubscription);
        $subscriptions[] = $monthlySubscription;

        // Abonnement trimestriel
        $quarterlySubscription = new Subscription();
        $quarterlySubscription->setName('Trimestriel');
        $quarterlySubscription->setDuration(3); // 3 mois
        $quarterlySubscription->setPrice(3 * 10); // Prix pour 3 mois
        $quarterlySubscription->setDescription('Abonnement de durée de 3 mois');

        $manager->persist($quarterlySubscription);
        $subscriptions[] = $quarterlySubscription;

        // Abonnement semestriel
        $semiAnnualSubscription = new Subscription();
        $semiAnnualSubscription->setName('Semestriel');
        $semiAnnualSubscription->setDuration(6); // 6 mois
        $semiAnnualSubscription->setPrice(6 * 10); // Prix pour 6 mois
        $semiAnnualSubscription->setDescription('Abonnement de durée de 6 mois');
        $manager->persist($semiAnnualSubscription);
        $subscriptions[] = $semiAnnualSubscription;

        // Abonnement annuel
        $annualSubscription = new Subscription();
        $annualSubscription->setName('Annuel');
        $annualSubscription->setDuration(12); // 12 mois
        $annualSubscription->setPrice(12 * 10); // Prix pour 12 mois
        $annualSubscription->setDescription('Abonnement de durée de 1 an ( plus long )');

        $manager->persist($annualSubscription);
        $subscriptions[] = $annualSubscription;


        return $subscriptions;
    }


    public function getSubscriptionHistory(ObjectManager $manager): array
    {
        $subscriptions = $this->getSubscriptions($manager);
        $history = [];

        foreach ($subscriptions as $subscription) {
            $users = $this->getUsers($manager);

            // Créer une entrée d'historique d'abonnement
            for ($i = 0; $i < $subscription->getDuration(); $i++) {
                $subscriptionHistory = new SubscriptionHistory();
                $startDate = new \DateTime();
                $startDate->add(new \DateInterval('P' . $i . 'M')); // Date de début pour le mois i

                $endDate = clone $startDate;
                $endDate->add(new \DateInterval('P1M')); // Date de fin (1 mois après le début)

                $subscriptionHistory->setStartDate($startDate);
                $subscriptionHistory->setEndDate($endDate);

                // Sélectionner un utilisateur aléatoire
                $randomUserIndex = array_rand($users); // Obtenir un index aléatoire
                $randomUser = $users[$randomUserIndex]; // Obtenir l'utilisateur aléatoire
                $subscriptionHistory->setSubscriber($randomUser); // Associer l'utilisateur

                $subscriptionHistory->setSubscription($subscription); // Associer l'abonnement

                $manager->persist($subscriptionHistory);

                // Ajouter à l'historique pour une éventuelle utilisation
                $history[] = [
                    'user' => $randomUser, // Utiliser l'utilisateur aléatoire
                    'subscription' => $subscription,
                    'start_date' => $startDate->format('Y-m-d'),
                    'end_date' => $endDate->format('Y-m-d')
                ];
            }
        }


        return $history;
    }

    public function getPlaylists(ObjectManager $manager): void
    {
        // Tableaux de données pour les utilisateurs, playlists et abonnements
        $usersData = $this->getUsers($manager);
        $movieData = $this->getMovies($manager); // Récupérer les films disponibles
        $serieData = $this->getSeries($manager); // Récupérer les séries disponibles

        $playlistsData = [
            ['name' => 'Rock Classics', 'createdAt' => new \DateTimeImmutable(), 'updatedAt' => new \DateTimeImmutable()],
            ['name' => 'Chill Vibes', 'createdAt' => new \DateTimeImmutable(), 'updatedAt' => new \DateTimeImmutable()],
            ['name' => 'Workout Beats', 'createdAt' => new \DateTimeImmutable(), 'updatedAt' => new \DateTimeImmutable()],
            ['name' => 'Top Hits', 'createdAt' => new \DateTimeImmutable(), 'updatedAt' => new \DateTimeImmutable()],
            ['name' => 'Indie Favorites', 'createdAt' => new \DateTimeImmutable(), 'updatedAt' => new \DateTimeImmutable()],
        ];

        // Créer des playlists
        foreach ($playlistsData as $playlistData) {
            $playlist = new Playlist();
            $playlist->setName($playlistData['name']);
            $playlist->setCreatedAt($playlistData['createdAt']);
            $playlist->setUpdatedAt($playlistData['updatedAt']);
            $playlist->setCreator($usersData[array_rand($usersData)]); // Assigner un créateur aléatoire parmi les utilisateurs

            $manager->persist($playlist);

            // Créer des abonnements pour chaque playlist
            for ($j = 0; $j < rand(1, 3); $j++) { // 1 à 3 abonnements par playlist
                $subscription = new PlaylistSubcription();
                $subscription->setSubscribedAt(new \DateTimeImmutable());
                $subscription->setPlaylist($playlist);
                $subscription->setSubscriber($usersData[array_rand($usersData)]); // Assigner un abonné aléatoire parmi les utilisateurs

                $manager->persist($subscription);
                $playlist->addSubscription($subscription); // Ajouter l'abonnement à la playlist
            }

            // Ajouter des médias à la playlist
            $mediaToAdd = [];

            // Assurez-vous d'avoir au moins 3 médias
            for ($k = 0; $k < 3; $k++) {
                // Ajouter aléatoirement soit un film soit une série
                if (rand(0, 1)) {
                    $mediaToAdd[] = $movieData[array_rand($movieData)];
                } else {
                    $mediaToAdd[] = $serieData[array_rand($serieData)];
                }
            }

            // Si vous voulez ajouter plus de médias, vous pouvez en ajouter jusqu'à un maximum, par exemple 10
            for ($k = 0; $k < rand(3, 10); $k++) {
                if (rand(0, 1)) {
                    $mediaToAdd[] = $movieData[array_rand($movieData)];
                } else {
                    $mediaToAdd[] = $serieData[array_rand($serieData)];
                }
            }

            // Obtenir les IDs uniques des médias pour éviter les doublons
            $uniqueIds = [];
            foreach ($mediaToAdd as $media) {
                $uniqueIds[] = $media->getId(); // Récupérer les IDs
            }

            // Supprimer les doublons basés sur les IDs
            $uniqueMediaToAdd = [];
            foreach ($mediaToAdd as $media) {
                if (!in_array($media->getId(), $uniqueIds, true)) {
                    $uniqueIds[] = $media->getId(); // Ajouter l'ID au tableau des IDs uniques
                    $uniqueMediaToAdd[] = $media; // Ajouter l'objet média à la liste unique
                }
            }

            // Ajouter les médias uniques à la playlist
            foreach ($uniqueMediaToAdd as $media) {
                $playlist->addPlaylistMedia($media); // Assurez-vous que votre méthode addPlaylistMedia() est bien définie dans votre classe Playlist
            }
        }

        $manager->flush(); // N'oubliez pas de flush à la fin pour enregistrer les modifications
    }



}
