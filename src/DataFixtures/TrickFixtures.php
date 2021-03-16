<?php

namespace App\DataFixtures;

use App\Entity\Trick;
use App\Repository\TrickCategoryRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class TrickFixtures extends Fixture implements DependentFixtureInterface
{
    /** @var SluggerInterface */
    private $slugger;

    /** @var TrickCategoryRepository $trickCategoryRepository */
    private $trickCategoryRepository;

    public function __construct(SluggerInterface $slugger, TrickCategoryRepository $trickCategoryRepository)
    {
        $this->slugger = $slugger;
        $this->trickCategoryRepository = $trickCategoryRepository;
    }

    public function load(ObjectManager $manager)
    {
        $tricksGroup = [
            ['category_name' => 'Grabs', 'tricks' => [
                ['name' => 'Mute', 'description' => 'Saisie de la carre frontside de la planche entre les deux pieds avec la main avant'],
                ['name' => 'Sad', 'description' => 'Saisie de la carre backside de la planche, entre les deux pieds, avec la main avant'],
                ['name' => 'Indy', 'description' => 'Saisie de la carre frontside de la planche, entre les deux pieds, avec la main arrière'],
                ['name' => 'Stalefish', 'description' => 'Saisie de la carre backside de la planche entre les deux pieds avec la main arrière'],
                ['name' => 'Tail grab', 'description' => 'Saisie de la partie arrière de la planche, avec la main arrière'],
                ['name' => 'Nose grab', 'description' => 'Saisie de la partie avant de la planche, avec la main avant'],
                ['name' => 'Japan', 'description' => 'Saisie de l\'avant de la planche, avec la main avant, du côté de la carre frontside'],
                ['name' => 'Seat belt', 'description' => 'Saisie du carre frontside à l\'arrière avec la main avant'],
                ['name' => 'Truck driver', 'description' => 'Saisie du carre avant et carre arrière avec chaque main (comme tenir un volant de voiture)'],
            ]],
            ['category_name' => 'Rotations', 'tricks' => [
            ]],
            ['category_name' => 'Flips', 'tricks' => [
            ]],
            ['category_name' => 'Rotations désaxées', 'tricks' => [
            ]],
            ['category_name' => 'Slides', 'tricks' => [
            ]],
            ['category_name' => 'One foot tricks', 'tricks' => [
            ]],
            ['category_name' => 'Old school', 'tricks' => [
            ]]
        ];


        $trickCategories = $this->trickCategoryRepository->findAll();

        foreach ($trickCategories as $trickCategory) {
            foreach ($tricksGroup as $trickGroup) {
                if ($trickGroup['category_name'] === $trickCategory->getName()) {
                    foreach ($trickGroup['tricks'] as $t) {
                        $trick = new Trick();
                        $trick->setName($t['name']);
                        $trick->setSlug(strtolower($this->slugger->slug($t['name'])));
                        $trick->setDescription($t['description']);
                        $trick->setTrickCategory($trickCategory);

                        $manager->persist($trick);
                    }
                }
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            TrickCategoryFixtures::class
        ];
    }
}
