<?php


namespace App\Classes\Parsers;

use Exception;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

/**
 * Class CurrencyParser
 * Simple class for parse DATA
 * @package App\Classes\Parsers
 */
class CurrencyParser
{
    /**
     * @var string
     */
    protected string $url;

    /**
     * @var Response
     */
    protected Response $xmlResponse;

    /**
     * @var array|string[]
     */
    protected array $fields = [
        'num_code',
        'char_code',
        'nominal',
        'name',
        'value'
    ];

    /**
     * CurrencyParser constructor.
     * @param string $url
     */
    public function __construct(string $url = '')
    {
        $this->url = $url;
    }

    /**
     * Get XML for parsing
     * @return String
     * @throws Exception
     */
    protected function getBody(): string
    {
        if (!$this->url) throw new  Exception('Invalid URL!');
        $this->xmlResponse = Http::get($this->url);
        return $this->xmlResponse->body();
    }


    /**
     * Parse XML
     * @return array
     * @throws Exception
     */
    public function parse(): array
    {
        $crawler = new Crawler($this->getBody());
        $result = [];
        foreach ($crawler->filter('ValCurs > Valute') as $valute) {
            $currency = [];
            foreach ($valute->childNodes as $item) {
                $key = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $item->nodeName));
                $currency[$key] = $item->nodeValue;
            }
            $result[] = $this->prepareData($currency);
        }

        return $result;
    }

    /**
     * Format and prepare data
     * @param $data
     * @return array
     * @throws Exception
     */
    public function prepareData($data):array
    {
        $result = [];
        foreach ($this->fields as $field) {
            $value = '';
            if(isset($data[$field])) {
                $value = $data[$field];
                if ($field === 'value') $value = (float)$value;
            }
            $result[$field] = $value;
        }
        return $result;
    }
}
