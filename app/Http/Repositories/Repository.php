<?php
namespace App\Http\Repositories;

class Repository implements InterfaceRepository{

	protected $modelName;
	protected $model;

	public function __construct()
	{
		$class = "App\\$this->modelName";
		return $this->model = new $class;
	}

	public function findAll()
	{
		return $this->model;
	}

	public function searchOptions($query , $options = [])
	{
		if(!empty($options['select'])){
			$query = $query->select($options['select']);
		}

		if(!empty($options['get'])){
			$query = $query->get();
		}else if(!empty($options['paginate'])){
			$query = $query->paginate($options['paginate']);
		}else{
			$query = $query->paginate(Helper::defaultPaginate);
		}

		return $query;
	}
}

