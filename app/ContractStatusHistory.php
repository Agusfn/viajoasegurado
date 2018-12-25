<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContractStatusHistory extends Model
{

    protected $guarded = [];

    
    public function status()
    {
    	return $this->belongsTo("App\ContractStatus");
    }


}
