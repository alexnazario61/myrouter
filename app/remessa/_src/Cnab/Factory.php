<?php

namespace Cnab;

use DirectoryIterator;
use Exception;
use InvalidArgumentException;

class Factory
{
    private static $cnabFormatPath;

    public static function getCnabFormatPath(): string
    {
        if (self::$cnabFormatPath === null) {
            $optionA = dirname(__FILE__) . '/../../../cnab_yaml';
            $optionB = dirname(__FILE__) . '/../../vendor/elsonlima/cnab_yaml';

            foreach ([$optionA, $optionB] as $path) {
                if (file_exists($path)) {
                    self::setCnabFormatPath($path);
                    break;
                }
            }

            if (self::$cnabFormatPath === null) {
                throw new Exception("cnab_yaml não está instalado ou não foi configurado");
            }
        }

        return self::$cnabFormatPath;
    }

    public static function setCnabFormatPath(?string $value = null): void
    {
        self::$cnabFormatPath = $value;
    }

    /**
     * Cria um arquivo de remessa
     * @return \Cnab\Remessa\IArquivo
     */
    public function createRemessa(string $codigo_banco, string $formato = 'cnab400', ?string $layoutVersao = null): IArquivo
    {
        if (empty($codigo_banco)) {
            throw new InvalidArgumentException('$codigo_banco cannot be empty');
        }

        switch ($formato) {
            case 'cnab400':
                return new Remessa\Cnab400\Arquivo($codigo_banco, $layoutVersao);
            case 'cnab240':
                return new Remessa\Cnab240\Arquivo($codigo_banco, $layoutVersao);
            default:
                throw new InvalidArgumentException('Invalid cnab format: ' . $formato);
        }
    }

    /**
     * Cria um arquivo de retorno
     * @param  string $filename
     * @return \Cnab\Remessa\IArquivo
     */
    public function createRetorno(string $filename): IArquivo
    {
        $identifier = new Format\Identifier;

        if (empty($filename)) {
            throw new InvalidArgumentException('$filename cannot be empty');
        }

        $format = $identifier->identifyFile($filename);

        if (!$format) {
            throw new Exception('Formato do arquivo não identificado');
        }

        if ($format['tipo'] != 'retorno') {
            throw new Exception('Este não é um arquivo de retorno');
        }

        if (!$format['banco']) {
            throw new Exception('Banco não suportado');
        }

        if (!\Cnab\Banco::existBanco($format['banco'])) {
            throw new Exception('Banco não suportado');
        }

        // por enquanto só suporta o Cnab400

        if ($format['bytes'] == 400) {
            return new Retorno\Cnab400\Arquivo($format['banco'], $filename, $format['layout_versao']);
        } elseif ($format['bytes'] == 240) {
            return new Retorno\Cnab240\Arquivo($format['banco'], $filename, $format['layout_versao']);
        } else {
            throw new Exception('Formato não suportado');
        }
    }
}

spl_autoload_register(function ($class) {
    $prefix = 'Cnab\\';

    if (strncmp($prefix, $class, strlen($prefix)) !== 0) {
        return;
    }

    $class = str_replace($prefix, '', $
