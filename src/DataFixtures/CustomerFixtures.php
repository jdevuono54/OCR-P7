<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CustomerFixtures extends Fixture {

    private $passwordEncoder;

    public function __construct(UserPasswordHasherInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i=1; $i<=20; $i++){
            $customer = new Customer();

            $encodedPassword = $this->passwordEncoder->hashPassword($customer, 'test');
            $customer->setName($faker->company);
            $customer->setEmail($faker->companyEmail);
            $customer->setPassword($encodedPassword);

            $this->addReference($i, $customer);

            $manager->persist($customer);
        }

        $manager->flush();
    }
}
