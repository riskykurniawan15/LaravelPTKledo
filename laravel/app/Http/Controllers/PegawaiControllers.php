<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Pegawai;

class PegawaiControllers extends Controller
{
    public function index(){
        $pegawai = Pegawai::selectRaw(
            "id_pegawais,".
            "SUBSTRING_INDEX(UPPER(nama),' ',1) as Nama_Pegawai,".
            "CONCAT('Rp ',FORMAT(total,0)) as Total_Gaji"
        )->paginate(2);

        return response()->JSON([
            'status' => 200,
            'meta' => [
                'paginator' => [
                    "item_total" => $pegawai->total(),
                    "item_per_pages" => $pegawai->count(),
                    "url_previous" => $pegawai->previousPageUrl(),
                    "url_next" => $pegawai->nextPageUrl(),
                ]
            ],
            'data' => $pegawai->items()
        ], 200);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'nama' => 'required|unique:pegawais,nama|max:10',
            'total' => 'integer|min:4000000|max:10000000'
        ]);

        if ($validator->fails()) {
            return response()->JSON([
                'status' => 400,
                'message' => 'Failed validation',
                'data' => $validator->errors()
            ], 400);
        }

        $pegawai = Pegawai::create([
            'nama' => $request->nama,
            'total' => $request->total
        ]);

        return response()->JSON([
            'status' => 201,
            'message' => 'Data success created',
            'data' => $pegawai
        ], 201);
    }
}
