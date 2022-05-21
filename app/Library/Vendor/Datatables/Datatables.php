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
		$relations = $request->input('relations');
		$sort = $request->input('sort');
		$offset = $request->input("offset");
		$relationField = $request->input('relationField');
		$disableSearch = $request->input('disableSearch');
		$limit = (int) env('DATATABLES_DEFAULT_LIMIT');
		$results = [];

		if($search = $request->input("search")) {
			$builder->where(function($query) use($search, $columns, $relations, $relationField, $disableSearch) {
				foreach ($columns as $key => $column) {
					if($relations && is_array($relations) && array_search($column, $relations) !== false) {
						$query->orWhereHas($column, function($sql) use($search, $relationField, $column) {
							$sql->where($relationField[$column], 'LIKE', '%'.$search.'%');
						});
					}
					else {
						if(empty($disableSearch) || (! empty($disableSearch) && ! in_array($column, $disableSearch))) {
							$query->orWhere($column, 'LIKE', '%'.$search.'%');	
						}
					}
				}
			});
		}

		$totalRow = $builder->count();

		if(! empty($sort) ) {
			$builder->orderBy($sort[0], $sort[1]);
		}

		if(! is_null($offset) ) {
			$offset = ($offset - 1) * $limit;
			$builder->offset($offset);
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