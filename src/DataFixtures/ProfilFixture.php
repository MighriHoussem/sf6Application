<?php

namespace App\DataFixtures;

use App\Entity\Profil;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProfilFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $profiles = [
            'M Houssem',
            'Ali Med',
            'Salah Med',
            'Ali Med'
        ];
        foreach($profiles as $prof){
            $profil = new Profil();
            $profil->setRs('FB');
            $profil->setUrl($prof);
            $manager->persist($profil);
        }

        $manager->flush();
    }
}
