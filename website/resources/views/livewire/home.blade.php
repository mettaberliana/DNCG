<div class="jumbotron jumbotron-fluid" style="background-image :url('assets/Banner/griobanner.jpg')">
   <div class="container">
      <h1 class="display-4"> <strong style="color:#2146C7;"></strong> <strong style="color:#ccb952;"></strong> <br></h1>
      <div class="row text-center mb-5 ">
         <div class="col">
            <a href="{{ route('products') }}" class="btn float-center text shopbtn">
               <i class="fas fa-search"></i>
               Order Now
            </a>
         </div>
      </div>
   </div>
</div>

<div class="content">
   <div class="container">
      {{-- BANNER --}}
      <div id="carouselExampleControls" class="carousel slide shadow;" data-ride="carousel">
         <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            
         </ol>
         <div class="carousel-inner ">
            
            <div class="carousel-item active">
               <img src="{{ url('assets/Banner/Banner2.jpg') }}" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
               <img src="{{ url('assets/Banner/Banner3.jpg') }}" class="d-block w-100" alt="...">
            </div>
         </div>
         <a class="carousel-control-prev" type="button" data-target="#carouselExampleControls" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
         </a>
         <a class="carousel-control-next" type="button" data-target="#carouselExampleControls" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
         </a>
      </div>


   </div>


   <section class="products mt-4">
      <div class="container">
         <div class="card shadow headnew">
            <div class="card-body">
               <center>
                  <h3><strong>Best </strong><strong style="color:#2146C7">Seller</strong></h3>
               </center>
            </div>
         </div>
         <div class="row mt-4">
            @foreach($products as $product)
            <div class="col-md-3 ">
               <div class="card shadow">
                  <div class="card-body text-center cardhomenew shadow" style="border-radius: 0.5rem">
                     <img src="{{ url('assets/product') }}/{{ $product->gambar }}" class="img-fluid product">
                     <div class="row mt-2 ">
                        <div class="col-md-12 ">
                           <h6 style="color:#5837D0"><strong>{{ $product->nama }}</strong> </h6>
                           <h6 class="harga">Rp. {{ number_format($product->harga) }}</h6>
                        </div>
                     </div>
                     <div class="row mt-2">
                        <div class="col-md-12">
                           <a href="{{ route('products.detail', $product->id) }}" class="btn btn-light btn-block hoverbtn border-0">
                              <i class="fas fa-eye"></i> Detail</a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            @endforeach
         </div>
      </div>
   </section>

   <style>

   </style>