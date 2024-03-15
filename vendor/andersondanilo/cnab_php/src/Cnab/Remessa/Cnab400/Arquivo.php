<?php

declare(strict_types=1);

namespace Cnab\Remessa\Cnab400;

use Cnab\Banco;
use Cnab\Remessa\IArquivo;
use DateTime;
use Exception;

final class Arquivo implements IArquivo
{
    public const QUEBRA_LINHA = "\r\n";

    private $header;
    private $trailer;
    private array $detalhes = [];
    private ?string $_data_gravacao = null;
    private ?string $_data_geracao = null;
    public string $banco;
    public string $codigo_banco;
    public array $configuracao = [];
    public string $layout_versao;

    public function __construct(string $codigo_banco, ?string $layout_versao = null)
    {
        $this->codigo_banco = $codigo_banco;
        $this->layout_versao = $layout_versao;
        $this->banco = Banco::getBanco($this->codigo_banco)['nome_do_banco'] ?? '';
    }

    public function configure(array $params): self
    {
        $campos = [
            'data_geracao', 'data_gravacao', 'nome_fantasia', 'razao_social', 'cnpj', 'logradouro', 'numero', 'bairro', 
            'cidade', 'uf', 'cep',
        ];

        if ($this->codigo_banco === Banco::CEF) {
            //$campos[] = 'codigo_cedente';
            $campos[] = 'agencia';
            $campos[] = 'conta';
            $campos[] = 'operacao';
            $campos[] = 'codigo_cedente';
            $campos[] = 'codigo_cedente_dac';
        } else {
            $campos[] = 'agencia';
            $campos[] = 'conta';
            $campos[] = 'conta_dac';
        }

        foreach ($campos as $campo) {
            if (!array_key_exists($campo, $params)) {
                throw new Exception('Configuração "' . $campo . '" need to be set');
            }

            if (strpos($campo, 'data_') === 0 && !($params[$campo] instanceof DateTime)) {
                throw new Exception("config '$campo' need to be instance of DateTime");
            }

            $this->configuracao[$campo] = $params[$campo];
        }

        $this->data_geracao = $this->configuracao['data_geracao'] ?? date('dmy');
        $this->data_gravacao = $this->configuracao['data_gravacao'] ?? date('dmY');

        $this->header = new Header($this);

        $this->header->codigo_banco = $this->banco['codigo_do_banco'];
        $this->header->nome_banco = $this->banco['nome_do_banco'];

        if ($this->codigo_banco === Banco::CEF) {
            $this->header->codigo_cedente = $this->configuracao['codigo_cedente'] ?? '';
        } else {
            $this->header->agencia = $this->configuracao['agencia'] ?? '';
            $this->header->conta = $this->configuracao['conta'] ?? '';
            $this->header->conta_dv = $this->configuracao['conta_dac'] ?? '';
        }

        $this->header->nome_empresa = $this->configuracao['nome_fantasia'] ?? '';
        $this->header->data_geracao = ($this->configuracao['data_geracao'] ?? date('dmy'))->format('dmy');

        return $this;
    }

    public function insertDetalhe(array $boleto, string $tipo = 'remessa'): self
    {
        //...

        return $this;
    }

    public function listDetalhes(): array
    {
        return $this->detalhes;
    }

    public function withCodigoBanco(string $codigo_banco): self
    {
        $this->codigo_banco = $codigo_banco;
        return $this;
    }

    public function withLayoutVersao(?string $layout_versao = null): self
    {
        $this->layout_versao = $layout_versao;
        return $this;
    }

    public function withConfiguracao(array $configuracao): self
    {
        $this->configuracao = $configuracao;
        return $this;
    }

    public function withDataGravacao(?string $data_gravacao = null): self
    {
        $this->_data_gravacao = $data_gravacao;
        return $this;
    }

    public function withDataGeracao(?string $data_geracao = null): self
    {
        $this->_data_geracao = $data_geracao;
        return $this;
