<?php

namespace Intriro\Bundle\CsvBundle\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

class IntriroCsvExtensionTest extends TestCase
{
    /**
     * @var ExtensionInterface
     */
    private $extension;

    /**
     * @param $config
     *
     * @test
     * @dataProvider configProvider
     */
    public function testConfigLoad($config)
    {
        $this->extension->load([$config], $container = $this->getContainer());

        $this->assertTrue($container->hasDefinition('intriro_csv.importer.foo'));
        $this->assertTrue($container->hasDefinition('intriro_csv.importer.bar'));
        $this->assertTrue($container->hasDefinition('intriro_csv.exporter.foo'));
        $this->assertTrue($container->hasDefinition('intriro_csv.exporter.bar'));
    }

    /**
     * @param $config
     *
     * @test
     * @dataProvider configProvider
     */
    public function testObjectGeneration($config)
    {
        $this->extension->load([$config], $container = $this->getContainer());

        $importer1 = $container->get('intriro_csv.importer.foo');
        $importer2 = $container->get('intriro_csv.importer.bar');
        $exporter1 = $container->get('intriro_csv.exporter.foo');
        $exporter2 = $container->get('intriro_csv.exporter.bar');

        $this->assertInstanceOf('Goodby\CSV\Import\Standard\Lexer', $importer1);
        $this->assertInstanceOf('Goodby\CSV\Import\Standard\Lexer', $importer2);
        $this->assertInstanceOf('Goodby\CSV\Export\Standard\Exporter', $exporter1);
        $this->assertInstanceOf('Goodby\CSV\Export\Standard\Exporter', $exporter2);
    }

    /**
     * @return array
     */
    public function configProvider()
    {
        return [
            [
                [
                    'importers' => [
                        'foo' => [],
                        'bar' => [
                            'delimiter' => '\t',
                            'enclosure' => '\'',
                            'escape' => '\\',
                            'to_charset' => 'UTF-8',
                            'from_charset' => 'SJIS-win',
                        ],
                    ],
                    'exporters' => [
                        'foo' => [],
                        'bar' => [
                            'delimiter' => '\t',
                            'enclosure' => '\'',
                            'escape' => '\\',
                            'to_charset' => 'SJIS-win',
                            'from_charset' => 'UTF-8',
                            'file_mode' => 'SJIS-win',
                        ],
                    ],
                ],
            ],
        ];
    }

    protected function setUp()
    {
        $this->extension = new IntriroCsvExtension();
    }

    private function getContainer()
    {
        $container = new ContainerBuilder();
        $container->setParameter('kernel.cache_dir', sys_get_temp_dir());

        return $container;
    }
}
