@extends('layouts.master')
@section('title') BikeShop | อุปกรณ์จักรยาน, อะไหล่, ชุดแข่ง, และอุปกรณ์ตกแต่ง
@endsection
@section('content')
    <div class="container" ng-app="app" ng-controller="ctrl">
        <div class="row">
            <div class="col-md-3">
                <h1>สินค้าในร้าน</h1>
            </div>

            <div class="col-md-9">
                <div class="pull-right search-block">
                    <input
                        type="text"
                        class="form-control"
                        ng-model="query"
                        placeholder="ค้นหา"
                        width="200px"
                        ng-keyup="searchProduct($event)">
                </div>
            </div>
        </div>

        <div class="row" style="margin-top: 20px">
            <div class="col-md-3">
                <div class="list-group">
                    <a href="#" 
                        class="list-group-item"
                        ng-class="{'active': category == null}"
                        ng-click="getProductList(null)"> ทั้งหมด </a>
                    
                    <a href="#"
                        class="list-group-item"
                        ng-repeat="c in categories"
                        ng-click="getProductList(c)"
                        ng-class="{'active': category.id == c.id}"> @{ c.name } </a>
                </div>
            </div>

            <div class="col-md-9" ng-if="products.length">
                <div class="row">
                    <div class="col-md-3" ng-repeat="p in products"> <!-- |filter:query -->
                        <div class="panel panel-default bs-product-card">
                            <div class="panel-body">
                                <div class="image-block">
                                    <img ng-src="@{p.image_url}">
                                </div>

                                <h4><a href="#">@{ p.name }</a></h4>

                                <div class="form-group">
                                    <div>คงเหลือ : @{ p.stock_qty|number:0 }</div>
                                    <div>ราคาขาย : <strong> @{ p.price|number:2 } </strong></div>
                                    <div>
                                        สถานะ : 
                                        <span ng-if="p.stock_qty >= 5" ng-class="{'label label-success': true}"> สินค้าเหลือ </span>
                                        <span ng-if="p.stock_qty > 0 && p.stock_qty < 5" ng-class="{'label label-warning': true}"> สินค้าใกล้จะหมด </span>
                                        <span ng-if="p.stock_qty <= 0" ng-class="{'label label-danger': true}"> สินค้าหมด </span>
                                    </div>
                                </div>

                                <a href="#" class="btn btn-success btn-block" ng-click="addToCart(p)">
                                    <i class="fa fa-shopping-cart"></i> หยิบใส่ตะกร้า
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <h1 ng-if="!products.length">ไม่พบข้อมูลสินค้า</h1>
        </div>
    </div>

    <script type="text/javascript">
        var app = angular.module('app', []).config(function ($interpolateProvider) {
            $interpolateProvider.startSymbol('@{').endSymbol('}');
        });

        app.controller('ctrl', function ($scope, productService) {
            $scope.products = [];
            $scope.categories = [];
            $scope.category = {};
            
            $scope.getProductList = function(category) {
                $scope.category = category;
                category_id = category != null ? category.id : '';

                productService.getProductList(category_id).then(function(res) {
                    if (!res.data.ok) return;

                    $scope.products = res.data.products;
                })
            }

            $scope.getCategoryList = function() {
                productService.getCategoryList().then(function(res) {
                    if (!res.data.ok) return;

                    $scope.categories = res.data.categories;
                })
            }

            $scope.searchProduct = function(e) {
                productService.searchProduct($scope.query).then(function(res) {
                    if (!res.data.ok) return;

                    $scope.products = res.data.products;
                })
            }

            $scope.addToCart = function(p) {
                window.location.href = '/cart/add/' + p.id;
            }

            $scope.getProductList();
            $scope.getCategoryList();
        });

        app.service('productService', function($http) {
            this.getProductList = function(category_id) {
                if (category_id) {
                    return $http.get('/api/product/' + category_id);
                }

                return $http.get('/api/product');
            }

            this.getCategoryList = function() {
                return $http.get('/api/category');
            }

            this.searchProduct = function(query) {
                return $http.post('api/product/search', JSON.stringify({ query: query }))
            }
        });

    </script>
@endsection