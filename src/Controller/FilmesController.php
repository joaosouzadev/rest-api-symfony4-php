<?php 

namespace App\Controller;

use App\Entity\Filme;
use FOS\RestBundle\Controller\ControllerTrait;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FilmesController extends AbstractController {

	use ControllerTrait;

	/**
	* @Rest\View()
	*/
	public function getFilmesAction() {

		$filmes = $this->getDoctrine()->getRepository(Filme::class)->findAll();

		return $filmes;
	}

	/**
	* @Rest\View(statusCode=201)
	* @ParamConverter("filme", converter="fos_rest.request_body")
	* @Rest\NoRoute()
	*/
	public function postFilmesAction(Filme $filme) {

		$em = $this->getDoctrine()->getManager();
		$em->persist($filme);
		$em->flush();

		return $filme;
	}
}