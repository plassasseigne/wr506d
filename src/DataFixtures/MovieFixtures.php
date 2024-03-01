<?php

namespace App\DataFixtures;

use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class MovieFixtures extends Fixture implements DependentFixtureInterface
{
  public function load(ObjectManager $manager): void
  {
    $faker = Faker\Factory::create();
    $faker->addProvider(new \Xylis\FakerCinema\Provider\Movie($faker));

    foreach (range(1, 50) as $i) {
      $movie = new Movie();
      $movie->setTitle($faker->unique()->movie);
      $movie->setDescription($faker->text(250));
      $movie->setReleaseDate($faker->dateTime());
      $movie->setDuration(rand(90, 180));
      $movie->setBoxOffice(rand(50000000, 999999999));
      $movie->setMetascore(rand(1, 100));
      $movie->setCategory($this->getReference('category_' . rand(1, 6)));
      foreach (range(1, rand(2, 10)) as $a) {
        $movie->addActor($this->getReference('actor_' . rand(1, 40)));
      }

      $manager->persist($movie);
    }
    $manager->flush();
  }

  public function getDependencies()
  {
    return [
      ActorFixtures::class
    ];
  }
}
