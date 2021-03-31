@extends('layouts.master')
@section('title') BikeShop | รายการประเภทสินค้า @stop
@section('content')
<table class="table table-bordered table-striped bs-table">
    <thead>
        <tr>
            <th>รหัส</th>
            <th>ชื่อประเภท</th>
            <th>การทำงาน</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                
                <td class="bs-center">
                    <button type="button" class="btn btn-warning" onclick="toastr.success('Successfully!')">แก้ไข</button>
                    <button type="button" class="btn btn-danger" onclick="toastr.error('Fail!')">ลบ</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection