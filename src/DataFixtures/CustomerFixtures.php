<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CustomerFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i=1; $i<=20; $i++){
            $customer = new Customer();

            $customer->setName($faker->company);
            $customer->setEmail($faker->companyEmail);
            $customer->setPassword(password_hash($faker->password, PASSWORD_DEFAULT));

            $this->addReference($i, $customer);

            $manager->persist($customer);
        }

        $manager->flush();
    }
}
