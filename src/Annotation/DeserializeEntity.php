<?php

namespace App\Annotation;

use Doctrine\Common\Annotations\Annotation\Target;

/**
* @Annotation
* @Target({"PROPERTY"})
*/
final class DeserializeEntity {

	/**
	* @Required()
	*/
	public $type;

	/**
	* @Required()
	*/
	public $idField;

	/**
	* @Required()
	*/
	public $setter;

	/**
	* @Required()
	*/
	public $idGetter;
}