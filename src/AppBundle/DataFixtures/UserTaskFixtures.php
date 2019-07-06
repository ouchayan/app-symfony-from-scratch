<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class UserTaskFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        // On configure dans quelles langues nous voulons nos données
        $faker = Faker\Factory::create('fr_FR');

        // we create 10 users
        $users = [];
        for ($i = 0; $i < 10; $i++) {
            $users[$i] = new User();
            $users[$i]->setFirstName($faker->firstName());
            $users[$i]->setLastName($faker->lastName);
            $users[$i]->setAge($faker->randomDigitNotNull);
            $users[$i]->setBirthDate($faker->dateTime());
            $manager->persist($users[$i]);
        }

        for ($i = 0; $i < 10; $i++) {
            $task = new Task();
            $task->setTitle($faker->title);
            $task->setDescription($faker->text);
            $task->setStatus($faker->randomElement(["CREATED","AFFECTED","VALIDATED","CLOSED"]));
            $task->setCreatedDate($faker->dateTime());
            $task->setUpdatedDate($faker->dateTime());
            $task->setUser($faker->randomElement($users));
            $manager->persist($task);
        }

        $manager->flush();
    }
}