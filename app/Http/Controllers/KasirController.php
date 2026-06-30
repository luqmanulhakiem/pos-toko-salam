<?php

namespace App\Http\Controllers;

use App\Http\Requests\KasirStoreRequest;
use App\Models\Cart;
use App\Models\Nota;
use App\Models\Penjualan;
use App\Models\Produk;
use App\Models\StokFlow;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class KasirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $noNota = IdGenerator::generate([
            'table' => 'notas',
            'field' => 'no_nota',
            'length' => 17,
            'prefix' => 'INV-'.date('ymdHis'),
        ]);

        return view('src.pages.kasir.index', compact('noNota'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KasirStoreRequest $request)
    {
        $data = $request->validated();
        $cart = Cart::get();
        if ($cart->isEmpty()) {
            toastr()->error('Keranjang Belum Ada Barang');

            return redirect()->back()->withInput();
        }
        if ($data['payment'] < $data['grand_total']) {
            toastr()->error('Pembayaran Belum Lunas');

            return redirect()->back()->withInput();
        }

        DB::beginTransaction();
        try {
            foreach ($cart as $value) {
                Nota::create([
                    'no_nota' => $data['no_nota'],
                    'produk_id' => $value->produk_id,
                    'quantity' => $value->quantity,
                ]);
                $product = Produk::find($value->produk_id);
                $product->update(['stock' => $product->stock + $value->quantity]);
                StokFlow::urusStok(
                    $value->produk_id,
                    $value->quantity,
                    'keluar',
                    'Penjualan dengan No. Nota : '.$data['no_nota'],
                );
                $value->delete();
            }
            $penjualan = Penjualan::create([
                'user_id' => Auth::user()->id,
                'nota_id' => $data['no_nota'],
                'grand_total' => $data['grand_total'],
                'payment' => $data['payment'],
                'charge' => $data['charge'],
            ]);
            DB::commit();
            toastr()->success('Berhasil Melakukan Penjualan');

            return redirect()->back()->with('print_penjualan_id', $penjualan->id);
        } catch (\Throwable $e) {
            DB::rollBack();
            toastr()->error($e->getMessage());

            return redirect()->back()->withInput()->withErrors(['message' => $e->getMessage()]);
        }
    }

    /**
     * Get Midtrans Snap Token
     */
    public function getSnapToken(Request $request)
    {
        $cart = Cart::with('produk')->get();
        if ($cart->isEmpty()) {
            return response()->json(['status' => false, 'message' => 'Keranjang kosong']);
        }

        $grossAmount = 0;
        $itemDetails = [];
        foreach ($cart as $item) {
            $price = $item->produk->price_sell;
            $subtotal = $price * $item->quantity;
            $grossAmount += $subtotal;
            $itemDetails[] = [
                'id' => $item->produk_id,
                'price' => $price,
                'quantity' => $item->quantity,
                'name' => mb_substr($item->produk->name, 0, 50),
            ];
        }

        $orderId = $request->input('order_id');
        if (! $orderId) {
            return response()->json(['status' => false, 'message' => 'Order ID is required']);
        }

        $payload = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $grossAmount,
            ],
            'item_details' => $itemDetails,
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ],
            'enabled_payments' => [
                'bca_va',
                'bni_va',
                'bri_va',
            ],
        ];

        $serverKey = env('MIDTRANS_SERVER_KEY');
        $isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        $baseUrl = $isProduction ? 'https://app.midtrans.com/snap/v1/transactions' : 'https://app.sandbox.midtrans.com/snap/v1/transactions';

        try {
            $response = Http::withBasicAuth($serverKey, '')
                ->post($baseUrl, $payload);

            if ($response->successful()) {
                return response()->json([
                    'status' => true,
                    'token' => $response->json('token'),
                    'order_id' => $orderId,
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'Failed to get snap token from Midtrans: '.$response->body(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Exception: '.$e->getMessage(),
            ]);
        }
    }
}
