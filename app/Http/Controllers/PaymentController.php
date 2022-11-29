<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Payment::all();

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
            "id_pesanan"=>"Masukan Id Pesanan",
            "id_user"=>"Masukan Id User",
            "payment_date" => "Masukan Tanggal Pembayaran",
            "Harga" => "Masukan Harga Rental Mobil",
        ];
        $validasi = Validator::make($request->all(), [
            "id_pesanan" => "required",
            "id_user" => "required",
            "payment_date" => "required",
            "Harga" => "required",
        ], $message);
        if ($validasi->fails()) {
            return $validasi->errors();
        }
        $data = Payment::create($validasi->validate());
        $data->save();

        return response()->json([
            "message" => "Data success",
            "data" => $data
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Payment::find($id);
        if ($data) {
            return $data;
        } else {
            return ["message" => "Data tidak ditemukan"];
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Payment::find($id);
        if ($data) {
            $data->delete();
            return ["message" => "Delete Berhasil"];
        } else {
            return ["message" => "Delete Tidak Ada"];
        }
    }
}
