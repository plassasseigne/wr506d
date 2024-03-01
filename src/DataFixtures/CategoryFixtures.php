<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
  public function load(ObjectManager $manager): void
  {
    $categories = [
      'Exorcism',
      'Gore',
      'Slasher',
      'Found Footage',
      'Psychological',
      'Monster'
    ];
    foreach (range(1, 6) as $i) {
      $category = new Category();
      $category->setName($categories[$i - 1]);

      $this->addReference('category_' . $i, $category);
      $manager->persist($category);
    }

    $manager->flush();
  }
}
