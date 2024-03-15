<?php

declare(strict_types=1);

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;

class RoundTripTest extends TestCase
{
    /**
     * @covers \RoundTrip::roundTrip
     * @small
     */
    public function testRoundTrip(): void
    {
        $this->assertSame(
            ['x' => null],
            $this->roundTrip(null)
        );

        $this->assertSame(
            ['x' => 'y'],
            $this->roundTrip('y')
        );

        $this->assertSame(
            ['x' => '!yeah'],
            $this->roundTrip('!yeah')
        );

        $this->assertSame(
            ['x' => '5'],
            $this->roundTrip('5')
        );

        $this->assertSame(
            ['x' => 'x '],
            $this->roundTrip('x ')
        );

        $this->assertSame(
            ['x' => "'biz'"],
            $this->roundTrip("'biz'")
        );

        $this->assertSame(
            ['x' => "\n"],
            $this->roundTrip("\n")
        );

        $this->assertSame(
            ['x' => ['#color' => '#fff']],
            $this->roundTrip(['#color' => '#fff'])
        );

        $this->assertSame(
            ['x' => "aaaaaaaaaaaaaaaaaaaaaaaaaaaa  bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb"],
            $this->roundTrip("aaaaaaaaaaaaaaaaaaaaaaaaaaaa  bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb")
        );
    }

    /**
     * @testdox Checks if an array is correctly round-tripped
     * @dataProvider roundTripDataProvider
     */
    public function testRoundTripArray(array $input, array $expected): void
    {
        $actual = $this->roundTrip($input);

        Assert::assertEquals($
