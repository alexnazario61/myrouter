<?php
namespace Cnab\Remessa\Cnab240;

class Detalhe
{
    // The segmento_p object
    public $segmento_p;

    // The segmento_q object
    public $segmento_q;

    // The segmento_r object
    public $segmento_r;

    // The last error message, if any
    public $last_error;

    /**
     * Constructor for the Detalhe class
     * @param \Cnab\Remessa\IArquivo $arquivo The remittance file object
     */
    public function __construct(\Cnab\Remessa\IArquivo $arquivo)
    {
        // Initialize the segmento_p, segmento_q, and segmento_r objects
        $this->segmento_p = new SegmentoP($arquivo);
        $this->segmento_q = new SegmentoQ($arquivo);
        $this->segmento_r = new SegmentoR($arquivo);
    }

    /**
     * Validates all segments in this detalhe
     * @return bool True if all segments are valid, false otherwise
     */
    public function validate()
    {
        // Reset the last error message
        $this->last_error = null;

        // Loop through all segments and validate them
        foreach($this->listSegmento() as $segmento) {
            if(!$segmento->validate())
                $this->last_error = get_class($segmento) . ': ' . $segmento->last_error;
        }

        // Return true if there were no errors, false otherwise
        return is_null($this->last_error);
    }

    /**

