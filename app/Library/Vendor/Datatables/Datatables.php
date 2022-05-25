<?php

namespace App\Library\Vendor\Datatables;

class Datatables
{
	public static function of($builder, $source)
	{
		return self::make($builder, $source);
	}

	protected static function make($builder, $source)
	{
		$args = func_get_args();
		return call_user_func_array([new self, 'query'], $args);
	}

	protected function query($builder, $source)
	{
		$request = $this->getRequest();
		$columns = $request->input("tbody");
		$sort = $request->input('sort');
		$offset = $request->input("offset");
		$limit = (int) env('DATATABLES_DEFAULT_LIMIT');
		$loadMore = $request->input('loadMore');
		$columnIDs = explode(",", env('COLUMN_ID'));
		$results = [];

		if($search = $request->input("search")) {
			$builder->where(function($query) use($search, $columns) {
				foreach ($columns as $key => $column) {
					$query->orWhere($column, 'LIKE', '%'.$search.'%');	
				}
			});
		}

		$totalRow = $builder->count();

		if(! empty($sort) ) {
			if(in_array($sort[0], $columnIDs)) {
				$builder->orderByRaw('CAST(substring_index('.$sort[0].',"_",-1) AS UNSIGNED) '.$sort[1]);
			} else {
				$builder->orderBy($sort[0], $sort[1]);
			}
		}

		if($loadMore) {
			$limit += $loadMore;
		} else {
			if(! is_null($offset) ) {
				$offset = ($offset - 1) * $limit;
				$builder->offset($offset);
			}
		}

		$builder->limit($limit);

		$results["data"] = $source::collection($builder->get());
		$results["totalRow"] = $totalRow;
    	$results["totalPage"] = $totalRow > 0 ? ceil($totalRow / $limit) : 0;

    	return $results;
	}

	protected function getRequest()
	{
		return app('datatables.request');
	}
}