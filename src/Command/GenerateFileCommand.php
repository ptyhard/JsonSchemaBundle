<?php

declare(strict_types=1);

namespace Ptyhard\JsonSchemaBundle\Command;

use Ptyhard\JsonSchemaBundle\Exception\GeneratorException;
use Ptyhard\JsonSchemaBundle\FileWriter\WriterInterface;
use Symfony\Component\Config\ConfigCache;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\Compiler\ServiceLocatorTagPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class GenerateFileCommand extends Command
{
    protected static $defaultName = 'json-schema:generate:file';

    /**
     * @var WriterInterface
     */
    private $writer;

    /**
     * @var ContainerBuilder
     */
    private $containerBuilder;

    /**
     * GenerateJsonCommand constructor.
     */
    public function __construct(WriterInterface $writer)
    {
        parent::__construct();
        $this->writer = $writer;
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        $io = new SymfonyStyle($input, $output);
        $io->title('Generate class to json schema');

        $containerBuilder = $this->getContainerBuilder();
        foreach (
            array_keys(
                $containerBuilder->findTaggedServiceIds(
                    'controller.service_arguments'
                )
            ) as $controller
        ) {
            $refClass = new \ReflectionClass($controller);
            foreach ($refClass->getMethods() as $method) {
                foreach ($method->getParameters() as $parameter) {
                    try {
                        $class = $parameter->getClass();
                        if (null !== $class) {
                            $this->writer->write($parameter->getClass()->getName());
                        }
                    } catch (GeneratorException $ge) {
                        continue;
                    }
                }
            }
        }

        return 0;
    }

    private function getContainerBuilder(): ContainerBuilder
    {
        if ($this->containerBuilder) {
            return $this->containerBuilder;
        }

        $kernel = $this->getApplication()->getKernel();

        if (
            !$kernel->isDebug() ||
            !(new ConfigCache(
                $kernel->getContainer()->getParameter('debug.container.dump'),
                true
            ))->isFresh()
        ) {
            $buildContainer = \Closure::bind(
                fn () => $this->buildContainer(),
                $kernel,
                \get_class($kernel)
            );
            $container = $buildContainer();
            $container->getCompilerPassConfig()->setRemovingPasses([]);
            $container->getCompilerPassConfig()->setAfterRemovingPasses([]);
            $container->compile();
        } else {
            (new XmlFileLoader(
                ($container = new ContainerBuilder()),
                new FileLocator()
            ))->load(
                $kernel->getContainer()->getParameter('debug.container.dump')
            );
            $locatorPass = new ServiceLocatorTagPass();
            $locatorPass->process($container);
        }

        return $this->containerBuilder = $container;
    }
}
