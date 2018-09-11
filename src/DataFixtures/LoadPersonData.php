<?php

namespace App\DataFixtures;

use App\Entity\Pessoa;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadPersonData extends Fixture {

	public function load(ObjectManager $manager) {

		$pessoa1 = new Pessoa();
		$pessoa1->setNome('Matt Damon');
		$pessoa1->setDataNascimento(new \DateTime('1957-12-10'));

		$manager->persist($pessoa1);
		$manager->flush();
	}

}