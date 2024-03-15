<?php
// This is a test class for the Cnab\Remessa\Cnab240\Arquivo class
namespace Cnab\Tests\Remessa\Cnab240;

// Importing PHPUnit's TestCase class for creating test methods
use PHPUnit\Framework\TestCase;

// Our class, ArquivoTest, extends PHPUnit's TestCase class
class ArquivoTest extends TestCase 
{
    // This test method checks if a Cnab240 SIGCB remessa file can be created for Caixa bank
    public function testArquivoCaixaCnab240SigcbPodeSerCriado()
    {
        // Define the bank code
        $codigoBanco = \Cnab\Banco::CEF;

        // Create a CnabFactory instance
        $cnabFactory = new \Cnab\Factory;

        // Create a remessa file using the factory
        $arquivo = $cnabFactory->createRemessa($codigoBanco, 'cnab240', 'sigcb');

        // Configure the remessa file with required data
        $arquivo->configure(array(
            'codigo_banco' => '104',
            'lote_servico' => '0000',
            'servico' => '01',
            'forma_grava' => '0',
            'versao_layout' => '001',
            'tipo_inscricao' => '1',
            'numero_inscricao' => '12345678901',
            'convenio' => '123456',
            'agencia' => '1234',
            'agencia_dv' => '5',
            'conta' => '123456',
            'conta_dv' => '7',
            'nome' => 'Test Company',
            'data_geracao' => '2022-01-01',
            'hora_geracao' => '10:00:00',
        ));

        // Add a detalhe record to the remessa file
        $arquivo->insertDetalhe(array(
            'codigo_banco' => '104',
            'lote_servico' => '0001',
            'registro_sequencial' => '1',
            'nome_empresa' => 'Test Company',
            'numero_inscricao' => '12345678901',
            'convenio' => '123456',
            'agencia' => '1234',
            'agencia_dv' => '5',
            'conta' => '123456',
            'conta_dv' => '7',
            'nome' => 'Test Client',
            'data_vencimento' => '2022-02-01',
            'valor' => '100.50',
            'nosso_numero' => '123',
            'numero_documento' => '456',
            'sacado_nome' => 'Test Client',
            'sacado_tipo_inscricao' => '1',
            'sacado_numero_inscricao' => '98765432100',
            'sacado_endereco' => 'Test Street 123',
            'sacado_cep' => '12345-678',
            'sacado_cidade_uf' => 'Test City/State',
            'sacado_agencia' => '5432',
            'sacado_agencia_dv' => '1',
            'sacado_conta' => '654321',
            'sacado_conta_dv' => '2',
            'sacado_carteira' => '12',
            'sacado_carteira_dv' => '3',
            'sacado_cedente_nome' => 'Test Company',
            'sacado_cedente_tipo_inscricao' => '1',
            'sacado_cedente_numero_inscricao' => '12345678901',
            'sacado_cedente_endereco' => 'Test Street 123',
            'sacado_cedente_cep' => '12345-678',
            'sacado_cedente_cidade_uf' => 'Test City/State',
        ));

        // Generate the remessa file's textual representation
        $texto = $arquivo->getText();

        // Split the text into lines
        $lines = explode("\r\n", trim($texto, "\r\n"));

        // Check if the number of lines is equal to 7
        $this->assertEquals(7, count($lines));

        // Commented lines below are the expected content of each line in the remessa file

        // HeaderArquivo line
        $headerArquivoText = $lines[0];
        $asserts['headerArquivo'] = array(
            '1:3' => '104', // codigo_banco 
            '4:7' => '0000', // lote_servico 
            '8:8' => '0', // tipo_registro 
            '9:13' => '00001', // numero_registro 
            '14:17' => '0', // tipo_inscricao 
            '18:32' => '12345678901', // numero_inscricao 
            '33:37' => '
