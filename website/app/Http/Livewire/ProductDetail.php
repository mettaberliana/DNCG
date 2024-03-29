<?php

namespace App\Http\Livewire;

use App\Pesanan;
use App\PesananDetail;
use App\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProductDetail extends Component
{
    public $product, $pesananDet, $nama, $jumlah_pesanan, $nomor;

    public function mount($id)
    {
        $productDetail = Product::find($id);
        $pesananDetail = PesananDetail::where('product_id', $productDetail->id)->first();
        if ($productDetail) {
            $this->product = $productDetail;
        }
        if ($pesananDetail) {
            $this->pesananDet = $pesananDetail;
        }
    }

    public function masukkanKeranjang()
    {
        $this->validate([
            'jumlah_pesanan' => 'required'
        ]);
        if ($this->jumlah_pesanan <= $this->product->is_ready) {

            //Validasi Jika Belum Login
            if (!Auth::user()) {
                return redirect()->route('login');
            }

            //Menghitung Total Harga
            if (!empty($this->nama)) {
                $total_harga = $this->jumlah_pesanan * $this->product->harga + $this->product->harga_namaset;
            } else {
                $total_harga = $this->jumlah_pesanan * $this->product->harga;
            }

            //Ngecek Apakah user punya data pesanan utama yg status nya 0
            $pesanan = Pesanan::where('user_id', Auth::user()->id)->where('status', 0)->first();

            //Menyimpan / Update Data Pesanan Utama
            if (empty($pesanan)) {
                Pesanan::create([
                    'user_id' => Auth::user()->id,
                    'total_harga' => $total_harga,
                    'status' => 0,
                    'kode_unik' => 0.1 * $total_harga,
                    'metode_bayar' => '0',
                ]);
                $pesanan = Pesanan::where('user_id', Auth::user()->id)->where('status', 0)->first();
                $pesanan->kode_pemesanan = 'JP-' . $pesanan->id;
                $pesanan->update();
            } else {
                $pesanan->total_harga = $pesanan->total_harga + $total_harga;
                $pesanan->kode_unik = 0.1 * $pesanan->total_harga;
                $pesanan->update();
            }
            //Meyimpanan Pesanan Detail
            if ((!empty($this->pesananDet)) && ($this->product->id == $this->pesananDet->product_id)) {
                $pesananDetail = PesananDetail::where('product_id', $this->product->id)->first();
                $this->pesananDet->jumlah_pesanan = $this->pesananDet->jumlah_pesanan + $this->jumlah_pesanan;
                $this->pesananDet->total_harga = $this->pesananDet->jumlah_pesanan * $this->product->harga;
                $pesananDetail->jumlah_pesanan = $this->pesananDet->jumlah_pesanan;
                $pesananDetail->total_harga = $this->pesananDet->total_harga;
                $pesananDetail->update();
            } else {
                PesananDetail::create([
                    'product_id' => $this->product->id,
                    'pesanan_id' => $pesanan->id,
                    'jumlah_pesanan' => $this->jumlah_pesanan,
                    'namaset' => $this->nama ? true : false,
                    'nama' => $this->nama,
                    'nomor' => $this->nomor,
                    'total_harga' => $total_harga
                ]);
            }
            $this->emit('masukKeranjang');
            

            
            session()->flash('message', 'Sukses Masuk Keranjang');
            return redirect()->route('products');
        } else {
            return back()->with('alert', 'Pesanan Melebihi Stok');
        }

    }

    public function render()
    {
        return view('livewire.product-detail');
    }
}
