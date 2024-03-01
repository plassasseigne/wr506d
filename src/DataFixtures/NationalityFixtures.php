<?php

namespace App\DataFixtures;

use App\Entity\Nationality;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class NationalityFixtures extends Fixture
{
  public function load(ObjectManager $manager): void
  {
    $nationalities = array(
      'French',
      'Spanish',
      'Portuguese',
      'American',
      'Belgian',
      'English',
      'Irish',
      'Canadian',
      'Chinese',
      'Dutch',
      'Egyptian',
      'German',
      'Greek',
      'Italian',
      'Japanese',
      'Norwegian',
      'Polish',
      'Russian',
      'Swedish',
      'Venezuelan',
      'Romanian',
      'Bulgarian',
      'Indian',
      'Danish',
      'Scottish'
    );

    foreach (range(1, 25) as $i) {
      $nationality = new Nationality();
      $nationality->setName($nationalities[$i - 1]);
      $nationality->setFlag(strtolower($nationalities[$i - 1]) . '_flag.png');

      $manager->persist($nationality);
      $this->addReference('nationality_' . $i, $nationality);
    }

    $manager->flush();
  }
}
