<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create($value)
 */
class Currency extends Model
{
    use HasFactory;

    public $fillable = [
        'num_code',
        'char_code',
        'nominal',
        'name',
        'value'
    ];

    /**
     *  Scope for filtering
     * @param $query
     * @param int $id
     * @return mixed
     */
    public function scopeOfId($query, int $id = 0)
    {
        return $query->where('id', $id);
    }

    /**
     *  Scope for filtering
     * @param $query
     * @param int $numCode
     * @return mixed
     */
    public function scopeOfNumCode($query, int $numCode = 0)
    {
        return $query->where('num_code', $numCode);
    }

    /**
     *  Scope for filtering
     * @param $query
     * @param string $dateFrom
     * @return mixed
     */
    public function scopeOfDateFrom($query, string $dateFrom = '')
    {
        return $query->where('created_at', '>=' , $dateFrom);
    }

    /**
     *  Scope for filtering
     * @param $query
     * @param string $dateTo
     * @return mixed
     */
    public function scopeOfDateTo($query, string $dateTo = '')
    {
        return $query->where('created_at', '<=' , $dateTo);
    }


}
