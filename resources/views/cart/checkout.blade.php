@extends('layouts.master')
@section('content')
    {!!
        Form::open(array('method' => 'get',
                'enctype' => 'multipart/form-data',
                'action' => 'App\Http\Controllers\CartController@complete'))
    !!}
    <div class="container">
        <h1> ชำระเงิน </h1>
        <div class="breadcrumb">
            <li><a href="{{ URL::to('home') }}"><i class="fa fa-home"></i> หน้าร้าน</a></li>
            <li><a href="{{ URL::to('cart/view') }}">สินค้าในตะกร้า</a></li>
            <li class="active">ชำระเงิน</li>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        รายการสินค้า
                    </div>
                    <div class="panel-body">
                        @if (count($cart_items))
                            <?php $sum_price = 0 ?>
                            <?php $sum_qty = 0 ?>

                            <table class="table bs-table">
                                <thead>
                                    <tr>
                                        <th width="10%">รูปสินค้า</th>
                                        <th width="20%">รหัสสินค้า</th>
                                        <th width="40%">ชื่อสินค้า</th>
                                        <th width="15%">จำนวน</th>
                                        <th width="15%">ราคา</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($cart_items as $item)
                                        <tr>
                                            <td> <img src="{{ asset($item['image_url']) }}" height="36"> </td>
                                            <td>{{ $item['code'] }}</td>
                                            <td>{{ $item['name'] }}</td>
                                            <td>{{ number_format($item['qty'], 0) }}</td>
                                            <td>{{ number_format($item['price'] * $item['qty'], 0) }}</td>
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
                            <strong>ไม่พบรายการสินค้า!</strong>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <strong>ข้อมูลลูกค้า</strong>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="form-group">
                            <label for="cust_name">ชื่อ-นามสกุล</label>
                            <input type="text" class="form-control" name="cust_name" id="cust_name" placeholder="ชื่อ-นามสกุล">
                        </div>

                        <div class="form-group">
                            <label for="cust_email">อีเมล์</label>
                            <input type="text" class="form-control" name="cust_email" id="cust_email" placeholder="อีเมล์ของท่าน">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <a href="{{ URL::to('cart/view') }}" class="btn btn-default">
            <i class="fa fa-chevron-left"></i> ย้อนกลับ
        </a>

        <div class="pull-right">
            <button type="submit" class="btn btn-warning" id="btn-submit">
                <i class="fa fa-print"></i> พิมพ์ใบสั่งซื้อ
            </button>

            <a href="#" onclick="complete()" class="btn btn-primary"><i class="fa fa-check"></i> จบการขาย</a>
        </div>
    </div>

    <script>
        function complete() {
            let name = document.getElementById('cust_name').value;
            let email = document.getElementById('cust_email').value;

            //window.open("{{ URL::to('cart/complete') }}" + "?cust_name=" + name + "&cust_email=" + email, "_blank");
            window.open(`{{ URL::to('cart/complete') }}?cust_name=${name}&cust_email=${email}`, "_blank");
            window.location.href = "{{ URL::to('cart/finish') }}";
        }
    </script>
    {!! Form::close() !!}
@endsection