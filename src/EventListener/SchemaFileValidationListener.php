<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\EventListener;

use Doctrine\Common\Annotations\Reader;
use Ptyhard\JsonSchemaBundle\Annotations\SchemaFile;
use Ptyhard\JsonSchemaBundle\Generator\Schema\SchemaGeneratorResolver;
use Ptyhard\JsonSchemaBundle\Validator\ValidatorInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Event\ViewEvent;

class SchemaFileValidationListener
{
    private const JSON_SCHEMA_ATTR = 'json_schema.file';

    private Reader $annotationReader;
    private SchemaGeneratorResolver $schemaGeneratorResolver;
    private ValidatorInterface $validator;

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
     * @throws \JsonException
     */
    public function onKernelController(ControllerEvent $event): void
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
            array_map(static fn(\ReflectionAttribute $attribute) => $attribute->newInstance(), $object->getAttributes(SchemaFile::class)),
            array_map(static fn(\ReflectionAttribute $attribute) => $attribute->newInstance(), $method->getAttributes(SchemaFile::class)),
        );

        if (empty($schemaAnnotations)) {
            return;
        }

        foreach ($schemaAnnotations as $annotation) {
            if ($annotation->isRequestCheck()) {
                $this->validator->check(
                    json_decode($request->getContent(), true, 512, \JSON_THROW_ON_ERROR),
                    $this->schemaGeneratorResolver
                        ->resolve($annotation)
                        ->generate($annotation)
                );
                break;
            }
        }
        $request->attributes->set(self::JSON_SCHEMA_ATTR, $schemaAnnotations);
    }

    public function onKernelView(ViewEvent $event): void
    {
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

}
