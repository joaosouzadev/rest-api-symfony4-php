<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData extends Fixture implements ContainerAwareInterface {

	public function load(ObjectManager $manager) {

		$passwordEncoder = $this->container->get('security.password_encoder');

		$user1 = new User();
		$user1->setUsername('usuario1');
		$user1->setApiKey('74b87337454200d4d33f80c4663dc5e5');
		$user1->setPassword($passwordEncoder->encodePassword($user1, 'senha123!'));

		$manager->persist($user1);

		$user2 = new User();
		$user2->setUsername('usuario2');
		$user2->setApiKey('594f803b380a41396ed63dca39503542');
		$user2->setPassword($passwordEncoder->encodePassword($user2, 'senha1234!'));

		$manager->persist($user2);
		$manager->flush();
	}

	public function setContainer(ContainerInterface $container = null) {
		$this->container = $container;
	}

}