<?php

namespace App\DataFixtures;

use App\Entity\Job;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class JobFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $jobs = [
            'IT Engineer',
            'Full Stack Developer',
            'Data Scientist'
        ];
        foreach($jobs as $j)
        {
            $job = new Job();
            $job->setDesignation($j);
            $manager->persist($job);
        }

        $manager->flush();
    }
}
