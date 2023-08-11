@extends('admin.master')

@section('title', 'All Categories | ' . env('APP_NAME'))

@section('styles')
<style>
    .table th, .table td{
        vertical-align: middle;
    }
</style>
@stop
@section('content')
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1 class="h3 mb-0 text-gray-800">All Categories</h1>
        <a class="btn btn-dark" href="{{ route('admin.categories.create') }}">Add New Category</a>
    </div>
    @if (session('msg'))
    <div class="alert alert-{{session('type')}}">{{session('msg')}}</div>

    @endif
    <table class="table table-hover table-bordered table-striped ">
        <tr>

            <th>ID</th>
            <th>Name</th>
            <th>Image</th>
            <th>Parent</th>
            <th>Products Count</th>
            <th>Action</th>


        </tr>
        @foreach ($categories as $category)
            <tr>

                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                <td><img width="100" src="{{asset('uploads/images/'.$category->image)}}" alt=""></td>
                <td>{{ $category->parent->name }}</td>
                <td><span class="badge badge-primary px-2">{{$category->products_count}}</span></td>
                <td>
                    <a class="btn btn-sm btn-primary" href="{{ route('admin.categories.edit', $category->id) }}">
                        <i class="fas fa-edit"></i></a>
                    <form class="d-inline" action="{{ route('admin.categories.destroy', $category->id) }}" method="POST">
                        @csrf
                        @method('delete');
                        <button class="btn btn-sm btn-danger" onclick="return confirm('are you sure?')"><i
                                class="fas fa-trash"></i> </button>
                    </form>
                </td>


            </tr>
        @endforeach

    </table>

    {{ $categories->links() }}

@stop
