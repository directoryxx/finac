<?php

namespace Directoryxx\Finac\Model;

use Directoryxx\Finac\Model\MemfisModel;
use Illuminate\Database\Eloquent\Model;

class APaymentB extends MemfisModel
{
    protected $table = "a_payment_b";

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
