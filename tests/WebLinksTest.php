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
    public function testWeblinks($input, $expected, $nofollow = true)
    {
        $transformer = new Transformer();
        $result = $transformer->processWeblinks($input, $nofollow);
        $this->assertEquals($expected, $result);
    }

    public static function weblinksProvider()
    {
        return [
            [
                // @phpcs:ignore
                '<webLink><href>https://www.example.com</href><linkName>gjeldende forskrift og tilhørende retningslinjer.</linkName></webLink>',
                // @phpcs:ignore
                '<a rel="nofollow" href="https://www.example.com">gjeldende forskrift og tilhørende retningslinjer.</a>',
            ],
            [
                // @phpcs:ignore
                '<webLink><href>https://www.example.com</href><linkName>gjeldende forskrift og tilhørende retningslinjer.</linkName></webLink>',
                '<a href="https://www.example.com">gjeldende forskrift og tilhørende retningslinjer.</a>',
                false,
            ],
            [
                // Now one where we have a line break in the middle of a tag.
                // @phpcs:ignore
                '<webLink><href>https://www.example.com</href><linkName>gjeldende forskrift og tilhørende 
retningslinjer.</linkName></webLink>',
                // @phpcs:ignore
                '<a rel="nofollow" href="https://www.example.com">gjeldende forskrift og tilhørende 
retningslinjer.</a>',
            ],
        ];
    }
}
