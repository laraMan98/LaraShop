@extends('products.products_index')

@section('titlePage', 'LegaShop | Household Care');
@section('content')

<link rel="stylesheet" href="{{asset('products_asset/collection/collection.css')}}">

<!-- IMAGES CONTAINER -->
<div class="container img-container">
    <img class="rounded img-rice" src="{{asset('products_asset/images/cover-images/householdcare-cover.jpg')}}">
    <p class="text-categories-hc">HOUSEHOLD CARE</p>
</div>

<!-- BREADCRUM CONTAINER -->
<div class="container breadcrumb-container" >
    <ul class="breadcrumb-items">
        <li class="previous-link"><a href="{{route('products.store')}}">Store</a></li>
        <li><i class="fas fa-chevron-right"></i></li>
        <li>Household Care</li>
    </ul>
</div>

<!-- SORT BY CONTAINER -->
<div class="container mt-4">
    <form action="{{route('filterHouseholdCare')}}" method="POST">
        @csrf
        <div class="sort-container">
            <p class="sort">Sort By</p>
            <div class="col-md-4">
                <select class="form-select shadow-none" name="sort" onchange='this.form.submit()'>
                    <option {{request()->input('sort') == null ? 'selected' : ''}} value="">Default</option>
                    <option {{request()->input('sort') == 'asc' ? 'selected' : ''}} value="asc" > Price: Low to High</option>
                    <option {{request()->input('sort') == 'desc' ? 'selected' : ''}} value="desc" >Price: High to Low</option>
                </select>
            </div>
            <p class="pages">1 of 1</p>
            <button class="previous-page" disabled><i class="fas fa-chevron-left"></i></button>
            <button class="next-page"><i class="fas fa-chevron-right"></i></button>
        </div>
    </form>      
</div>

<!-- PRODUCT CONTAINER -->
<div class="container product">
    <div class="row product-container">
        @foreach ($productsHouseholdCares as $productsHouseholdCare)
            <div class="col-md-3 product-col" data-id="{{$productsHouseholdCare->id}}">
                <a class="link-details" href="{{url('/products/product-details/'.$productsHouseholdCare->id)}}">
                <div class="card">
                    <div class="card-body">
                        <img src="{{asset('uploads/product_images/'.$productsHouseholdCare->product_image)}}" class="product-img">
                        <div class="items-info-container">
                            <p class="card-title mt-4">&#8369; <b id="price-product">{{$productsHouseholdCare->product_price}}.00</b></p>
                            <p class="card-name">{{$productsHouseholdCare->product_name}}</p></a>
                            <p class="card-category">{{$productsHouseholdCare->category_name}}</p>
                            <button class="minus-product"><i class="fas fa-minus"></i></button>
                            <input type="text" class="product-quantity-value" 
                            id="product-quantity-value" value="1" maxlength="2">
                            <button class="plus-product"><i class="fas fa-plus"></i></button>
                            <button class="btnAddToCart mt-3" id="add-cart">ADD TO CART</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        {{$productsHouseholdCares->links('/vendor/pagination/products-pagination')}}
    </div>  
</div>

<center><img class="preloader-products" id="preloader-products"
    src="/products_asset/images/gif/loader-products.gif" alt="Loading" />
</center>

{{-- JQUERY PLUGIN --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js" 
integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" 
crossorigin="anonymous"></script> 

{{-- SWEEET ALERT PLUGINS --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" 
integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" 
crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $('.search').css('opacity', '1');
        $('.search-icon').css('opacity', '1');
</script>
@endsection