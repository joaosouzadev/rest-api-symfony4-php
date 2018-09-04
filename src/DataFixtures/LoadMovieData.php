<?php

namespace App\DataFixtures;

use App\Entity\Filme;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadMovieData extends Fixture {

	public function load(ObjectManager $manager) {

		$filme1 = new Filme();
		$filme1->setTitulo('Jason Bourne');
		$filme1->setAno(2002);
		$filme1->setDuracao(120);
		$filme1->setDescricao('Melhor filme de ação');

		$manager->persist($filme1);
		$manager->flush();
	}

}