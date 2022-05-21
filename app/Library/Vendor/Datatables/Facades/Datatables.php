<?php

namespace App\Library\Vendor\Datatables\Facades;

use Illuminate\Support\Facades\Facade;

class Datatables extends Facade
{
	protected static function getFacadeAccessor()
	{
		return 'datatables';
	}
}
