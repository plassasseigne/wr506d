<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class ActorFixtures extends Fixture implements DependentFixtureInterface 
{
  public function load(ObjectManager $manager): void
  {
    $faker = Faker\Factory::create();
    $faker->addProvider(new \Xylis\FakerCinema\Provider\Person($faker));

    foreach(range(1, 40) as $i) {
      $fullname = explode(' ', $faker->unique()->actor);

      $firstname = $fullname[0];
      $lastname = $fullname[1];

      $actor = new Actor();
      $actor->setFirstName($firstname);
      $actor->setLastName($lastname);
      $actor->setNationality($this->getReference('nationality_' . rand(1, 25)));
      $actor->setDateBirth($faker->dateTimeBetween('-80 years', '-18 years'));

      $manager->persist($actor);
      $this->addReference('actor_' . $i, $actor);
    }

    $manager->flush();
  }

  public function getDependencies()
  {
    return [
      NationalityFixtures::class
    ];
  }
}