<?php
// This is a test class for the Cnab\Remessa\Cnab240\Arquivo class
namespace Cnab\Tests\Remessa\Cnab240;

// Importing PHPUnit's TestCase class for creating test methods
use PHPUnit_Framework_TestCase;

// Our class, ArquivoTest, extends PHPUnit's TestCase class
class ArquivoTest extends \PHPUnit_Framework_TestCase 
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
            // ... (configuration data)
        ));

        // Add a detalhe record to the remessa file
        $arquivo->insertDetalhe(array(
            // ... (detalhe data)
        ));

        // Generate the remessa file's textual representation
        $texto = $arquivo->getText();

        // Split the text into lines
        $lines = explode("\r\n", trim($texto, "\r\n"));

        // Check if the number of lines is equal to 7
        $this->assertEquals(7, count($lines));

        // Commented lines below are the expected content of each line in the remessa file

        // HeaderArquivo line
        // $headerArquivoText = $lines[0];
        // $asserts['headerArquivo'] = array(
        //     '1:3' => '104', // codigo_banco 
        //     '4:7' => '0000', // lote_servico 
        //     '8:8' => '0', // tipo_registro 
        //     // ... (other fields)
        // );

        // HeaderLote line
        // $headerLoteText = $lines[1];
        // $asserts['headerLote'] = array(
        //     '1:3' => '104', // codigo_banco 
        //     '4:7' => '0001', // lote_servico 
        //     '8:8' => '1', // tipo_registro 
        //     // ... (other fields)
        // );

        // SegmentoP line
        // $segmentoPText = $lines[2];
        // $asserts['segmentoP'] = array(
        //     '1:3' => '104', // codigo_banco 
        //     '4:7' => '0001', // lote_servico 
        //     '8:8' => '3', // tipo_registro 
        //     // ... (other fields)
        // );

        // SegmentoQ line
        // $segmentoQText = $lines[3];
        // $asserts['segmentoQ'] = array(
        //     '1:3' => '104', // codigo_banco 
        //     '4:7' => '0001', // lote_servico 
        //     '8:8' => '3', // tipo_registro 
        //     // ... (other fields)
        // );

        // SegmentoR line
        // $segmentoRText = $lines[4];
        // $asserts['segmentoR'] = array(
        //     '1:3' => '104', // codigo_banco 
        //     '4:7' => '0001', // lote_servico 
        //     '8:8' => '3', // tipo_registro 
        //     // ... (other fields)
        // );

        // TrailerLote line
        // $trailerLoteText = $lines[5];
        // $asserts['trailerLote'] = array(
        //     '1:3' => '104', // codigo_banco 
        //     '4:7' => '0001', // lote_servico 
        //     '8:8' => '5', // tipo_registro 
        //     // ... (other fields)
        // );

        // TrailerArquivo line
        // $trailerArquivoText = $lines[6];
        // $asserts['trailerArquivo'] = array(
        //     '1:3' => '104', // codigo_banco 
        //     '4:7' => '9999', // lote_servico 
        //     '8:8' => '9', // tipo_registro 
        //     // ... (other fields)
        // );

        // Assert each line's content based on the expected values
        foreach($asserts as $tipo => $campos) {
            $vname = "{$tipo}Text";
            foreach($campos as $pos => $value) {
                $aux = explode(':', $pos);
                $start = $aux[0] - 1;
                $end = ($aux[1] - $aux[0]) + 1;
                $this->assertEquals($value, substr($$vname, $start, $end), "[ ] Campo $pos do $tipo");
            }
        }
    }
}
