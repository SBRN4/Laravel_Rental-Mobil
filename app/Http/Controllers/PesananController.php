<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Validator;

class PesananController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Pesanan::all();

        return response()->json([
            "message" => "load data success",
            "data" => $data
        ], 200);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = [
            "id_mobil"=>"Masukan Id Mobil",
            "id_user"=>"Masukan Id User",
            "Merek_mobil" => "Masukan Nama Merek Mobil",
            "Warna_mobil" => "Masukan Warna Mobil",
            "Plat_nomor" => "Masukan Plat Nomor Mobil",
            "Harga" => "Masukan Harga Rental Mobil",
        ];
        $validasi = Validator::make($request->all(), [
            "id_mobil" => "required",
            "id_user" => "required",
            "Merek_mobil" => "required",
            "Warna_mobil" => "required",
            "Plat_nomor" => "required",
            "Harga" => "required",
        ], $message);
        if ($validasi->fails()) {
            return $validasi->errors();
        }
        $data = Pesanan::create($validasi->validate());
        $data->save();

        return response()->json([
            "message" => "Data success",
            "data" => $data
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Pesanan::find($id);
        if ($data) {
            return $data;
        } else {
            return ["message" => "Data tidak ditemukan"];
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = Pesanan::findOrFail($id);
        $data->update($request->all());
        $data->save();

        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Pesanan::find($id);
        if ($data) {
            $data->delete();
            return ["message" => "Delete Berhasil"];
        } else {
            return ["message" => "Delete Tidak Ada"];
        }
    }
}
