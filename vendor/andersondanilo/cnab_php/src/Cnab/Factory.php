<?php
namespace Cnab;

class Factory
{
    private static $cnabFormatPath = null;

    public static function getCnabFormatPath() {
        if (self::$cnabFormatPath === null) {
            $optionA = dirname(__FILE__).'/../../../cnab_yaml';
            $optionB = dirname(__FILE__).'/../../vendor/andersondanilo/cnab_yaml';

            self::$cnabFormatPath = file_exists($optionA) ? $optionA : (file_exists($optionB) ? $optionB : null);

            if (self::$cnabFormatPath === null) {
                throw new \Exception("cnab_yaml não está instalado ou não foi configurado");
            }
        }

        return self::$cnabFormatPath;
    }

    public static function setCnabFormatPath(?string $value): void {
        self::$cnabFormatPath = $value;
    }

	/**
	 * Cria um arquivo de remessa
	 * @param string $codigo_banco
	 * @param string $formato
	 * @param string|null $layoutVersao
	 * @return \Cnab\Remessa\IArquivo
	 */
	public function createRemessa(string $codigo_banco, string $formato='cnab400', ?string $layoutVersao=null): \Cnab\Remessa\IArquivo
	{
		if(empty($codigo_banco))
			throw new \InvalidArgumentException('$codigo_banco cannot be empty');

        if($formato !== 'cnab400' && $formato !== 'cnab240')
            throw new \InvalidArgumentException('Invalid cnab format: ' . $formato);

        if($formato === 'cnab400')
            return new Remessa\Cnab400\Arquivo($codigo_banco, $layoutVersao);

        return new Remessa\Cnab240\Arquivo($codigo_banco, $layoutVersao);
	}

	/**
	 * Cria um arquivo de retorno
	 * @param string $filename
	 * @return \Cnab\Remessa\IArquivo
	 * @throws \Exception
	 */
	public function createRetorno(string $filename): \Cnab\Remessa\IArquivo
	{
		if(empty($filename))
            throw new \InvalidArgumentException('$filename cannot be empty');

        $format = (new Format\Identifier)->identifyFile($filename);

        if(!$format)
            throw new \Exception('Formato do arquivo não identificado');

        if($format['tipo'] != 'retorno')
            throw new \Exception('Este não é um arquivo de retorno');

        if(!$format['banco'])
            throw new \Exception('Banco não suportado');

        if(!\Cnab\Banco::existBanco($format['banco']))
            throw new \Exception('Banco não suportado');

        if(!interface_exists('Cnab\\Remessa\\Cnab400\\IArquivo') || !interface_exists('Cnab\\Remessa\\Cnab240\\IArquivo'))
            throw new \Exception('Cnab400 or Cnab240 namespaces not found');

        if($format['bytes'] == 400)
        {
    		return new Retorno\Cnab400\Arquivo($format['banco'], $filename, $format['layout_versao']);
        }
        else if($format['bytes'] == 240)
        {
    		return new Retorno\Cnab240\Arquivo($format['banco'], $filename, $format['layout_versao']);
        }
        else
            throw new \Exception('Formato não
