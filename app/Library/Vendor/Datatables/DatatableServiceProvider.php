<?php

namespace App\Library\Vendor\Datatables;

use App\Library\Vendor\Datatables\Utilities\Request;
use Illuminate\Support\ServiceProvider;

class DatatableServiceProvider extends ServiceProvider
{
	public function register()
	{
		$this->app->alias('datatables', Datatables::class);
		$this->app->singleton('datatables', function() {
			return new Datatables;
		});

		$this->app->singleton('datatables.request', function () {
            return new Request;
        });
	}
}