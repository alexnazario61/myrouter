<?php

declare(strict_types=1);

namespace Cnab\Retorno\Cnab400;

use Cnab\Retorno\IArquivo;
use DateTime;

class Arquivo implements IArquivo
{
    private string $content;
    public bool $header = false;
    public array $detalhes = [];
    public bool $trailer = false;
    public string $codigo_banco;
    private string $filename;

    public function __construct(string $codigo_banco, string $filename)
    {
        $this->filename = $filename;

        if (!file_exists($this->filename)) {
            throw new \Exception("Arquivo não encontrado: {$this->filename}");
        }

        $this->content = file_get_contents($this->filename);

        $this->codigo_banco = (int)$codigo_banco;

        $linhas = $this->parseLinhas($this->content);
        $this->header = new Header($this);
        $this->trailer = new Trailer($this);

        foreach ($linhas as $linha) {
            $tipo_registro = substr($linha, 0, 1);
            if ($tipo_registro === '0' && $linha) {
                $this->header->loadFromString($linha);
            } elseif ($tipo_registro === '1') {
                $detalhe = new Detalhe($this);
                $detalhe->loadFromString($linha);
                $this->detalhes[] = $detalhe;
            } elseif ($tipo_registro === '9') {
                $this->trailer->loadFromString($linha);
            }
        }
    }

    public function listDetalhes(): array
    {
        return $this->detalhes;
    }

    /**
     * Retorna o numero da conta
     * @return String
     */
    public function getConta(): string
    {
        return $this->header->getConta();
    }

    /**
     * Retorna o código do cedente / código da empresa / código do convênio (cada banco chama de um nome)
     * @return String
     */
    public function getCodigoCedente(): string
    {
        return $this->header->getCodigoCedente();
    }

    /**
     * Retorna o digito de auto conferencia da conta
     * @return String
     */
    public function getContaDac(): string
    {
        return $this->header->getContaDac();
    }

    /**
     * Retorna o codigo do banco
     * @return String
     */
    public function getCodigoBanco(): string
    {
        return $this->header->codigo_do_banco;
    }

    /**
     * Retorna a data de geração do arquivo
     * @return \DateTime
     */
    public function getDataGeracao(): ?DateTime
    {
        $data = $this->header->data_de_geracao ? DateTime::createFromFormat('dmy', sprintf('%06d', $this->header->data_de_geracao)) : null;
        if ($data) {
            $data->setTime(0, 0, 0);
        }

        return $data;
    }

    /**
     * Retorna o objeto DateTime da data crédito do arquivo
     * É melhor consultar no Detalhe a data de crédito, a caixa só informa no detalhe
     * (Esta função poderá ser removida, pois em alguns banco você só encontra esta data no detalhe)
     * @return DateTime
     */
    public function getDataCredito(): ?DateTime
    {
        if ($this->header->existField('data_de_credito')) {
            $data = $this->header->data_de_credito ? DateTime::createFromFormat('dmy', sprintf('%06d', $this->header->data_de_credito)) : null;
            if ($data) {
                $data->setTime(0, 0, 0);
            }

            return $data;
        }

        return null;
    }

   
