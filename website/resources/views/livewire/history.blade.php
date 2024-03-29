<style>
    .animation {
        justify-content: center;
    }

    .table {
        background-color: transparent;
        color: black;
    }
</style>
<div class="container">
    <div class="card shadow headnew">
        <div class="card-body">
            <div class="row">
                <div class="col-md-9">
                    <h3><strong style="color:black">History</strong><strong style="color:#2146C7"> Pesanan</strong></h3>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page" style="color:black">History</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
            @endif
        </div>
    </div>

    <div class="row mt-4 search">
        <div class="col-md-8">
            <div class="col-md-4">
                <select wire:model="filter" name="" id="" class="form-control form-control">
                    <option value="0">Filter Status</option>
                    <option value="1">Belum Lunas</option>
                    <option value="2">Lunas/Pengiriman</option>
                    <option value="3">Selesai</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="input-group mb-3">
                <input wire:model="search" type="text" class="form-control" placeholder="Kode Pesanan . . ." aria-label="Search" aria-describedby="basic-addon1">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fas fa-search"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-body">
                    @if (!empty($pesanans))
                    <div class="row animation">
                        <h3><strong>Thank You For Your Order</strong> </h3>
                    </div>
                    <div class="row animation">
                        <lottie-player src="https://assets5.lottiefiles.com/packages/lf20_uk52xbuq.json" background="transparent" speed="1" style="width: 500px; height: 500px;" loop controls autoplay></lottie-player>
                    </div>
                    @else
                    <h4><strong>Anda Belum Melakukan Pesanan</strong></h4>
                    @endif
                    <div class="row">
                        <div class="col-6">
                            @forelse ($pesanans as $pesanan)
                            <?php $users = \App\User::where('id', $pesanan->user_id)->get(); ?>
                            @empty
                            @endforelse
                            <h4><strong>Detail Pesanan</strong></h4>
                            <?php $no = 1 ?>
                            @forelse ($pesanans as $pesanan)
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <hr>
                                    <tbody>
                                        <tr>
                                            <strong>Pesanan Ke - {{$no++}} (Status)</strong>
                                        </tr>
                                        @if (!empty($pesanan))
                                        <tr>
                                            @foreach ($users as $user)
                                            <td>Atas Nama</td>
                                            <td>:</td>
                                            <td>{{$user->name}}</td>
                                            @endforeach
                                        </tr>
                                        @endif
                                        <tr>
                                            <td>Kode Pesanan</td>
                                            <td>:</td>
                                            <td>{{ $pesanan->kode_pemesanan }}</td>
                                        </tr>
                                        <tr>
                                            <td>Pesanan</td>
                                            <td>:</td>
                                        </tr>
                                        <?php $pesanan_details = \App\PesananDetail::where('pesanan_id', $pesanan->id)->get(); ?>
                                        @foreach ($pesanan_details as $pesanan_detail)
                                        <tr>
                                            <td>
                                            </td>
                                            <td>
                                                <img src="{{ url('assets/product') }}/{{ $pesanan_detail->product->gambar }}" class="img-fluid" width="50">
                                            </td>
                                            <td>
                                                <p>{{ $pesanan_detail->product->nama }} (x{{ $pesanan_detail->jumlah_pesanan }})</p>
                                                <p> Rp. {{number_format($pesanan_detail->product->harga) }}</p>
                                            </td>
                                            <br>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td>Metode Pembayaran</td>
                                            <td>:</td>
                                            <td>{{$pesanan->metode_bayar}}</td>
                                        </tr>
                                        <tr>
                                            <td>Total Harga</td>
                                            <td>:</td>
                                            <td>Rp. {{ number_format($pesanan->total_harga) }}</td>
                                        </tr>
                                        <!-- <tr>-->

                                        <tr>
                                            <td>Status</td>
                                            <td>:</td>
                                            <td>
                                                @if($pesanan->status == 1)
                                                <button style="background-color:yellow">Pesanan Diproses</button>
                                                @elseif($pesanan->status == 2)
                                                <button style="background-color:#00c04b;color:white">Pesanan Selesai</button>
                                                @else
                                                <button style="background-color:#2146C7;color:white">Pesanan Selesai</button>
                                                @endif
                                                
                                            </td>
                                        </tr>
                                        <!--<td><strong>Rp. {{ number_format($pesanan->total_harga) }}</strong></td>
                                        <td>
                                            @if($pesanan->status !=0)
                                            @if($pesanan->gambar)
                                            <form action="{{route('pembayaran', $pesanan->id)}}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <div class="row">
                                                    <div class="col">
                                                        <input type="file" name="bayar" id="bayar" class="form-control">
                                                    </div>
                                                    <button type="submit" class="btn btn-warning">
                                                        {{ __('Edit') }}
                                                    </button>
                                                </div>
                                            </form>
                                            <a href="{{url('assets/bukti', $pesanan->gambar)}}" style="color:white;">Lihat</a>
                                            @else
                                            <form action="{{route('pembayaran', $pesanan->id)}}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <div class="row">
                                                    <div class="col">
                                                        <input type="file" name="bayar" id="bayar" class="form-control">
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">
                                                        {{ __('Save') }}
                                                    </button>
                                                </div>
                                            </form>
                                            @endif
                                            @endif
                                        </td>
                                        <td>
                                            @if($pesanan->status == 2)
                                            <a wire:model="history" wire:click="update({{$pesanan->id}})" class="btn btn-success">Diterima</a>
                                            @elseif($pesanan->status==3)
                                            Pesanan Diterima
                                            @else
                                            Proses Pengecekan
                                            @endif
                                            @if($pesanan->gambar==null)
                                            <a wire:model="batal" wire:click="batal({{$pesanan->id}})" onclick="return confirm('Batalkan Pesanan ?')" class="btn btn-danger">Batalkan</a>
                                            @endif
                                        </td>
                                    </tr> -->
                                        @empty
                                        <tr>
                                            <td colspan="7">Data Kosong</td>
                                        </tr>
                                        @endforelse
                                    </tbody>

                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="row mt-4">
        <div class="col">
            <div class="table-responsive">
                <table class="table table-bordered text-center">
                    <thead class="table-active">
                        <tr>
                            <td>No.</td>
                            <td>Tanggal Pesan</td>
                            <td>Kode Pemesanan</td>
                            <td>Pesanan</td>
                            <td>Status</td>
                            <td><strong>Total Harga</strong></td>
                            <td>Bukti Pembayaran</td>
                            <td>Konfirmasi</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1 ?>
                        @forelse ($pesanans as $pesanan)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $pesanan->created_at }}</td>
                            <td>
                                {{ $pesanan->kode_pemesanan }}

                            </td>
                            <td>
                                <?php $pesanan_details = \App\PesananDetail::where('pesanan_id', $pesanan->id)->get(); ?>
                                @foreach ($pesanan_details as $pesanan_detail)
                                <div class="col">
                                    <img src="{{ url('assets/product') }}/{{ $pesanan_detail->product->gambar }}" class="img-fluid" width="50">
                                </div>
                                <div class="col">
                                    {{ $pesanan_detail->product->nama }} (x{{ $pesanan_detail->jumlah_pesanan }})
                                </div>
                                <br>
                                @endforeach
                            </td>
                            <td>
                                @if($pesanan->status == 1)
                                Belum Lunas
                                @elseif($pesanan->status == 2)
                                Lunas (Proses Pengiriman)
                                @else
                                Pesanan Diterima
                                @endif
                                <br>
                                Resi : {{$pesanan->resi}}
                            </td>
                            <td><strong>Rp. {{ number_format($pesanan->total_harga) }}</strong></td>
                            <td>
                                @if($pesanan->status !=0)
                                @if($pesanan->gambar)
                                <form action="{{route('pembayaran', $pesanan->id)}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col">
                                            <input type="file" name="bayar" id="bayar" class="form-control">
                                        </div>
                                        <button type="submit" class="btn btn-warning">
                                            {{ __('Edit') }}
                                        </button>
                                    </div>
                                </form>
                                <a href="{{url('assets/bukti', $pesanan->gambar)}}" style="color:white;">Lihat</a>
                                @else
                                <form action="{{route('pembayaran', $pesanan->id)}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col">
                                            <input type="file" name="bayar" id="bayar" class="form-control">
                                        </div>
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Save') }}
                                        </button>
                                    </div>
                                </form>
                                @endif
                                @endif
                            </td>
                            <td>
                                @if($pesanan->status == 2)
                                <a wire:model="history" wire:click="update({{$pesanan->id}})" class="btn btn-success">Diterima</a>
                                @elseif($pesanan->status==3)
                                Pesanan Diterima
                                @else
                                Proses Pengecekan
                                @endif
                                @if($pesanan->gambar==null)
                                <a wire:model="batal" wire:click="batal({{$pesanan->id}})" onclick="return confirm('Batalkan Pesanan ?')" class="btn btn-danger">Batalkan</a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7">Data Kosong</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div> -->

    <!-- <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-body">
                    <p>Untuk pembayaran silahkan dapat transfer di rekening dibawah ini : </p>
                    <div class="media">
                        <img class="mr-3" src="{{ url('assets/bri.png') }}" alt="Bank BRI" width="60">
                        <div class="media-body">
                            <h5 class="mt-0">BANK BRI</h5>
                            No. Rekening 012345-678-910 atas nama <strong>Madanil</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
</div>