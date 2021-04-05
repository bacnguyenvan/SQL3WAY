<?php 

namespace App\Http\Services;
class Service {

	protected $repositoryName;
	
	public function repository(){
		$repositoryName = $this->repositoryName;
		$class = "App\\Http\\Repositories\\$repositoryName"."Repository";

		return $instanceRepository = new $class;
	}
}