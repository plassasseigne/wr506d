<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
  public function __construct(
    protected UserPasswordHasherInterface $passwordHasherInterface
  ) {
  }

  public function load(ObjectManager $manager): void
  {
    foreach (range(1, 5) as $i) {
      $user = new User();
      $user->setRoles( $i === 1 ? ['ROLE_ADMIN'] : ['ROLE_USER']);
      $user->setEmail('user' . $i . '@mail.com');
      $user->setFrontUsername('User' . $i);
      $user->setPassword($this->passwordHasherInterface->hashPassword(
        $user,
        'test123'
      ));

      $manager->persist($user);
      $this->addReference('user_' . $i, $user);
    }

    $manager->flush();
  }
}
