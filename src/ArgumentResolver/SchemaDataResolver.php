<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\ArgumentResolver;

use Ptyhard\JsonSchemaBundle\SchemaObject\CheckerInterface;
use Ptyhard\JsonSchemaBundle\SchemaObject\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class SchemaDataResolver implements ArgumentValueResolverInterface
{
    /**
     * @var FactoryInterface
     */
    private $factory;

    /**
     * @var CheckerInterface
     */
    private $checker;

    /**
     * @param FactoryInterface $factory
     * @param CheckerInterface $checker
     */
    public function __construct(FactoryInterface $factory, CheckerInterface $checker)
    {
        $this->factory = $factory;
        $this->checker = $checker;
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return $this->checker->isSchemaClass($argument->getType());
    }

    public function resolve(Request $request, ArgumentMetadata $argument): \Generator
    {
        yield $this->factory->create($argument->getType(), json_decode($request->getContent(), true));
    }
}
