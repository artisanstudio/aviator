<?php

namespace Artisan\Aviator\Metric;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class Value extends Metric
{
    public function count(Request $request, $query)
    {
        if (! $query instanceof Builder) {
            $query = (new $query)->query();
        }

        if (! $request->has('period')) {
            return $query->count();
        }

        return $query->whereBetween('created_at', $this->range($request->period))->count();
    }

    public function sum(Request $request, $query, $field)
    {
        if (! $query instanceof Builder) {
            $query = (new $query)->query();
        }

        if (! $request->has('period')) {
            return $query->get()->sum($field);
        }

        return $query->whereBetween('created_at', $this->range($request->period))->get()->sum($field);
    }
}
