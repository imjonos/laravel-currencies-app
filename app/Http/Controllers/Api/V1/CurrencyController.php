<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Currency\IndexRequest;
use App\Http\Resources\Api\V1\Currency\CurrencyResource;
use Database\Seeders\CurrenciesTableSeeder;
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
        $id = $request->input('filter.id', 0);
        $dateFrom = $request->input('filter.date_from', '');
        $dateTo = $request->input('filter.date_to', '');
        $currencies = Currency::select(DB::raw('*, avg(value) as avg_value, max(value) as max_value, min(value) as min_value'))
            ->groupBy(DB::raw('Date(created_at)'))
            ->groupBy('num_code');
        if($id) {
            $currencies = $currencies->ofNumCode($id);
        }
        if($dateFrom) {
            $date =  new Carbon($dateFrom);
            $currencies = $currencies->ofDateFrom($date->format('Y-m-d'));
        }
        if($dateTo) {
            $date =  new Carbon($dateTo);
            $currencies = $currencies->ofDateTo($date->format('Y-m-d'));
        }

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
     * @param Currency $currency
     * @return CurrencyResource
     */
    public function show(Currency $currency)
    {
        return new CurrencyResource($currency);
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
