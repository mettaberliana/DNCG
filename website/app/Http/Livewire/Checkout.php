<?php

namespace App\Http\Livewire;

use App\City;
use App\District;
use App\Pesanan;
use App\PesananDetail;
use App\Product;
use App\Province;
use App\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Checkout extends Component
{
    public $metode_bayar, $pesanan_bayar, $total_harga, $nohp, $alamat, $code, $kelurahan, $selectprovinsi = null, $provinsi = null;
    public $selectcity = null;
    public $selectdistrict = null;

    public function mount()
    {
        if (!Auth::user()) {
            return redirect()->route('login');
        }
        $this->nohp = Auth::user()->nohp;
        $this->alamat = Auth::user()->alamat;
        $this->selectdistrict = Auth::user()->district;
        $this->kelurahan = Auth::user()->kelurahan;
        $this->code = Auth::user()->post_code;


        $pesanan = Pesanan::where('user_id', Auth::user()->id)->where('status', 0)->first();

        $this->pesanan_bayar=$pesanan;
        

        if (!empty($pesanan)) {
            $this->total_harga = $pesanan->total_harga;
        } else {
            return redirect()->route('home');
        }
    }

    public function checkout()
    {
        /*$this->validate([
            'nohp' => 'required',
            'alamat' => 'required'
        ]);*/
        

        //Simpan nohp Alamat ke data user
        $user = User::where('id', Auth::user()->id)->first();
        /*$user->nohp = $this->nohp;
        $user->alamat = $this->alamat;
        if (($this->selectprovinsi != null) && ($this->selectprovinsi) != "0") {
            $user->province = $this->selectprovinsi;
        }
        if (($this->selectcity != null) && ($this->selectcity) != "0") {
            $user->city = $this->selectcity;
        }
        $user->district = $this->selectdistrict;
        $user->kelurahan = $this->kelurahan;
        $user->post_code = $this->code;
        $user->update();*/
        $user->nohp = $this->nohp;
        $user->alamat = $this->alamat;
        if (($this->selectprovinsi != null) && ($this->selectprovinsi) != "0") {
            $user->province = 0;
        }
        if (($this->selectcity != null) && ($this->selectcity) != "0") {
            $user->city = 0;
        }
        $user->district = 0;
        $user->kelurahan = 0;
        $user->post_code = 0;
        $user->update();


        //update data pesanan
        $pesanan = Pesanan::where('user_id', Auth::user()->id)->where('status', 0)->first();
        $pesanan->metode_bayar=$this->metode_bayar;
        $pesanan->status = 1;
        $pesanan->update();

        //mengurangi stok otomatis ketika check out.
        $details = PesananDetail::where('pesanan_id', $pesanan->id)->get();
        foreach ($details as $detail) {
            $stock = $detail->product->is_ready - $detail->jumlah_pesanan;
            $product = Product::find($detail->product->id);
            $product->update([
                'is_ready' => $stock,
            ]);
        }

        $this->emit('masukKeranjang');

        session()->flash('message', "Sukses Checkout");
        $historyDetail = Pesanan::find(Auth::user()->id);
        $pesanan = Pesanan::find(Auth::user()->id);

        if ($historyDetail) {
            $this->product = $historyDetail;
        }

        return redirect()->route('history', compact('historyDetail', 'pesanan'));
    }

    public function render()
    {
        return view('livewire.checkout', [
            'provinces' => Province::all(),
            'cities' => City::all(),
            'districts' => District::all(),
        ]);
    }
}
