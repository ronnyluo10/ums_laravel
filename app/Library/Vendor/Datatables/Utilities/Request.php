<?php

namespace App\Library\Vendor\Datatables\Utilities;

class Request
{
	protected $request;

	public function __construct()
	{
		$this->request = app('request');
	}

	public function __call($name, $arguments)
	{
		if(method_exists($this->request, $name)) {
			return call_user_func_array([$this->request, $name], $arguments);
		}
	}

	public function __get($name)
	{
		return (array) $this->request->__get($name);
	}

	public function tbody()
	{
		return (array) $this->request->input("tbody");
	}

	public function search()
	{
		return $this->request->input("search");
	}

	public function relations()
	{
		return (array) $this->request->input('relations');
	}

	public function relationField()
	{
		return (array) $this->request('relationField');
	}

	public function disableSearch()
	{
		return (array) $this->request('disableSearch');
	}

	public function sort()
	{
		return (array) $this->request->input("sort");
	}

	public function offset()
	{
		return (int) $this->request->input("offset");
	}
}