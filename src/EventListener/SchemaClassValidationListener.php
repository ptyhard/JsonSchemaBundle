<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\EventListener;

use Ptyhard\JsonSchemaBundle\Generator\ClassGeneratorInterface;
use Ptyhard\JsonSchemaBundle\SchemaObject\CheckerInterface;
use Ptyhard\JsonSchemaBundle\SchemaObject\ExporterInterface;
use Ptyhard\JsonSchemaBundle\Validator\ValidatorInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerArgumentsEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;

class SchemaClassValidationListener
{
    /**
     * @var ClassGeneratorInterface
     */
    private $classGenerator;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var ExporterInterface
     */
    private $exporter;

    /**
     * @var CheckerInterface
     */
    private $checker;

    /**
     * @param ClassGeneratorInterface $classGenerator
     * @param ValidatorInterface $validator
     * @param ExporterInterface  $exporter
     * @param CheckerInterface   $checker
     */
    public function __construct(ClassGeneratorInterface $classGenerator, ValidatorInterface $validator, ExporterInterface $exporter, CheckerInterface $checker)
    {
        $this->classGenerator = $classGenerator;
        $this->validator = $validator;
        $this->exporter = $exporter;
        $this->checker = $checker;
    }

    public function onKernelControllerArguments(FilterControllerArgumentsEvent $event): void
    {
        $arguments = array_filter($event->getArguments(), function ($argument) {
            return $this->isSchemaObject($argument);
        });

        if (\count($arguments) < 1) {
            return;
        }

        if (\count($arguments) > 1) {
            throw new \Exception('argument over'); // TODO exception
        }

        $argument = array_pop($arguments);
        $schema = $this->classGenerator->generate(\get_class($argument));
        $this->validator->check($this->exporter->export($argument), $schema);
    }

    public function onKernelView(GetResponseForControllerResultEvent $event): void
    {
        if (false === $this->isSchemaObject($event->getControllerResult())) {
            return;
        }

        $schema = $this->classGenerator->generate(\get_class($event->getControllerResult()));
        $data = $this->exporter->export($event->getControllerResult());
        $this->validator->check($data, $schema);

        $event->setControllerResult($data);
    }

    private function isSchemaObject($object): bool
    {
        return $this->checker->isSchemaObject($object);
    }
}
