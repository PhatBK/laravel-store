@extends('layouts.app')

@section('title', 'order')

@section('content')
<div class="container">

    {{-- <div class="grey">
        <span class="grey">created:</span>  {{ $order->created_at }}
        <span class="grey">updated:</span>  {{ $order->updated_at }}
    </div> --}}


    {{-- {{ dd($order) }} --}}
    {{-- {{ dd($order, $order->cart, $order->cart->total_qty) }} --}}
    
    @if( !empty($order->cart) and !empty($order->cart->total_qty) )

        <div class="row justify-content-center">
            <h1>Detail of order #{{ $order->id }}</h1>
        </div>

        @permission('view_users')
            <h2>customer: <span class="grey">{{ $order->customer->name }}</span></h2>
        @endpermission

        <h2>status of order: <span class="grey">{{ $order->status->description }}</span></h2>

        <div class="row">

            @if($order->cart->total_qty)

                <h2>specification</h2>
                <table class="blue_table">

                    <tr>
                        <th>#</th>
                        <th>img</th>
                        <th>name</th>
                        <th>qty</th>
                        {{-- <th class="actions2">action</th> --}}
                        @permission('edit_orders')
                            <th>status</th>
                        @endpermission
                        <th>price</th>
                        <th>amount</th>
                    </tr>

                    {{-- {{dd($order->cart)}} --}}

                @foreach($order->cart->items as $i => $item)

                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if($item['item']->image)
                            <div class="cart_image b_image" style="background-image: url({{ asset('storage') }}/images/products/{{$item['item']->id}}/{{$item['item']->image}});">
                            @else
                            <div class="cart_image b_image" style="background-image: url({{ asset('storage') }}/images/default/no-img.jpg);">
                            @endif
        
                                <div class="dummy"></div><div class="element"></div>
                            </div>       
                        </td>
                        <td>
                            <a href="{{ route('products.show', ['product' => $item['item']->id]) }}">
                                {{ $item['item']->name }}
                            </a>
                        </td>
                        <td class="center no_fl">
                            {{ $order->cart->items[$i]['qty'] }}
                        </td>

                        @permission('edit_orders')
                            @selectStatusOrder([
                                'statuses' => $statuses, 
                                'order' => $order, 
                            ])
                        @endpermission

                        {{-- <td class="center no_fl"> --}}
                            {{-- <a href="{{ route('users.edit', ['user' => $user->id]) }}" class="btn btn-outline-success">
                                <i class="fas fa-pen-nib"></i>
                            </a> --}}
                            {{-- <form action="{{ route('cart.delete-item', ['product' => $item['item']->id]) }}" method="POST" class="del_btn">
                                @csrf

                                @method("DELETE")

                                <button type="submit" class="btn btn-outline-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form> --}}
                        {{-- </td> --}}
                        <td>{{ $item['item']->price }}</td>
                        <td>{{ $order->cart->items[$i]['amount'] }}</td>
                    </tr>

                @endforeach

                    <tr>
                        @permission('edit_orders')
                            <th colspan="6">total payment</th>
                        @else
                            <th colspan="5">total payment</th>
                        @endpermission
                        <td>{{ $order->cart->total_payment }}</td>
                    </tr>

                </table>

                <h2>date</h2>
                <table class="blue_table">
                    <tr>
                        <td colspan="3">created_at</td>
                        <td colspan="3">updated_at</td>
                    </tr>    
                    <tr>
                        <td colspan="3">{{ $order->created_at }}</td>
                        <td colspan="3">{{ $order->updated_at }}</td>
                    </tr>
                </table>

                <h2>comment to order</h2>
                <table class="blue_table">
                    <tr>
                        <th colspan="6">comment</th>
                    </tr>
                    <tr>
                        <td colspan="6" class="ta_l">{{ $order->comment ?? '-' }}</td>
                    </tr>
                </table>

                <h2>shipping</h2>
                <table class="blue_table">
                    <tr>
                        <th colspan="6">address</th>
                    </tr>
                    <tr>
                        <td colspan="6">{{ $order->cart->address ?? '-' }}</td>
                    </tr>
                </table>

            @endif
        </div>

    @else

        {{-- ??? --}}
        
        <div class="row justify-content-center">
            <h1>Youre cart is empty</h1>
        </div>
       
        <div class="row justify-content-center">
            <div class="col-sm-6">
                <a href="{{ route('products.index') }}" class="btn btn-success">shopping</a>
            </div>
       </div>

        <div class="wrap_panda">
            <div class="panda">
                <img src="https://yakoffka.ru/src/img/links/panda-waving.png" alt="" srcset="">
            </div>
        </div>

    @endif


    <h2>table history</h2>

    <h2>chat</h2>

</div>
@endsection
