<?php

declare(strict_types=1);

namespace Cnab\Retorno\Cnab240;

use Cnab\Factory;

/**
 * Interface for return files.
 *
 * @author Your Name <your.email@example.com>
 * @copyright Your Copyright
 * @license  Your License
 * @version  1.0.0
 * @package  Cnab\Retorno\Cnab240
 *
 * @method HeaderArquivo getHeader() Returns the header object.
 * @method TrailerArquivo getTrailer() Returns the trailer object.
 * @method Lote[] getLotes() Returns an array of Lote objects.
 * @method Detalhe[] listDetalhes() Returns an array of Detalhe objects.
 * @method string getConta() Returns the account number.
 * @method string getContaDac() Returns the account DAC.
 * @method int getCodigoBanco() Returns the bank code.
 * @method \DateTime getDataGeracao() Returns the file generation date.
 * @method \DateTime getDataCredito() Returns the file credit date.
 * @method string getCodigoConvenio() Returns the convenience code.
 */
interface IArquivo
{
}

/**
 * Class representing a return file.
 *
 * @author Your Name <your.email@example.com>
 * @copyright Your Copyright
 * @license  Your License
 * @version  1.0.0
 * @package  Cnab\Retorno\Cnab240
 * @implements IArquivo
 */
final class Arquivo implements IArquivo
{
    /**
     * @var resource
     */
    private $content;

    /**
     * @var HeaderArquivo
     */
    private $header;

    /**
     * @var Lote[]
     */
    private $lotes = [];

    /**
     * @var TrailerArquivo
     */
    private $trailer;

    /**
     * @var int
     */
    private $codigo_banco;

    /**
     * @var string|null
     */
    private $filename;

    /**
     * @var string|null
     */
    private $layoutVersao;

    /**
     * Arquivo constructor.
     *
     * @param int    $codigo_banco
     * @param string $filename
     * @param string $layoutVersao
     *
     * @throws \Exception
     */
    private function __construct(int $codigo_banco, string $filename, string $layoutVersao = null)
    {
        $this->filename = $filename;
        $this->layoutVersao = $layoutVersao;

        if (!file_exists($this->filename)) {
            throw new \Exception("Arquivo não encontrado: {$this->filename}");
        }

        $this->content = file_get_contents($this->filename);

        $this->codigo_banco = $codigo_banco;

        $linhas = explode("\r\n", $this->content);
        if (count($linhas) < 2) {
            $linhas = explode("\n", $this->content);
        }

        $this->header = new HeaderArquivo($this);
        $this->trailer = new TrailerArquivo($this);

        $lastLote = null;

        foreach ($linhas as $linha) {
            if (!$linha) {
                continue;
            }

            $tipo_registro = substr($linha, 7, 1);

            if ($tipo_registro === '0') {
                // header
                $this->header->loadFromString($linha);
            } elseif ($tipo_registro === '1') {
                // header do lote
                if ($lastLote) {
                    $this->lotes[] = $lastLote;
                }
                $lastLote = new Lote($this);
                $lastLote->header = new HeaderLote($this);
                $lastLote->header->loadFromString($linha);
            } elseif ($tipo_registro === '2') {
                // registros iniciais do lote (opcional)
            } elseif ($tipo_registro === '3') {
                // registros de detalhe - Segmentos
                if ($lastLote) {
                    $lastLote->insertSegmento($linha);
                }
            } elseif ($tipo_registro === '4') {
                // registros finais do lote (opcional)
            } elseif ($tipo_registro === '5') {
                // registro trailer do lote
                $lastLote->trailer = new TrailerLote($this);
                $lastLote
