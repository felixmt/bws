<?php
// src/BurgundyWineSchool/UserBundle/DataFixtures/ORM/LoadUser.php


namespace BurgundyWineSchool\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use BurgundyWineSchool\UserBundle\Entity\User;


class LoadUser implements FixtureInterface
{
  public function load(ObjectManager $manager)
  {
    // users to be created
    $listNames = array('admin');


    foreach ($listNames as $name) {
      $user = new User;
      $user->setUsername($name);
      $user->setPassword($name);

      // to be used later (password encryption)
      $user->setSalt('');
      $user->setRoles(array('ROLE_ADMIN'));

      $manager->persist($user);

    }
    // save in db
    $manager->flush();

  }

}