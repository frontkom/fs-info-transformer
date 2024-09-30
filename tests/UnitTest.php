<?php

namespace Frontkom\FsInfoTransformer\Tests;

use Frontkom\FsInfoTransformer\Transformer;
use PHPUnit\Framework\TestCase;

class UnitTest extends TestCase {

  /**
   * Test all the cases defined in a JSON file with cases.
   *
   * The reason we use a test case file is to make it easier to re-use the same
   * cases in other languages, for example JavaScript.
   *
   * @dataProvider casesProvider
   */
  public function testAllCases($input, $expected) {
    $transformer = new Transformer();
    $actual = $transformer->transform($input);
    $this->assertEquals($expected, $actual);
  }

  public static function casesProvider() {
    $cases = json_decode(file_get_contents(__DIR__ . '/assets/cases.json'), true);
    return array_map(function ($case) {
      return $case;
    }, $cases);
  }

}