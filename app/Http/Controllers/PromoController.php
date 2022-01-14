<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function index()
    {
        $promo = Promo::get();

        return view('pages.promo.index', ['promos' => $promo]);
    }

    public function store(Request $request)
    {
        $promo = new Promo;
        $promo->promo_name = $request->promo_name;
        $promo->discount_value = $request->discount_value;
        $promo->coupon_code = $request->coupon_code;
        $promo->minimun_order = $request->minimun_order;
        $promo->publish = $request->publish;
        $promo->save();

        return response()->json([
            'status' => "success"
        ]);
    }

    public function edit($id)
    {
        $promo = Promo::find($id);
        $publish = $promo->publish;

        return response()->json([
            'publish' => $publish
        ]);
    }

    public function update(Request $request, $id)
    {
        $promo = Promo::find($id);
        $promo->promo_name = $request->promo_name;
        $promo->discount_value = $request->discount_value;
        $promo->coupon_code = $request->coupon_code;
        $promo->minimun_order = $request->minimun_order;
        $promo->publish = $request->publish;
        $promo->save();

        return response()->json([
            'status' => "success"
        ]);
    }

    public function deleteBtn($id)
    {
        $promo = Promo::find($id);

        return response()->json([
            'id' => $promo->id,
            'promo_name' => $promo->promo_name
        ]);
    }

    public function delete(Request $request)
    {
        $promo = Promo::find($request->id);
        $promo->delete();

        return response()->json([
            'status' => "success"
        ]);
    }
}
