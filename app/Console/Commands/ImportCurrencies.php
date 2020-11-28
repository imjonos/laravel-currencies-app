<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Classes\Parsers\CurrencyParser;
use App\Models\Currency;
use Exception;


class ImportCurrencies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currencies:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command currencies:import';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Execute the console command.
     *
     * @return int
     * @throws Exception
     */
    public function handle()
    {
        $parser = new CurrencyParser('http://www.cbr.ru/scripts/XML_daily.asp'); //URL can be get from env or config
        $currencies = $parser->parse();
        $total = count($currencies);
        $succeed = 0;
        $failed = 0;

        foreach ($currencies as $value) {
            try {
                if(Currency::create($value)) $succeed++;
            }catch (Exception $exception){
                 //do something with exception
                $this->info("Error: ".$exception->getMessage()."\n");
            }
            $failed = $total - $succeed;
        }

        $this->info("\nTotal currencies found: $total \n\nImport Done!\n-----------\nSucceed: $succeed \nFailed: $failed \n");
        return 0;
    }
}
