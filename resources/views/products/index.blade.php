@extends('layouts.app')

@section('title')
catalog
@endsection

@section('content')
<div class="container">

    <h1>Products</h1>

    <div class="row">

        <!-- pagination block -->
        @if($products->links())
            <div class="row col-sm-12 pagination">{{ $products->links() }}</div>
        @endif

        @foreach($products as $product)

        <div class="col-lg-4 product_card_bm">
            <div class="card">

                <h5><a href="{{ route('productsShow', ['product' => $product->id]) }}">{{ $product->name }}</a></h5>

                <a href="{{ route('productsShow', ['product' => $product->id]) }}">

                    @if($product->image)
                    <div class="card-img-top b_image" style="background-image: url({{ asset('storage') }}/images/products/{{$product->id}}/{{$product->image}});">
                    @else
                    <div class="card-img-top b_image" style="background-image: url({{ asset('storage') }}/images/default/no-img.jpg);">
                    @endif

                        <div class="dummy"></div><div class="element"></div>
                    </div>

                </a>

                <div class="card-body">
                    <p class="card-text col-sm-12">
                        <span class="grey">
                            @if($product->price)
                                price: {{ $product->price }} &#8381;
                            @else
                                priceless
                            @endif
                        </span><br>
                    </p>

                    <div class="row product_buttons center">

                        @guest

                            <div class="col-sm-6">
                                <a href="{{ route('productsShow', ['product' => $product->id]) }}" class="btn btn-outline-primary">
                                    <i class="fas fa-eye"></i> view
                                </a>
                            </div>
                                
                            <div class="col-sm-6">
                                <a href="#" class="btn btn-outline-success">
                                    <i class="fas fa-shopping-cart"></i> buy now
                                </a>
                            </div>

                        @else

                            @if ( Auth::user()->can( ['view_products', 'edit_products', 'delete_products'], true ) )
                                <div class="col-sm-4">
                                    <a href="{{ route('productsShow', ['product' => $product->id]) }}" class="btn btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>

                                <div class="col-sm-4">
                                    <a href="{{ route('productsEdit', ['product' => $product->id]) }}" class="btn btn-outline-success">
                                        <i class="fas fa-pen-nib"></i>
                                    </a>
                                </div>

                                <div class="col-sm-4">
                                    <!-- form delete product -->
                                    <form action="{{ route('productsDestroy', ['product' => $product->id]) }}" method='POST'>
                                        @csrf

                                        @method('DELETE')

                                        <button type="submit" class="btn btn-outline-danger">
                                        <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            @elseif ( Auth::user()->can( ['view_products', 'edit_products'], true ) )

                                <div class="col-sm-6">
                                    <a href="{{ route('productsShow', ['product' => $product->id]) }}" class="btn btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>

                                <div class="col-sm-6">
                                    <a href="{{ route('productsEdit', ['product' => $product->id]) }}" class="btn btn-outline-success">
                                        <i class="fas fa-pen-nib"></i>
                                    </a>
                                </div>
                            @elseif ( Auth::user()->can( 'view_products' ) )

                                <div class="col-sm-6">
                                    <a href="{{ route('productsShow', ['product' => $product->id]) }}" class="btn btn-outline-primary">
                                        <i class="fas fa-eye"></i> view
                                    </a>
                                </div>
                                
                                <div class="col-sm-6">
                                    <a href="#" class="btn btn-outline-success">
                                        <i class="fas fa-shopping-cart"></i> buy now
                                    </a>
                                </div>
                                
                            @endif

                        @endguest

                    </div>
                </div>
            </div>
        </div>

        @endforeach

        <!-- pagination block -->
        @if($products->links())
            <div class="row col-sm-12 pagination">{{ $products->links() }}</div>
        @endif

    </div>
</div>
@endsection
