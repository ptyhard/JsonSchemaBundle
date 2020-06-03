<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\EventListener;

use Doctrine\Common\Annotations\Reader;
use Ptyhard\JsonSchemaBundle\Annotations\SchemaFile;
use Ptyhard\JsonSchemaBundle\Generator\Schema\SchemaGeneratorResolver;
use Ptyhard\JsonSchemaBundle\Validator\ValidatorInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;

class SchemaFileValidationListener
{
    private const JSON_SCHEMA_ATTR = 'json_schema.file';

    /**
     * @var Reader
     */
    private $annotationReader;

    /**
     * @var SchemaGeneratorResolver
     */
    private $schemaGeneratorResolver;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function __construct(
        Reader $annotationReader,
        SchemaGeneratorResolver $schemaGeneratorResolver,
        ValidatorInterface $validator
    ) {
        $this->annotationReader = $annotationReader;
        $this->schemaGeneratorResolver = $schemaGeneratorResolver;
        $this->validator = $validator;
    }

    /**
     * @throws \ReflectionException
     */
    public function onKernelController(FilterControllerEvent $event): void
    {
        $request = $event->getRequest();
        $controller = $event->getController();
        if (!\is_array($controller) && method_exists($controller, '__invoke')) {
            $controller = [$controller, '__invoke'];
        } elseif (!\is_array($controller)) {
            return;
        }
        $className = \get_class($controller[0]);
        $object = new \ReflectionClass($className);
        $method = $object->getMethod($controller[1]);

        /** @var SchemaFile[] $schemaAnnotations */
        $schemaAnnotations = array_merge(
            $this->getAnnotations(
                $this->annotationReader->getClassAnnotations($object)
            ),
            $this->getAnnotations(
                $this->annotationReader->getMethodAnnotations($method)
            )
        );

        if (empty($schemaAnnotations)) {
            return;
        }

        foreach ($schemaAnnotations as $annotation) {
            if ($annotation->isRequestCheck()) {
                $this->validator->check(
                    json_decode($request->getContent(), true),
                    $this->schemaGeneratorResolver
                        ->resolve($annotation)
                        ->generate($annotation)
                );
                break;
            }
        }
        $request->attributes->set(self::JSON_SCHEMA_ATTR, $schemaAnnotations);
    }

    public function onKernelView(
        GetResponseForControllerResultEvent $event
    ): void {
        if (false === \is_array($event->getControllerResult())) {
            return;
        }

        $request = $event->getRequest();
        if (false === $request->attributes->has(self::JSON_SCHEMA_ATTR)) {
            return;
        }

        /** @var SchemaFile[] $schemaAnnotations */
        $schemaAnnotations = $request->attributes->get(self::JSON_SCHEMA_ATTR);
        foreach ($schemaAnnotations as $annotation) {
            if ($annotation->isResponseCheck()) {
                $this->validator->check(
                    $event->getControllerResult(),
                    $this->schemaGeneratorResolver
                        ->resolve($annotation)
                        ->generate($annotation)
                );
                break;
            }
        }
    }

    private function getAnnotations(array $annotations): array
    {
        return array_filter($annotations, function ($annotation) {
            return $annotation instanceof SchemaFile;
        });
    }
}
