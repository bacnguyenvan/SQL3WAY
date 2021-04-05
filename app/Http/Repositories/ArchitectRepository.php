<?php 

namespace App\Http\Repositories;

class ArchitectRepository extends Repository{

	protected $modelName = 'Architect';

	public function search($conditions = [], $options = [])
	{
		$query = $this->model;

		$query = $this->searchOptions($query, $options);

		return $query;
	}

}