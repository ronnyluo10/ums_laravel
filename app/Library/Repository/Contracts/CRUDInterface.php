<?php

namespace App\Library\Repository\Contracts;

interface CRUDInterface {
	public function create(object $request): object;
	public function read(object $model = null): object;
	public function update(object $request, object $model): object;
	public function delete(object $model): object;
}