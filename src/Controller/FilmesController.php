<?php 

namespace App\Controller;

use App\Entity\Filme;
use App\Entity\Papel;
use App\Exception\ValidationException;
use FOS\RestBundle\Controller\ControllerTrait;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;

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
	public function postFilmesAction(Filme $filme, ConstraintViolationListInterface $validationErrors) {

		if (count($validationErrors) > 0 ) {
			throw new ValidationException($validationErrors);
		}

		$em = $this->getDoctrine()->getManager();
		$em->persist($filme);
		$em->flush();

		return $filme;
	}

	/**
	* @Rest\View()
	*/
	public function deleteFilmeAction(?Filme $filme) {

		if (null === $filme) {
			return $this->view(null, 404);
		}

		$em = $this->getDoctrine()->getManager();
		$em->remove($filme);
		$em->flush();

		return $filme;
	}

	/**
	* @Rest\View()
	*/
	public function getFilmeAction(?Filme $filme) {

		if (null === $filme) {
			return $this->view(null, 404);
		}

		return $filme;
	}

	/**
	* @Rest\View()
	*/
	public function getPapeisFilmeAction(Filme $filme) {

		return $movie->getPapeis();
	}

	/**
	* @Rest\View(statusCode=201)
	* @ParamConverter("papel", converter="fos_rest.request_body")
	* @Rest\NoRoute()
	*/
	public function postPapeisFilmeAction(Filme $filme, Papel $papel) {

		$papel->setFilme($filme);

		$em = $this->getDoctrine()->getManager();

		$em->persist($papel);
		$em->flush();

		$em->persist($filme);
		$em->flush();

		return $papel;
	}
}