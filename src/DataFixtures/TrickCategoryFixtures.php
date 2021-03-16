<?php

namespace App\DataFixtures;

use App\Entity\TrickCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class TrickCategoryFixtures extends Fixture
{
    /** @var SluggerInterface */
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager)
    {
        $categories = [
            ['name' => 'Grabs', 'description' => 'Un grab consiste à attraper la planche avec la main pendant le saut.'],
            ['name' => 'Rotations', 'description' => 'On désigne par le mot « rotation » uniquement des rotations horizontales ; les rotations verticales sont des flips. Le principe est d\'effectuer une rotation horizontale pendant le saut, puis d\'attérir en position switch ou normal'],
            ['name' => 'Flips', 'description' => 'Un flip est une rotation verticale. On distingue les front flips, rotations en avant, et les back flips, rotations en arrière.'],
            ['name' => 'Rotations désaxées', 'description' => "Une rotation désaxée est une rotation initialement horizontale mais lancée avec un mouvement des épaules particulier qui désaxe la rotation. Il existe différents types de rotations désaxées (corkscrew ou cork, rodeo, misty, etc.) en fonction de la manière dont est lancé le buste. Certaines de ces rotations, bien qu'initialement horizontales, font passer la tête en bas.

Bien que certaines de ces rotations soient plus faciles à faire sur un certain nombre de tours (ou de demi-tours) que d'autres, il est en théorie possible de d'attérir n'importe quelle rotation désaxée avec n'importe quel nombre de tours, en jouant sur la quantité de désaxage afin de se retrouver à la position verticale au moment voulu.

Il est également possible d'agrémenter une rotation désaxée par un grab."],
            ['name' => 'Slides', 'description' => "Un slide consiste à glisser sur une barre de slide. Le slide se fait soit avec la planche dans l'axe de la barre, soit perpendiculaire, soit plus ou moins désaxé.

On peut slider avec la planche centrée par rapport à la barre (celle-ci se situe approximativement au-dessous des pieds du rideur), mais aussi en nose slide, c'est-à-dire l'avant de la planche sur la barre, ou en tail slide, l'arrière de la planche sur la barre."],
            ['name' => 'One foot tricks', 'description' => "Figures réalisée avec un pied décroché de la fixation, afin de tendre la jambe correspondante pour mettre en évidence le fait que le pied n'est pas fixé. Ce type de figure est extrêmement dangereuse pour les ligaments du genou en cas de mauvaise réception."],
            ['name' => 'Old school', 'description' => "Le terme old school désigne un style de freestyle caractérisée par en ensemble de figure et une manière de réaliser des figures passée de mode, qui fait penser au freestyle des années 1980 - début 1990 "],
        ];

        foreach ($categories as $category) {
            $trickCategory = new TrickCategory();
            $trickCategory->setName($category['name']);
            $trickCategory->setDescription($category['description']);
            $trickCategory->setSlug(strtolower($this->slugger->slug($category['name'])));

            $manager->persist($trickCategory);
        }

        $manager->flush();
    }
}
