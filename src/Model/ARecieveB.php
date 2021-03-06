<?php

namespace App;

use Directoryxx\Finac\Model\MemfisModel;
use Illuminate\Database\Eloquent\Model;

class ARecieveB extends MemfisModel
{
    protected $table = "a_recieve_b";

	protected $fillable = [
	    'uuid',
	    'transactionnumber',
	    'code',
	    'name',
	    'debit',
	    'credit',
	    'description',
	];
}
