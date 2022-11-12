<?php

namespace App\DataFixtures;

use App\Entity\Hobby;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class HobbyFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $hobbies = [
            "music",
            "sport",
            "cinema",
            "theater"
        ];
        foreach($hobbies as $h){
            $hobby = new Hobby();
            $hobby->setDesignation($h);
            $manager->persist($hobby);
        }

        $manager->flush();
    }
}
