<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function add_to_cart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty' => 'required'
        ]);

        $prdoduct = Product::findOrFail($request->product_id);

        if($prdoduct->sale_price) {
            $price = $prdoduct->sale_price;
        }else {
            $price = $prdoduct->price;
        }

        $cart = Cart::where('user_id', Auth::id())->whereNull('order_id')->where('product_id', $request->product_id)->first();
        if($cart) {
            $cart->update([
                'qty' => $cart->qty + $request->qty
            ]);
        }else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'price' => $price,
                'qty' => $request->qty
            ]);
        }

        $prdoduct->update(['quantity' => ($prdoduct->quantity - $request->qty)]);

        return redirect()->back()->with('success', 'Product added to cart');
    }

    public function remove_cart($id)
    {
        $cart = Cart::findOrFail($id);

        $prdoduct = $cart->product;

        $prdoduct->update(['quantity' => ($prdoduct->quantity + $cart->qty)]);

        $cart->delete();

        return redirect()->back();
    }

    public function cart()
    {
        $carts = Cart::with('product')->where('user_id', Auth::id())->whereNull('order_id')->get();
        return view('site.cart', compact('carts'));
    }

    public function update_cart(Request $request)
    {
        foreach($request->new_qty as $id => $qty) {
            Cart::find($id)->update(['qty' => $qty]);
        }

        return redirect()->back();
    }

    public function checkout()
    {
        $total = Cart::where('user_id', Auth::id())->whereNull('order_id')->sum(DB::raw('price * qty'));
        $url = "https://eu-test.oppwa.com/v1/checkouts";
        $data = "entityId=8a8294174b7ecb28014b9699220015ca" .
                    "&amount=$total" .
                    "&currency=USD" .
                    "&paymentType=DB";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        'Authorization:Bearer OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg='));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        $responseData = json_decode($responseData, true);
        // dd( $responseData['id'] );
        $checkoutId = $responseData['id'] ;
        return view('site.checkout', compact('total', 'checkoutId'));
    }

    public function checkout_thanks()
    {
        // dd(request()->all());
        $resourcePath = request()->resourcePath;
        $url = "https://eu-test.oppwa.com/$resourcePath";
        $url .= "?entityId=8a8294174b7ecb28014b9699220015ca";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Authorization:Bearer OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg='));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        $responseData = json_decode($responseData, true);
        // dd($responseData);


        // Check the response code
        if ($responseData['result']['code'] == '000.100.110') {

            $total = Cart::where('user_id', Auth::id())->whereNull('order_id')->sum(DB::raw('price * qty'));

            $order = Order::create([
                'user_id' => Auth::id(),
                'total' => $total
            ]);

            Payment::create([
                'user_id' => Auth::id(),
                'order_id' => $order->id,
                'total' => $total,
                'transaction_id' => $responseData['id']
            ]);

            Cart::where('user_id', Auth::id())->whereNull('order_id')->update(['order_id' => $order->id]);

            return view('site.checkout_success');


        }else {
            return view('site.checkout_fail');
        }
    }
}
