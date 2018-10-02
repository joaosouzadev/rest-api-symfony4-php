<?php

namespace App\EntityMerger;

use Doctrine\Common\Annotations\Reader;
use Doctrine\ORM\Mapping;

class EntityMerger {

	private $annotationReader;

	public function __construct(Reader $annotationReader) {

		$this->annotationReader = $annotationReader;
	}

	public function merge($entity, $changes): void {

		$entityClassName = get_class($entity);

		if (false === $entityClassName) {
			throw new \InvalidArgumentException('$entity não é uma classe');
		}

		$changesClassName = get_class($changes);

		if (false === $changesClassName) {
			throw new \InvalidArgumentException('$changes não é uma classe');
		}

		// Prossegue se objeto $changes é do mesmo tipo que $entity ou se é uma subclasse de $entity
		if (!is_a($changes, $entityClassName)) {
			throw new \InvalidArgumentException('Não é possível combinar objeto da classe $changesClassName com objeto da classe $entityClassName');
		}

		$entityReflection = new \ReflectionObject($entity);
		$changesReflection = new \ReflectionObject($changes);

		foreach ($changesReflection->getProperties() as $changedProperty) {
			$changedProperty->setAccessible(true);
			$changedPropertyValue = $changedProperty->getValue($changes);

			// Ignora propriedades nulas de $changes
			if (null === $changedPropertyValue) {
				continue;
			}

			// Ignora propriedades de $changes se ela não estiver presente em $entity
			if (!$entityReflection->hasProperty($changedProperty->getName())) {
				continue;
			}

			$entityProperty = $entityReflection->getProperty($changedProperty->getName());
			$annotation = $this->annotationReader->getPropertyAnnotation($entityProperty, Id::class);

			// Ignora propriedades de $changes que tem annotation @Id
			if (null !== $annotation) {
				continue;
			}

			$entityProperty->setAccessible(true);
			$entityProperty->setValue($entity, $changedPropertyValue);
		}
	}
}