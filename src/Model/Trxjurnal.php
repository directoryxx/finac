<?php

namespace Directoryxx\Finac\Model;


use Directoryxx\Finac\Model\MemfisModel;
use Illuminate\Database\Eloquent\Model;

class Trxjurnal extends MemfisModel
{
    protected $table = "trxjurnal";

    protected $fillable = [
		'id_branch',
		'approve',
		'voucher_no',
		'transaction_date',
		'ref_no',
		'currency_code',
		'exchange_rate',
		'journal_type',
		'total_transaction',
		'automatic_journal_type',
    ];

}