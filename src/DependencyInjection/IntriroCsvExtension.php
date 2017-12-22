<?php

namespace Intriro\Bundle\CsvBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Definition;
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
    }

    /**
     * @param array            $config
     * @param ContainerBuilder $container
     */
    protected function loadImporters(array $config, ContainerBuilder $container)
    {
        foreach ($config as $importerName => $importerConfig) {
            $lexerConfigDefinition = new Definition('Goodby\CSV\Import\Standard\LexerConfig');

            if ($importerConfig['delimiter']) {
                $lexerConfigDefinition->addMethodCall('setDelimiter', [$importerConfig['delimiter']]);
            }

            if ($importerConfig['enclosure']) {
                $lexerConfigDefinition->addMethodCall('setEnclosure', [$importerConfig['enclosure']]);
            }

            if ($importerConfig['escape']) {
                $lexerConfigDefinition->addMethodCall('setEscape', [$importerConfig['escape']]);
            }

            if ($importerConfig['to_charset']) {
                $lexerConfigDefinition->addMethodCall('setToCharset', [$importerConfig['to_charset']]);
            }

            if ($importerConfig['from_charset']) {
                $lexerConfigDefinition->addMethodCall('setFromCharset', [$importerConfig['from_charset']]);
            }

            $lexerDefinition = new Definition('Goodby\CSV\Import\Standard\Lexer', [$lexerConfigDefinition]);

            $lexerId = 'intriro_csv.importer.'.$importerName;

            $container->setDefinition($lexerId, $lexerDefinition);
        }
    }

    /**
     * @param array            $config
     * @param ContainerBuilder $container
     */
    protected function loadExporters(array $config, ContainerBuilder $container)
    {
        foreach ($config as $exporterName => $exporterConfig) {
            $exporterConfigDefinition = new Definition('Goodby\CSV\Export\Standard\ExporterConfig');

            if ($exporterConfig['delimiter']) {
                $exporterConfigDefinition->addMethodCall('setDelimiter', [$exporterConfig['delimiter']]);
            }

            if ($exporterConfig['enclosure']) {
                $exporterConfigDefinition->addMethodCall('setEnclosure', [$exporterConfig['enclosure']]);
            }

            if ($exporterConfig['escape']) {
                $exporterConfigDefinition->addMethodCall('setEscape', [$exporterConfig['escape']]);
            }

            if ($exporterConfig['to_charset']) {
                $exporterConfigDefinition->addMethodCall('setToCharset', [$exporterConfig['to_charset']]);
            }

            if ($exporterConfig['from_charset']) {
                $exporterConfigDefinition->addMethodCall('setFromCharset', [$exporterConfig['from_charset']]);
            }

            $exporterDefinition = new Definition('Goodby\CSV\Export\Standard\Exporter', [$exporterConfigDefinition]);

            $lexerId = 'intriro_csv.exporter.'.$exporterName;

            $container->setDefinition($lexerId, $exporterDefinition);
        }
    }
}
