<?php

namespace Directoryxx\Finac\Model;


use Directoryxx\Finac\Model\MemfisModel;
use Illuminate\Database\Eloquent\Model;
use Directoryxx\Finac\Model\Coa;
use App\Models\Vendor;
use Directoryxx\Finac\Model\TrxPaymentA;
use App\User;

class TrxPayment extends MemfisModel
{
    protected $table = "trxpayments";

    protected $fillable = [
		'approve',
		'closed',
		'transaction_number',
		'transaction_date',
		'x_type',
		'id_supplier',
		'currency',
		'exchange_rate',
		'discount_percent',
		'discount_value',
		'ppn_percent',
		'ppn_value',
		'grandtotal_foreign',
		'grandtotal',
		'account_code',
		'description',
    ];

	protected $appends = [
		'exchange_rate_fix',
		'total',
		'created_by',
		'updated_by',
	];

	public function getCreatedByAttribute()
	{
		return User::find($this->audits->first()->user_id);
	}

	public function getUpdatedByAttribute()
	{
		$tmp = $this->audits;

		$result = '';

		if (count($tmp) > 1) {
			$result =  User::find($tmp[count($tmp)-1]->user_id);
		}

		return $result;
	}

	public function getExchangeRateFixAttribute()
	{
		return number_format($this->exchange_rate, 0, 0, '.');
	}

	public function getTotalAttribute()
	{
		$total = $this->grandtotal_foreign;

		if ($this->currency == 'idr') {
			$total = $this->grandtotal;
		}

		return $total;
	}

	static public function generateCode($code = "SITR")
	{
		$data = TrxPayment::orderBy('id', 'desc')
			->where('transaction_number', 'like', $code.'%');

		if (!$data->count()) {

			if ($data->withTrashed()->count()) {
				$order = $data->withTrashed()->count() + 1;
			}else{
				$order = 1;
			}

		}else{
			$order = $data->withTrashed()->count() + 1;
		}

		$number = str_pad($order, 5, '0', STR_PAD_LEFT);

		$code = $code."-".date('Y/m')."/".$number;

		return $code;
	}

	public function vendor()
	{
		return $this->belongsTo(Vendor::class, 'id_supplier');
	}

	public function trxpaymenta()
	{
		return $this->hasMany(TrxPaymentA::class,
			'transaction_number',
			'transaction_number'
		);
	}

	public function coa()
	{
		return $this->belongsTo(Coa::class, 'account_code', 'code');
	}

}
