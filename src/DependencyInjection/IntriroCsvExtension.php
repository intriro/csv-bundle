<?php
namespace Intriro\Bundle\CsvBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\LexerConfig;
use Symfony\Component\DependencyInjection\Definition;
use Goodby\CSV\Export\Standard\ExporterConfig;
use Goodby\CSV\Export\Standard\Exporter;

class IntriroCsvExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $this->loadImporters($config['importers'], $container);
        $this->loadExporters($config['exporters'], $container);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }

    /**
     * @param array            $config
     * @param ContainerBuilder $container
     */
    protected function loadImporters(array $config, ContainerBuilder $container)
    {
        foreach ($config as $exporterName => $exporterConfig) {
            $config = new LexerConfig();

            $lexerConfigDefinition = new Definition('Goodby\CSV\Import\Standard\LexerConfig');

            if ($exporterConfig['delimiter']) {
                $lexerConfigDefinition->addMethodCall('setDelimiter', [$exporterConfig['delimiter']]);
            }

            if ($exporterConfig['enclosure']) {
                $lexerConfigDefinition->addMethodCall('setEnclosure', [$exporterConfig['enclosure']]);
            }

            if ($exporterConfig['escape']) {
                $lexerConfigDefinition->addMethodCall('setEscape', [$exporterConfig['escape']]);
            }

            if ($exporterConfig['to_charset']) {
                $lexerConfigDefinition->addMethodCall('setToCharset', [$exporterConfig['to_charset']]);
            }

            if ($exporterConfig['from_charset']) {
                $lexerConfigDefinition->addMethodCall('setFromCharset', [$exporterConfig['from_charset']]);
            }

            $lexerDefinition = new Definition('Goodby\CSV\Import\Standard\Lexer', [$lexerConfigDefinition]);

            $lexerId = 'intriro_csv.exporter.'.$exporterName;

            $container->setDefinition($lexerId, $lexerDefinition);
        }
    }

    /**
     * @param array            $config
     * @param ContainerBuilder $container
     */
    protected function loadExporters(array $config, ContainerBuilder $container)
    {
        foreach ($config as $importerName => $importerConfig) {
            $config = new LexerConfig();

            $exporterConfigDefinition = new Definition('Goodby\CSV\Export\Standard\ExporterConfig');

            if ($importerConfig['delimiter']) {
                $exporterConfigDefinition->addMethodCall('setDelimiter', [$importerConfig['delimiter']]);
            }

            if ($importerConfig['enclosure']) {
                $exporterConfigDefinition->addMethodCall('setEnclosure', [$importerConfig['enclosure']]);
            }

            if ($importerConfig['escape']) {
                $exporterConfigDefinition->addMethodCall('setEscape', [$importerConfig['escape']]);
            }

            if ($importerConfig['to_charset']) {
                $exporterConfigDefinition->addMethodCall('setToCharset', [$importerConfig['to_charset']]);
            }

            if ($importerConfig['from_charset']) {
                $exporterConfigDefinition->addMethodCall('setFromCharset', [$importerConfig['from_charset']]);
            }

            $exporterDefinition = new Definition('Goodby\CSV\Export\Standard\Exporter', [$exporterConfigDefinition]);

            $lexerId = 'intriro_csv.importer.'.$importerName;

            $container->setDefinition($lexerId, $exporterDefinition);
        }
    }
}
