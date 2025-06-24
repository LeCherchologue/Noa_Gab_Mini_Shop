<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function sendApiResponse($datas, $message = '', $code = 200)
    {
        $response = [
            'success' => true,
            'data'   => $datas,
            'message' => $message,
        ];

        return response()->json($response, $code);
    }

    public function sendApiErrors($errors, $code = 200)
    {
        $response = [
            'success' => false,
            'errors'  => $errors,
        ];

        return response()->json($response, $code);
    }

    public function AsdecodefilterBy($table, $req)
    {
        if (isset($_GET)) {
            if (isset($_GET['search_by_keyword']) && $_GET['search_by_keyword'] !== '') {
                $columns = Str::of($_GET['columns'])->explode(',');
                foreach ($columns as $column) {
                    if (Schema::hasColumn($table, $column)) $req = $req->orwhere($column, 'LIKE', '%' . $_GET['search_by_keyword'] . '%');
                }
                if (isset($_GET['page']) && isset($_GET['rows'])) {
                    return $req->paginate($_GET['rows']);
                } else return $req->get();
            } else if (isset($_GET['filter_by_form']) && $_GET['filter_by_form'] == 1) {

                $req = $this->filterByColumn($table, $req);



                if (isset($_GET['page']) && isset($_GET['rows'])) {
                    return $req->paginate($_GET['rows']);
                }
            }

            $req = $this->filterByColumn($table, $req);

            if (isset($_GET['page']) && isset($_GET['rows'])) {
                return $req->paginate($_GET['rows']);
            }
        }

        return $req->get();
    }

    public function filterByColumn($table, $req)
    {
        foreach ($_GET as $key => $value) {
            if (($value != null) && (Schema::hasColumn($table, $key))) {
                $req = $req->where($key, $value);
            }
        }

        return  $req;
    }
}
