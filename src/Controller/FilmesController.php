<?php 

namespace App\Controller;

use App\EntityMerger\EntityMerger;
use App\Entity\Filme;
use App\Entity\Papel;
use App\Exception\ValidationException;
use FOS\RestBundle\Controller\ControllerTrait;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
* @Security("is_anonymous() or is_authenticated()")
**/
class FilmesController extends AbstractController {

	use ControllerTrait;

	private $entityMerger;

	public function __construct(EntityMerger $entityMerger) {
		$this->entityMerger = $entityMerger;
	}

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
	public function getFilmePapeisAction(Filme $filme) {

		return $filme->getPapeis();
	}

	/**
	* @Rest\View(statusCode=201)
	* @ParamConverter("papel", converter="fos_rest.request_body", options={"deserializationContext"={"groups"={"Deserialize"}}})
	* @Rest\NoRoute()
	*/
	public function postPapeisFilmeAction(Filme $filme, Papel $papel, ConstraintViolationListInterface $validationErrors) {

		if (count($validationErrors) > 0 ) {
			throw new ValidationException($validationErrors);
		}

		$papel->setFilme($filme);

		$em = $this->getDoctrine()->getManager();

		$em->persist($papel);
		$em->flush();

		$em->persist($filme);
		$em->flush();

		return $papel;
	}

	/**
	* @Rest\NoRoute()
	* @ParamConverter("filmeModificado", converter="fos_rest.request_body", 
	* options={"validator" = {"groups" = {"Patch"}}})
	* @Security("is_authenticated()")
	*/
	public function patchFilmeAction(?Filme $filme, Filme $filmeModificado, ConstraintViolationListInterface $validationErrors) {

		if (null === $filme) {
			return $this->view(null, 404);
		}

		if (count($validationErrors) > 0 ) {
			throw new ValidationException($validationErrors);
		}

		$this->entityMerger->merge($filme, $filmeModificado);

		$em = $this->getDoctrine()->getManager();
		$em->persist($filme);
		$em->flush();

		return $filme;
	}
}