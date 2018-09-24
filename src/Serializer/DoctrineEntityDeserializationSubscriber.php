<?php 

namespace App\Serializer;

use Doctrine\Common\Annotations\Reader;
use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\ObjectEvent;
use JMS\Serializer\EventDispatcher\PreDeserializeEvent;
use App\Annotation\DeserializeEntity;
use JMS\Serializer\Exception;
use JMS\Serializer\Exception\LogicException;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DoctrineEntityDeserializationSubscriber implements EventSubscriberInterface {

	private $annotationReader;

	private $doctrineRegistry;

	public function __construct(Reader $annotationReader, RegistryInterface $doctrineRegistry) {

		$this->annotationReader = $annotationReader;
		$this->doctrineRegistry = $doctrineRegistry;
	}

	public static function getSubscribedEvents() {

		return [
			[
				'event' => 'serializer.pre_deserialize',
				'method' => 'onPreDeserialize',
				'format' => 'json'
			],
			[
				'event' => 'serializer.post_deserialize',
				'method' => 'onPostDeserialize',
				'format' => 'json'
			]
		];
	}

	public function onPreDeserialize(PreDeserializeEvent $event) {

		// dump($event->getData());
		$deserializedType = $event->getType()['name'];

		if (!class_exists($deserializedType)) {
			return;
		}

		$data = $event->getData();
		$class = new \ReflectionClass($deserializedType);

		// dump($class);die;

		foreach($class->getProperties() as $property) {

			if (!isset($data[$property->name])) {
				continue;
			}

			$annotation = $this->annotationReader->getPropertyAnnotation(
				$property,
				DeserializeEntity::class
			);

			// dump($annotation);

			if (null === $annotation || !class_exists($annotation->type)) {
				continue;
			}

			$data[$property->name] = [ $annotation->idField => $data[$property->name] ];

			// dump($data);die;
		}

		$event->setData($data);
	}

	public function onPostDeserialize(ObjectEvent $event) {

		$deserializedType = $event->getType()['name'];

		if (!class_exists($deserializedType)) {
			return;
		}

		$object = $event->getObject();
		// dump($object);die;
		$reflection = new \ReflectionObject($object);

		foreach ($reflection->getProperties() as $property) {
			$annotation = $this->annotationReader->getPropertyAnnotation(
				$property,
				DeserializeEntity::class
			);

			// dump($reflection);die;

			if (null === $annotation || !class_exists($annotation->type)) {
				continue;
			}

			if (!$reflection->hasMethod($annotation->setter)) {
				throw new \LogicException("Objeto {$reflection->getName()} não contém o método {$annotation->setter}");
			}

			$property->setAccessible(true);
			$deserializedEntity = $property->getValue($object);

			// dump($deserializedEntity);die;

			if (null === $deserializedEntity) {
				return;
			}

			$entityId = $deserializedEntity->{$annotation->idGetter}();
			// dump($entityId);die;
			$repository = $this->doctrineRegistry->getRepository($annotation->type);
			// dump($repository);die;
			$entity = $repository->find($entityId);
			// dump($entity);die;

			if (null === $entity) {
				throw new NotFoundHttpException("Resource {$reflection->getShortName()}/$entityId não existe");
			}

			$object->{$annotation->setter}($entity);
		}
	}
}