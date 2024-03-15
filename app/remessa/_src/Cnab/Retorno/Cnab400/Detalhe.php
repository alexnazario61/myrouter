<?php

declare(strict_types=1);

namespace Cnab\Retorno\Cnab400;

use Cnab\Format\Linha;
use Cnab\Retorno\IArquivo;
use Cnab\Retorno\IDetalhe;

class Detalhe extends Linha implements IDetalhe
{
    public int $_codigo_banco;

    public function __construct(IArquivo $arquivo)
    {
        $this->_codigo_banco = $arquivo->codigo_banco;
        parent::__construct($arquivo->codigo_banco, $arquivo->layoutVersao);
    }

    public function isBaixa(): bool
    {
        $tipo_baixa = [9, 10, 32, 47, 59, 72];
        return in_array($this->codigo_de_ocorrencia, $tipo_baixa, true);
    }

    public static function isBaixaStatic(int $codigo): bool
    {
        return in_array($codigo, [9, 10, 32, 47, 59, 72], true);

