<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadUserData extends Fixture {

	public function load(ObjectManager $manager) {

		$user1 = new User();
		$user1->setUsername('usuario1');
		$user1->setApiKey('74b87337454200d4d33f80c4663dc5e5');

		$manager->persist($user1);

		$user2 = new User();
		$user2->setUsername('usuario2');
		$user2->setApiKey('594f803b380a41396ed63dca39503542');

		$manager->persist($user2);
		$manager->flush();
	}

}