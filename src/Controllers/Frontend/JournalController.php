<?php

namespace Directoryxx\Finac\Controllers\Frontend;

use Illuminate\Http\Request;
use Directoryxx\Finac\Model\TrxJournal as Journal;
use Directoryxx\Finac\Model\TypeJurnal;
use Directoryxx\Finac\Model\JurnalA;
use Directoryxx\Finac\Request\JournalUpdate;
use Directoryxx\Finac\Request\JournalStore;
use Directoryxx\Finac\Request\JournalAstore;
use App\Http\Controllers\Controller;
use App\Models\Currency;

class JournalController extends Controller
{
    public function index()
    {
        return redirect()->route('journal.create');
    }

	public function getType(Request $request)
	{
		return response()->json(TypeJurnal::all());
	}

	public function getCurrency(Request $request)
	{
		return response()->json(Currency::all());
	}
	
    public function create()
    {
        return view('journalview::index');        
    }

	public function generateCode()
	{
		$journal = Journal::orderBy('id', 'desc');

		if (!$journal->count()) {

			if ($journal->withTrashed()->count()) {
				$order = $journal->withTrashed()->count() + 1;
			}else{
				$order = 1;
			}

		}else{
			$order = $journal->withTrashed()->count() + 1;
		}

		$number = str_pad($order, 5, '0', STR_PAD_LEFT);

		$code = "JADJ-".date('Y/m')."/".$number;
		
		return $code;
	}

	public function getTypeJson()
	{
		$journalType = TypeJurnal::all();

		$type = [];

		for ($i = 0; $i < count($journalType); $i++) {
			$x = $journalType[$i];
			$type[$i+1] = $x->name;
		}

        return json_encode($type, JSON_PRETTY_PRINT);
	}

	public function journalaStore(Request $request)
	{
		JournalA::create($request->all());
	}

    public function store(JournalStore $request)
    {
		$request->request->add([
			'voucher_no' => $this->generateCode()
		]);

        $journal = Journal::create($request->all());
        return response()->json($journal);
    }

    public function edit(Request $request)
    {
		$data['journal']= Journal::where('uuid', $request->journal)->with([
			'type_jurnal',
			'currency',
		])->first();

		$data['journal_type'] = TypeJurnal::all();
		$data['currency'] = Currency::selectRaw(
			'code, CONCAT(name, " (", symbol ,")") as full_name'
		)->whereIn('code',['idr','usd'])
		->get();

        return view('journalview::edit', $data);
    }

    public function update(JournalUpdate $request, Journal $journal)
    {

        $journal->update($request->all());

        return response()->json($journal);
    }

    public function destroy(Journal $journal)
    {
        $journal->delete();

        return response()->json($journal);
    }

    public function api()
    {
        $journaldata = Journal::all();

        return json_encode($journaldata);
    }

    public function apidetail(Journal $journal)
    {
        return response()->json($journal);
    }

    public function datatables()
    {
		$data = $alldata = json_decode(Journal::with([
			'type_jurnal',
			'currency',
		])->get());

		$datatable = array_merge([
			'pagination' => [], 'sort' => [], 'query' => []
		], $_REQUEST);

		$filter = isset($datatable['query']['generalSearch']) && 
			is_string($datatable['query']['generalSearch']) ? 
			$datatable['query']['generalSearch'] : '';

        if (!empty($filter)) {
            $data = array_filter($data, function ($a) use ($filter) {
                return (bool) preg_grep("/$filter/i", (array) $a);
            });

            unset($datatable['query']['generalSearch']);
        }

		$query = isset($datatable['query']) && 
			is_array($datatable['query']) ? $datatable['query'] : null;

        if (is_array($query)) {
            $query = array_filter($query);

            foreach ($query as $key => $val) {
                $data = $this->list_filter($data, [$key => $val]);
            }
        }

		$sort  = !empty($datatable['sort']['sort']) ? 
			$datatable['sort']['sort'] : 'asc';
		$field = !empty($datatable['sort']['field']) ? 
			$datatable['sort']['field'] : 'RecordID';

        $meta    = [];
		$page    = !empty($datatable['pagination']['page']) ? 
			(int) $datatable['pagination']['page'] : 1;
		$perpage = !empty($datatable['pagination']['perpage']) ? 
			(int) $datatable['pagination']['perpage'] : -1;

        $pages = 1;
        $total = count($data);

        usort($data, function ($a, $b) use ($sort, $field) {
            if (!isset($a->$field) || !isset($b->$field)) {
                return false;
            }

            if ($sort === 'asc') {
                return $a->$field > $b->$field ? true : false;
            }

            return $a->$field < $b->$field ? true : false;
        });

        if ($perpage > 0) {
            $pages  = ceil($total / $perpage);
            $page   = max($page, 1);
            $page   = min($page, $pages);
            $offset = ($page - 1) * $perpage;

            if ($offset < 0) {
                $offset = 0;
            }

            $data = array_slice($data, $offset, $perpage, true);
        }

        $meta = [
            'page'    => $page,
            'pages'   => $pages,
            'perpage' => $perpage,
            'total'   => $total,
        ];

		if (
			isset($datatable['requestIds']) && 
			filter_var($datatable['requestIds'], FILTER_VALIDATE_BOOLEAN)) 
		{
            $meta['rowIds'] = array_map(function ($row) {
                return $row->RecordID;
            }, $alldata);
        }

        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');

        $result = [
            'meta' => $meta + [
                'sort'  => $sort,
                'field' => $field,
            ],
            'data' => $data,
        ];

        echo json_encode($result, JSON_PRETTY_PRINT);
    }
}
