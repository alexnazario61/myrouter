<?php

namespace Cnab\Tests\Format;

use Cnab\Format\YamlLoad;
use Cnab\Format\Linha;
use Cnab\Format\Field;

require_once __DIR__ . '/../../vendor/autoload.php';

class YamlLoadTest
{
    /**
     * Test YamlLoad class.
     */

    public function testValidateCollisionWithOverlappingFields(): void
    {
        $yamlLoad = new YamlLoad(0);

        $fields = [
            'codigo_banco' => new Field(['pos' => [1, 3]]),
            'tipo_registro' => new Field(['pos' => [1, 4]]),
        ];

        $this->assertFalse($yamlLoad->validateCollision($fields));
    }

    public function testValidateCollisionWithNonOverlappingFields(): void
    {
        $yamlLoad = new YamlLoad(0);

        $fields1 = [
            'codigo_banco' => new Field(['pos' => [1, 3]]),
            'tipo_registro' => new Field(['pos' => [4, 4]]),
        ];

        $fields2 = [
            'codigo_banco' => new Field(['pos' => [1, 3]]),
        ];

        $this->assertTrue($yamlLoad->validateCollision($fields1));
        $this->assertTrue($yamlLoad->validateCollision($fields2));
    }

    public function testValidateArrayWithMalformedArray(): void
    {
        $array = [
            'generic' => [
                'codigo_banco' => new Field(['pos' => [1, 3]]),
                'tipo_registro' => new Field(['pos' => [4, 4]]),
            ],
            '033' => [
                'nome_empresa' => new Field(['pos' => [40, 80]]),
                'numero_inscricao' => new Field(['pos' => [79, 80]]),
            ],
        ];

        $yamlLoad = new YamlLoad(0);
        $this->expectException(\DomainException::class);
        $yamlLoad->validateArray($array);
    }

    public function testValidateArrayWithValidArray(): void
    {
        $array = [
            'generic' => [
                'codigo_banco' => new Field(['pos' => [1, 3]]),
                'tipo_registro' => new Field(['pos' => [4, 4]]),
            ],
            '033' => [
                'nome_empresa' => new Field(['pos' => [40, 80]]),
                'numero_inscricao' => new Field(['pos' => [81, 81]]),
            ],
        ];

        $yamlLoad = new YamlLoad(0);
        $this->assertTrue($yamlLoad->validateArray($array));
    }

    public function testLoadGenericAndSpecificFormats(): void
    {
        $yamlLoad = $this->getMockBuilder(YamlLoad::class)
            ->setMethods(['loadYaml'])
            ->setConstructorArgs([33])
            ->getMock();

        $testFormat = [
            'codigo_banco' => new Field(['pos' => [1, 3]]),
        ];

        $yamlLoad->expects($this->at(0))
            ->method('loadYaml')
            ->with(
                $this->equalTo($yamlLoad->formatPath . '/cnab240/generic/header_lote.yml')
            )
            ->will($this->returnValue($testFormat));

        $yamlLoad->expects($this->at(1))
            ->method('loadYaml')
            ->with(
                $this->equalTo($yamlLoad->formatPath . '/cnab240/033/header_lote.yml')
            )
            ->will($this->returnValue($testFormat));

        $linha = new Linha;
        $yamlLoad->load($linha, 'cnab240', 'header_lote');
    }
}
