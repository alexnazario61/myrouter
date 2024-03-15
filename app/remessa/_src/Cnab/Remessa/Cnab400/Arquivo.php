<?php

declare(strict_types=1);

namespace Cnab\Remessa\Cnab400;

use Cnab\Banco;
use Cnab\Exception;
use Cnab\Remessa\IArquivo;
use DateTime;
use DateTimeInterface;

class Arquivo implements IArquivo
{
    public DateTimeInterface $data_geracao;
    public DateTimeInterface $data_gravacao;
    public array $detalhes = [];
    private string $data_gravacao_string;
    private string $data_geracao_string;
    public string $banco;
    public string $codigo_banco;
    public array $configuracao = [];
    public string $layout_versao;
    public const QUEBRA_LINHA = "\r\n";

    public function __construct(string $codigo_banco, string $layout_versao = null)
    {
        $this->codigo_banco = $codigo_banco;
        $this->layout_versao = $layout_versao;
        $this->banco = Banco::getBanco($this->codigo_banco);
    }

    public function configure(array $params): void
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
            if (array_key_exists($campo, $params)) {
                if ($campo === 'data_geracao' || $campo === 'data_gravacao') {
                    if (!($params[$campo] instanceof DateTimeInterface)) {
                        throw new Exception('Config "' . $campo . '" need to be instance of DateTimeInterface');
                    }
                }
                $this->configuracao[$campo] = $params[$campo];
            } else {
                throw new Exception('Configuração "' . $campo . '" need to be set');
            }
        }

        $this->data_geracao_string = $this->configuracao['data_geracao']->format('dmy');
        $this->data_gravacao_string = $this->configuracao['data_gravacao']->format('dmY');

        $this->header = new Header($this);

        $this->header->codigo_banco = $this->banco['codigo_do_banco'];
        $this->header->nome_banco = $this->banco['nome_do_banco'];

        if ($this->codigo_banco === Banco::CEF) {
            $this->header->codigo_cedente = $this->configuracao['codigo_cedente'];
        } else {
            $this->header->agencia = $this->configuracao['agencia'];
            $this->header->conta = $this->configuracao['conta'];
            $this->header->conta_dv = $this->configuracao['conta_dac'];
        }

        $this->header->nome_empresa = $this->configuracao['nome_fantasia'];
        $this->header->data_geracao = $this->data_geracao_string;
    }

    public function insertDetalhe(array $boleto, string $tipo = 'remessa'): void
    {
        $dateVencimento = $boleto['data_vencimento'] instanceof DateTimeInterface ? $boleto['data_vencimento'] : new DateTime($boleto['data_vencimento']);
        $dateCadastro = $boleto['data_cadastro'] instanceof DateTimeInterface ? $boleto['data_cadastro'] : new DateTime($boleto['data_cadastro']);

        $detalhe = new Detalhe($this);
        $complementos = [];

        if ($tipo === 'remessa') {
            $detalhe->codigo_ocorrencia =  !empty($boleto['codigo_de_ocorrencia']) ? $boleto['codigo_de_ocorrencia'] : '1';

            $detalhe->codigo_inscricao =   2;
            $detalhe->numero_inscricao =   $this->prepareText($this->configuracao['cnpj'], '.-/');

            if (Banco::CEF === $this->codigo_banco) {
                $detalhe->codigo_cedente = $this->header->codigo_cedente;
                $detalhe->taxa_de_permanencia = $boleto['taxa_de_permanencia'];
