<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Pegawai;
use App\Models\Gaji;

class GajiControllers extends Controller
{
    public function index(){
        $year = date('Y');
        $month = date('m');

        if (isset($_GET['filter'])){
            $filter = explode("-", $_GET['filter']);
            $year = $filter[0];
            $month = $filter[1];
        }

        $gaji = Gaji::join('pegawais', 'pegawais.id_pegawais', '=', 'gajis.id_pegawais')
        ->selectRaw(
            "DATE_FORMAT(periods_gaji, '%Y/%m/%d %H:%i') as Waktu,".
            "SUBSTRING_INDEX(UPPER(nama),' ',1) as Nama_Pegawai,".
            "CONCAT('Rp ',FORMAT(total,0)) as Total_Diterima"
        )
        ->whereYear('periods_gaji', '=', $year)
        ->whereMonth('periods_gaji', '=', $month)
        ->paginate(2);

        $url_previous = null;
        $url_next = null;

        if ($gaji->previousPageUrl() != null){
            $url_previous = $gaji->previousPageUrl().'&filter='.$year."-".$month;
        }

        if ($gaji->nextPageUrl() != null){
            $url_next = $gaji->nextPageUrl().'&filter='.$year."-".$month;
        }

        return response()->JSON([
            'status' => 200,
            'meta' => [
                'filter' => $year."-".$month,
                'paginator' => [
                    "item_total" => $gaji->total(),
                    "item_per_pages" => $gaji->count(),
                    "url_previous" => $url_previous,
                    "url_next" => $url_next,
                ]
            ],
            'data' => $gaji->items()
        ], 200);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'id_pegawais' => 'required|exists:pegawais,id_pegawais'
        ]);

        if ($validator->fails()) {
            return response()->JSON([
                'status' => 400,
                'message' => 'Failed validation',
                'data' => $validator->errors()
            ], 400);
        }

        if (
            Gaji::where('id_pegawais', $request->id_pegawais)
            ->whereYear('periods_gaji', '=', date('Y'))
            ->whereMonth('periods_gaji', '=', date('m'))->count() != 0
        ){
            return response()->JSON([
                'status' => 400,
                'message' => 'Data failed created',
                'data' => [
                    'errors' => 'pegawais sudah mendapatkan gaji pada periode '.date('Y').'-'.date('m')
                ]
            ], 400);
        }

        $pegawai = Pegawai::where('id_pegawais', $request->id_pegawais)->first();

        $gaji = Gaji::create([
            'id_pegawais' => $pegawai->id_pegawais,
            'total_gaji' => $pegawai->total,
            'periods_gaji' => date('Y-m-d H:i:s'),
        ]);
        
        return response()->JSON([
            'status' => 201,
            'message' => 'Data success created',
            'data' => $gaji
        ], 201);
    }

    public function batch(){
        $gaji = Gaji::whereYear('periods_gaji', '=', date('Y'))
            ->whereMonth('periods_gaji', '=', date('m'))->get('id_pegawais');

        $pegawai = Pegawai::whereNotIn('id_pegawais', $gaji)->get();

        foreach ($pegawai as $data){
            Gaji::create([
                'id_pegawais' => $data->id_pegawais,
                'total_gaji' => $data->total,
                'periods_gaji' => date('Y-m-d H:i:s'),
            ]);
        }

        return response()->JSON([
            'status' => 201,
            'message' => 'Data success created for batch = '.date('Y').'-'.date('m'). ' with total '.count($pegawai).' data',
            'data' => $pegawai
        ], 201);
    }
}
