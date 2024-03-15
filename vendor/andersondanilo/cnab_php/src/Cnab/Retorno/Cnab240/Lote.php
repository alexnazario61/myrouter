<?php

namespace Cnab\Retorno\Cnab240;

/**
 * Class Lote
 * @package Cnab\Retorno\Cnab240
 */
class Lote
{
    /**
     * @var SegmentoHeader
     */
    public $header;

    /**
     * @var SegmentoTrailer
     */
    public $trailer;

    /**
     * @var IArquivo
     */
    private $arquivo;

    /**
     * @var int
     */
    public $codigoBanco;

    /**
     * @var Detalhe[]
     */
    public $detalhes = [];

    /**
     * @var Detalhe|null
     */

