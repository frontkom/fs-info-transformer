<?php

namespace Frontkom\FsInfoTransformer\Tests;

use Frontkom\FsInfoTransformer\Transformer;
use PHPUnit\Framework\TestCase;

class WebLinksTest extends TestCase
{
    /**
     * Test weblinks.
     *
     * Basically with and without nofollow.
     *
     * @dataProvider weblinksProvider
     */
    public function testWeblinks($input, $expected, $nofollow)
    {
        $transformer = new Transformer();
        $result = $transformer->processWeblinks($input, $nofollow);
        $this->assertEquals($expected, $result);
    }

    public static function weblinksProvider()
    {
        return [
            [
                '<webLink><href>https://www.example.com</href><linkName>gjeldende forskrift og tilhørende retningslinjer.</linkName></webLink>',
                '<a rel="nofollow" href="https://www.example.com">gjeldende forskrift og tilhørende retningslinjer.</a>',
                true
            ],
            [
                '<webLink><href>https://www.example.com</href><linkName>gjeldende forskrift og tilhørende retningslinjer.</linkName></webLink>',
                '<a href="https://www.example.com">gjeldende forskrift og tilhørende retningslinjer.</a>',
                false
            ]
        ];
    }
}