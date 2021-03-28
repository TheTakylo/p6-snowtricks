<?php

namespace App\DataFixtures;

use App\Entity\TrickComment;
use App\Repository\TrickRepository;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TrickCommentFixtures extends Fixture implements DependentFixtureInterface
{

    /** @var TrickRepository $trickRepository */
    private $trickRepository;
    /** @var UserRepository */
    private $userRepository;

    public function __construct(TrickRepository $trickRepository, UserRepository $userRepository)
    {
        $this->trickRepository = $trickRepository;
        $this->userRepository = $userRepository;
    }

    public function load(ObjectManager $manager)
    {
        $tricks = $this->trickRepository->findAll();

        $user1 = $this->userRepository->findOneBy(['email' => 'admin@admin.fr']);
        $user2 = $this->userRepository->findOneBy(['email' => 'admin2@admin.fr']);

        foreach ($tricks as $trick) {
            if (rand(0, 1) === 0) {
                for ($i = 0; $i < 10; $i++) {
                    $user = rand(0, 1) === 0 ? $user1 : $user2;
                    $comment = new TrickComment();

                    $comment->setUser($user)
                        ->setTrick($trick)
                        ->setCreatedAt(new \DateTime())
                        ->setMessage('Merci pour le partage ! #' . $i);

                    $manager->persist($comment);
                }
            }
        }

        $manager->flush();
    }


    public function getDependencies(): array
    {
        return [
            TrickFixtures::class,
            UserFixtures::class
        ];
    }
}