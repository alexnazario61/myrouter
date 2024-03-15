<?php
namespace Cnab\Retorno\Cnab400;

class Header extends \Cnab\Format\Linha
{
    // Holds the bank code
    private $_codigo_banco = null;

    /**
     * Constructor for the Header class.
     *
     * @param \Cnab\Retorno\IArquivo $arquivo The return file object.
     */
    public function __construct(\Cnab\Retorno\IArquivo $arquivo)
    {
        $this->_codigo_banco = $arquivo->codigo_banco;
        // Load the YAML configuration for the bank and layout version
        $yamlLoad = new \Cnab\Format\YamlLoad($arquivo->codigo_banco, $arquivo->layoutVersao);
        $yamlLoad->load($this, 'cnab400', 'retorno/header_arquivo');
    }

    /**
     * Get the account number.
     *
     * @return string The account number.
     */
    public function getConta()
    {
        if ($this->existField('conta')) {
            return $this->conta;
        } else if ($this->_codigo_banco == 104) {
            // For bank 104, extract the account number from the codigo_cedente
            $codigo_cedente = sprintf('%016d', $this->codigo_cedente);
            return substr($codigo_cedente, 7, 8);
        }
    }

    /**
     * Get the account DAC.
     *
     * @return string The account DAC.
     */
    public function getContaDac()
    {
        if ($this->existField('dac')) {
            return $this->dac;
        } else if ($this->_codigo_banco == 104) {
            // For bank 104, extract the account DAC from the codigo_cedente
            $codigo_cedente = sprintf('%01
