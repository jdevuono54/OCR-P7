<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Phone;

class PhoneFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i=0; $i<20; $i++){
            $phone = new Phone();

            $phone->setBrand($faker->companySuffix);
            $phone->setModel($faker->text(5));
            $phone->setDescription($faker->text);
            $phone->setColor($faker->colorName);

            $manager->persist($phone);
        }

        $manager->flush();
    }
}
