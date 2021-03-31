@extends('layouts.master')
@section('title') BikeShop | แก้ไขข้อมูลสินค้า @stop
@section('content')
{!!
    Form::model($product,
        array('method' => 'post',
            'enctype' => 'multipart/form-data',
            'action' => 'App\Http\Controllers\ProductController@update'))
!!}
<input type="hidden" name="id" value="{{ $product->id }}">

<ul class="breadcrumb">
    <li><a href="{{ URL::to('product') }}">รายการสินค้า</a></li>
    <li class="active">แก้ไขข้อมูลสินค้า</li>
</ul>

@if($errors->any())
<div class="alert alert-danger">
    @foreach ($errors->all() as $err)
        <div>{{ $err }}</div>
    @endforeach
</div>
@endif

<table class="table table-bordered">
    <caption>
        <h1>แก้ไขข้อมูลสินค้า</h1>
    </caption>
    <tr>
        <td> {{ Form::label('code', 'รหัสสินค้า') }} </td>
        <td> {{ Form::text('code', $product->code, ['class' => 'form-control']) }} </td>
    </tr>
    <tr>
        <td> {{ Form::label('category_id', 'ประเภทสินค้า') }} </td>
        <td> {{ Form::select('category_id', $categories, Request::old('category_id'), ['class' => 'form-control']) }} </td>
    </tr>
    <tr>
        <td> {{ Form::label('name', 'ชื่อสินค้า') }} </td>
        <td> {{ Form::text('name', $product->name, ['class' => 'form-control']) }} </td>
    </tr>
    <tr>
        <td> {{ Form::label('stock_qty', 'คงเหลือ') }} </td>
        <td> {{ Form::text('stock_qty', $product->stock_qty, ['class' => 'form-control']) }} </td>
    </tr>
    <tr>
        <td> {{ Form::label('price', 'ราคาขายต่อหน่วย') }} </td>
        <td> {{ Form::text('price', $product->price, ['class' => 'form-control']) }} </td>
    </tr>
    @if($product->image_url)
    <tr>
        <td><strong>รูปสินค้า</strong></td>
        <td><img src="{{ URL::to($product->image_url) }}" alt=""></td>
    </tr>
    @endif
    <tr>
        <td> {{ Form::label('image', 'เลือกรูปภาพสินค้า') }} </td>
        <td> {{ Form::file('image') }} </td>
    </tr>
</table>

<button type="submit" class="btn btn-primary">
    <i class="fa fa-save"></i> บันทึก
</button>
<a href="{{ URL::to('product') }}" class="btn btn-danger">ยกเลิก</a>

{!! Form::close() !!}
@endsection