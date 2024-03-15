<?php

namespace Cnab\Tests;

use Cnab\Banco;

class BancoTest extends \PHPUnit\Framework\TestCase
{
    public function testContemOsBancosEsperados()
    {
        $this->assertTrue(Banco::existsBanco(Banco::ITAU));
        $this->assertTrue(Banco::existsBanco(Banco::CEF));
        $this->assertTrue(Banco::existsBanco(Banco::SANTANDER));
        $this->assertTrue(Banco::existsBanco(Banco::BRADESCO));
    }

    /**
     * @dataProvider provideBancoConstants
     */
    public function testBancoConstantIsValid($const)
    {
        $this->assertTrue(defined('Cnab\\Banco:' . $const));
        $this->assertTrue(constant('Cnab\\Banco:' . $const) !== false);
    }

    public function provideBancoConstants()
    {
        return [
            [Banco::ITAU],
            [Banco::CEF],
            [Banco::SANTANDER],
            [Banco::BRADESCO],
        ];
    }
}
