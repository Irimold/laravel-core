<?php

namespace Irimold\LaravelCore\Helpers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;

class Pagination 
{
    protected static $page     = 1;
    protected static $limit    = 24;
    protected static $totalPage= 1;

    public static function process(Builder|Relation $query, Request $request)
    {
        if($request->filled('page') && $request->filled('limit')) {
            static::$page   = $request->page;
            static::$limit  = $request->limit;
            
            $entries = (clone $query)->count();
            static::$totalPage = ceil($entries / static::$limit);
        }

        $index  = static::$limit * (static::$page - 1);

        $query->skip($index)->take(static::$limit);

        return ['pages' => static::$totalPage, 'query' => $query];
    }
}
