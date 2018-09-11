<?php 

namespace App\Controller;

use App\Entity\Pessoa;
use App\Exception\ValidationException;
use FOS\RestBundle\Controller\ControllerTrait;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PessoasController extends AbstractController {

	use ControllerTrait;

	/**
	* @Rest\View()
	*/
	public function getPessoasAction() {

		$pessoas = $this->getDoctrine()->getRepository(Pessoa::class)->findAll();

		return $pessoas;
	}

	/**
	* @Rest\View(statusCode=201)
	* @ParamConverter("pessoa", converter="fos_rest.request_body")
	* @Rest\NoRoute()
	*/
	public function postPessoasAction(Pessoa $pessoa, ConstraintViolationListInterface $validationErrors) {

		if (count($validationErrors) > 0 ) {
			throw new ValidationException($validationErrors);
		}

		$em = $this->getDoctrine()->getManager();
		$em->persist($pessoa);
		$em->flush();

		return $pessoa;
	}

	/**
	* @Rest\View()
	*/
	public function deletePessoaAction(?Pessoa $pessoa) {

		if (null === $pessoa) {
			return $this->view(null, 404);
		}

		$em = $this->getDoctrine()->getManager();
		$em->remove($pessoa);
		$em->flush();

		return $pessoa;
	}

	/**
	* @Rest\View()
	*/
	public function getPessoaAction(?Pessoa $pessoa) {

		if (null === $pessoa) {
			return $this->view(null, 404);
		}

		return $pessoa;
	}
}