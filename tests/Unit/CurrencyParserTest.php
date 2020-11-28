<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Classes\Parsers\CurrencyParser;
use Exception;

class CurrencyParserTest extends TestCase
{
    /**
     * Simple test.
     *
     * @return void
     * @throws Exception
     */
    public function testParse()
    {
        $parser = new CurrencyParser('http://www.cbr.ru/scripts/XML_daily.asp'); //URL can be get from env or config
        $result = $parser->parse();
        $this->assertTrue(count($result)>0);
    }
}
