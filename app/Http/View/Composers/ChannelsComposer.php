<?php 
namespace App\Http\View\Composers;

use Illuminate\View\View;

class ChannelsComposer{

	public function compose(View $view)
	{
		$view->with('bacs','Handsom man');
	}


}