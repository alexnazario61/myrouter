<?php

namespace Cnab\Tests\Remessa\Cnab400;

use Cnab\Retorno\Cnab400\Arquivo;
use Cnab\Banco;
use Cnab\Especie;
use DateTime;

class ArquivoTest extends \PHPUnit_Framework_TestCase
{
    public function testArquivoItauCnab400PodeSerCriado()
    {
        $codigoBanco = Banco::ITAU;
        $arquivo = new \Cnab\Remessa\Cnab400\Arquivo($codigoBanco);

        $arquivo->configure([
            'data_geracao' => new DateTime('2015-02-01'),
            'data_gravacao' => new DateTime('2015-02-01'),
            'nome_fantasia' => 'Nome Fantasia da sua empresa',
            'razao_social' => 'Razão social da sua empresa',
            'cnpj' => '11222333444455',
            'banco' => $codigoBanco,
            'logradouro' => 'Logradouro da Sua empresa',
            'numero' => 'Número do endereço',
            'bairro' => 'Bairro da sua empresa',
            'cidade' => 'Cidade da sua empresa',
            'uf' => 'SP',
            'cep' => '00000111',
            'agencia' => '1234',
            'conta' => '123',
            'conta_dac' => '1'
        ]);

        $detalhe = $arquivo->insertDetalhe([
            'codigo_ocorrencia' => 1,
            'nosso_numero' => '12345679',
            'numero_documento' => '12345678',
            'carteira' => '111',
            'especie' => Especie::ITAU_DIVERSOS,
            'aceite' => 'Z',
            'valor' => 100.39,
            'instrucao1' => '',
            'instrucao2' => '',
            'sacado_razao_social' => 'Nome do cliente',
            'sacado_tipo' => 'cnpj',
            'sacado_cnpj' => '21.222.333.4444-55',
            'sacado_logradouro' => 'Logradouro do cliente',
            'sacado_bairro' => 'Bairro do cliente',
            'sacado_cep' => '00000-111',
            'sacado_cidade' => 'Cidade do cliente',
            'sacado_uf' => 'BA',
            'data_vencimento' => new DateTime('2015-02-03'),
            'data_cadastro' => new DateTime('2015-01-14'),
            'juros_de_um_dia' => 0.10,
            'data_desconto' => new DateTime('2015-02-09'),
            'valor_desconto' => 10.0,
            'prazo' => 10,
            'taxa_de_permanencia' => '0',
            'mensagem' => 'Descrição do boleto',
            'data_multa' => new DateTime('2015-02-07'),
            'valor_multa' => 0.20,
            'tipo_multa' => 'porcentagem'
        ]);

        $texto = $arquivo->getText();
        $lines = explode("\r\n", trim($texto, "\r\n"));

        $this->assertEquals(4, count($lines));

        $this->assertHeader($lines[0]);
        $this->assertDetalhe($lines[1], $detalhe);
        $this->assertCompl1($lines[2]);
        $this->assertTrailer($lines[3]);
    }

    private function assertHeader(string $headerText)
    {
        $asserts = [
            '1:1' => '0',
            '2:2' => '1',
            '3:9' => 'REMESSA',
            '10:11' => '01',
            '12:26' => 'COBRANCA       ',
            '27:30' => '1234',
            '31:32' => '00',
            '33:37' => '00123',
            '38:38' => '1',
            '39:46' => '        ',
            '47:76' => str_pad('Nome Fantasia da sua empresa', 30),
            '77:79' => '341',
            '80:94' => str_pad('BANCO ITAU SA', 15),
            '95:100' => '010215',
            '101:394' => str_pad(' ', 294),
            '395:400' => sprintf('%06d', 1)
        ];

        $this->assertCampos($asserts, $headerText);
    }

    private function assertDetalhe(string $detalheText, $detalhe)
    {
        $asserts = [
            '1:1' => '1',
            '2:3' => '02',
            '4:17' => '11222333444455',
            '18:21' => '1234',
            '22:23' => '
