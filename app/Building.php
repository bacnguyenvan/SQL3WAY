<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use App\Host;

class Building extends Model
{
    protected $table = 'building';

    public function host()
    {
    	return $this->belongsTo(Host::class,'host_id','id');
    }

    public function contractor()
    {
    	return $this->belongsTo(Contractor::class,'contractor_id','id');
    }
   
}
