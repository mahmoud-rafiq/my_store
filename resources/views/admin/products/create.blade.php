@extends('admin.master')

@section('title', 'Add New Products | ' . env('APP_NAME'))

@section('content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1 class="h3 mb-0 text-gray-800">Create New Product</h1>
        <a class="btn btn-dark" href="{{ route('admin.products.index') }}">All Products</a>
    </div>

    @include('admin.parts.errors')

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">

        @csrf

@include('admin.products.form')
        <button class="btn btn-success px-5">Save</button>
    </form>



@stop
