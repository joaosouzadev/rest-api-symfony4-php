<?php 

namespace App\Controller;

use App\Entity\Filme;
use FOS\RestBundle\Controller\ControllerTrait;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FilmesController extends AbstractController {

	use ControllerTrait;

	public function getFilmesAction() {

		$filmes = $this->getDoctrine()->getRepository(Filme::class)->findAll();

		return $filmes;
	}
}