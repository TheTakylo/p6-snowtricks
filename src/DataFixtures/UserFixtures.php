<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    /** @var UserPasswordEncoderInterface $encoder */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    // ...
    public function load(ObjectManager $manager)
    {
        $users = [
            ['email' => 'admin@admin.fr', 'firstname' => 'John', 'lastname' => 'Doe', 'password' => 'admin'],
            ['email' => 'admin2@admin.fr', 'firstname' => 'John2', 'lastname' => 'Doe2', 'password' => 'admin2'],
        ];

        foreach ($users as $u) {
            $user = new User();
            $user->setEmail($u['email']);
            $user->setFirstname($u['firstname']);
            $user->setLastname($u['lastname']);
            $user->setValidated(true);

            $password = $this->encoder->encodePassword($user, $u['password']);
            $user->setPassword($password);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
