@extends('layouts.master')
@section('title') BikeShop | ตะกร้าสินค้า @stop
@section('content')
    <div class="container">
        <h1>สินค้าในตะกร้า</h1>
        <div class="breadcrumb">
            <li>
                <a href="{{ URL::to('/') }}"> <i class="fa fa-home"></i> หน้าร้าน </a>
            </li>
            <li class="active">สินค้าในตะกร้า</li>
        </div>

        <div class="panel panel-default">
            @if (count($cart_items))
                <?php $sum_price = 0 ?>
                <?php $sum_qty = 0 ?>

                <table class="table bs-table">
                    <thead>
                        <tr>
                            <th width="10%">รูปสินค้า</th>
                            <th width="10%">รหัสสินค้า</th>
                            <th width="40%">ชื่อสินค้า</th>
                            <th width="15%">จำนวน</th>
                            <th width="15%">ราคา</th>
                            <th width="10%"></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($cart_items as $item)
                            <tr>
                                <td> <img src="{{ asset($item['image_url']) }}" height="36"> </td>
                                <td>{{ $item['code'] }}</td>
                                <td>{{ $item['name'] }}</td>
                                <td>
                                    <input type="text" class="form-control" value="{{ $item['qty'] }}"
                                    onkeyup="updateCart( {{ $item['id'] }}, this )">
                                </td>
                                <td>{{ number_format($item['price'] * $item['qty'], 0) }}</td>
                                <td>
                                    <a href="{{ URL::to('cart/delete/'.$item['id']) }}" class="btn btn-danger pull-right"> <i class="fa fa-times"></i> </a>
                                </td>
                            </tr>

                            <?php $sum_price += $item['price'] * $item['qty'] ?>
                            <?php $sum_qty += $item['qty'] ?>
                        @endforeach
                    </tbody>

                    <tfoot>
                        <tr>
                            <th colspan="3">รวม</th>
                            <th>{{ number_format($sum_qty, 0) }}</th>
                            <th>{{ number_format($sum_price, 0) }}</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            @else
                <div class="panel-body">
                    <strong>ไม่พบรายการสินค้า!</strong>
                </div>
            @endif
        </div>

        <a href="{{ URL::to('/') }}" class="btn btn-default"> ย้อนกลับ </a>

        <div class="pull-right">
            <a href="{{ URL::to('cart/checkout') }}" class="btn btn-primary">
                ชำระเงิน <i class="fa fa-chevron-right"></i>
            </a>
        </div>
    </div>

    <script>
        function updateCart(id, qty) {
            if (qty.value != "") {
                window.location.href = `/cart/update/${id}/${qty.value}`
            }
        }
    </script>
@endsection