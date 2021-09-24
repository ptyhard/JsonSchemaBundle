<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\EventListener;

use Ptyhard\JsonSchemaBundle\Generator\ClassGeneratorInterface;
use Ptyhard\JsonSchemaBundle\SchemaObject\CheckerInterface;
use Ptyhard\JsonSchemaBundle\SchemaObject\ExporterInterface;
use Ptyhard\JsonSchemaBundle\Validator\ValidatorInterface;
use Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent;
use Symfony\Component\HttpKernel\Event\ViewEvent;

class SchemaClassValidationListener
{
    private ClassGeneratorInterface $classGenerator;
    private ValidatorInterface $validator;
    private ExporterInterface $exporter;
    private CheckerInterface $checker;

    public function __construct(
        ClassGeneratorInterface $classGenerator,
        ValidatorInterface $validator,
        ExporterInterface $exporter,
        CheckerInterface $checker
    ) {
        $this->classGenerator = $classGenerator;
        $this->validator = $validator;
        $this->exporter = $exporter;
        $this->checker = $checker;
    }

    /**
     * @throws \Exception
     */
    public function onKernelControllerArguments(
        ControllerArgumentsEvent $event
    ): void {
        $arguments = array_filter($event->getArguments(), fn ($argument) => $this->isSchemaObject($argument));

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

    public function onKernelView(ViewEvent $event): void
    {
        if (false === $this->isSchemaObject($event->getControllerResult())) {
            return;
        }

        $schema = $this->classGenerator->generate(
            \get_class($event->getControllerResult())
        );
        $data = $this->exporter->export($event->getControllerResult());
        $this->validator->check($data, $schema);

        $event->setControllerResult($data);
    }

    private function isSchemaObject($object): bool
    {
        return $this->checker->isSchemaObject($object);
    }
}
