@extends('layouts.master')
@section('title') BikeShop | รายการสินค้า @stop
@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">
            <strong>รายการ</strong>
        </div>
    </div>
    
    <div class="panel-body">
        <form action="{{ URL::to('product/search') }}" class="form-inline" method="POST">
            @csrf
            <input type="text" name="q" class="form-control" placeholder="ค้นหา">
            <button type="submit" class="btn btn-primary">ค้นหา</button>
            <a href="{{ URL::to('product/edit') }}" class="btn btn-success pull-right">เพิ่มสินค้า</a>
        </form>
    </div>
    <table class="table table-bordered table-striped bs-table">
        <thead>
            <tr>
                <th>รูปสินค้า</th>
                <th>รหัส</th>
                <th>ชื่อสินค้า</th>
                <th>ประเภท</th>
                <th>คงเหลือ</th>
                <th>ราคาต่อหน่วย</th>
                <th>การทำงาน</th>
            </tr>
        </thead>
        
        <tbody>
            @foreach ($products as $product)
            <tr>
                <td><img src="{{ URL::to($product->image_url) }}" width="50px"></td>
                <td>{{ $product->code }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category->name }}</td>
                <td class="bs-price">{{ number_format($product->stock_qty, 0) }}</td>
                <td class="bs-price">{{ number_format($product->price, 2) }}</td>
                
                <td class="bs-center">
                    <a href="{{ URL::to('product/edit/'.$product->id) }}" class="btn btn-warning">แก้ไข</a>
                    <a href="#" class="btn btn-danger btn-delete" id-delete="{{ $product->id }}">ลบ</a>
                    <!--
                    <a href="{{ URL::to('product/remove/'.$product->id) }}" class="btn btn-danger">ลบ</a>
                    <button type="button" class="btn btn-danger" onclick="toastr.error('Fail!')">ลบ</button>
                    -->
                </td>
            </tr>
            @endforeach
        </tbody>
        
        <tfoot>
            <tr>
                <th colspan="4">รวม</th>
                <th class="bs-price">{{ number_format($products->sum('stock_qty'), 0) }}</th>
                <th class="bs-price">{{ number_format($products->sum('price'), 2) }}</th>
                <th></th>
            </tr>
        </tfoot>
    </table>
    <div class="panel-footer">
        <span>แสดงข้อมูลจำนวน {{ count($products) }}</span>
    </div>
</div>

<script>
    $('.btn-delete').on('click', function() {
        if (confirm('คุณต้องการลบข้อมูลสินค้าหรือไม่ ?')) {
            var url = "{{ URL::to('product/remove') }}" + "/" + $(this).attr('id-delete')
            window.location.href = url
        }
    })
</script>
{{ $products->links() }}
@endsection