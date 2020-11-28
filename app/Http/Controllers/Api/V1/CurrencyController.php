<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Currency\IndexRequest;
use App\Http\Resources\Api\V1\Currency\CurrencyResource;
use Illuminate\Http\Request;
use App\Http\Resources\Api\V1\Currency\CurrenciesResource;
use App\Models\Currency;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CurrencyController extends Controller
{
    /**
     * @var int
     */
    public int $perPage = 10;

    /**
     * Display a listing of the resource.
     *
     * @param IndexRequest $request
     * @return CurrenciesResource
     */
    public function index(IndexRequest $request)
    {
        $pageSize = $request->input('page.size', $this->perPage);
        $pageNumber = $request->input('page.number', 1);
        $baseId = $request->input('filter.base_currency_id', 0);
        $id = $request->input('filter.id', 0);
        $dateFrom = $request->input('filter.date_from', '');
        $dateTo = $request->input('filter.date_to', '');
        $dateBase = $request->input('filter.date', '');

        $select = '*, avg(value) as avg_value, max(value) as max_value, min(value) as min_value';
        $currencies = Currency::groupBy(DB::raw('Date(created_at)'))->groupBy('num_code');
        if($id) {
            $currencies = $currencies->ofNumCode($id);
        }
        if($baseId) {

            $baseCurrency = Currency::ofNumCode($baseId)->orderBy('id', 'desc');
            if($dateBase) {
                $date =  new Carbon($dateBase);
                $baseCurrency = $baseCurrency->whereDate('created_at', $date->format('Y-m-d'));
            }
            $baseCurrencyObj = $baseCurrency->first();
            if($baseCurrencyObj) {
                $select = $select . ', (' . $baseCurrencyObj->value . '/value) AS value_by_base';
            }
        }
        if($dateFrom) {
            $date =  new Carbon($dateFrom);
            $currencies = $currencies->ofDateFrom($date->format('Y-m-d'));
        }
        if($dateTo) {
            $date =  new Carbon($dateTo);
            $currencies = $currencies->ofDateTo($date->format('Y-m-d'));
        }
        $currencies = $currencies->select(DB::raw($select));

        return new CurrenciesResource($currencies->paginate($pageSize, '*', 'page', $pageNumber));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $currency
     * @return CurrencyResource
     */
    public function show($currency)
    {
        //Get actual rate
        $currencyObject =  Currency::orderBy('id','desc')->where('num_code', $currency)->first();
        return new CurrencyResource($currencyObject);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
