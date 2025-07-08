@extends('admin.layouts.app')

@section('title', 'Manage Banners')

@section('admin_content')
    <div class="container-fluid">
        <h1>Banner Management</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('admin.banners.create') }}" class="btn btn-primary">Add New Banner</a>
        </div>

        <div class="card">
            <div class="card-header">All Banners</div>
            <div class="card-body">
                @if($banners->isEmpty())
                    <p>No banners found.</p>
                @else
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Subtitle</th>
                                <th>Order</th>
                                <th>Active</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($banners as $banner)
                                <tr>
                                    <td>{{ $banner->id }}</td>
                                    <td>
                                        @if($banner->image_path)
                                            <img src="{{ asset('storage/' . $banner->image_path) }}" alt="Banner Image"
                                                style="width: 100px; height: auto; border-radius: 8px;">
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>{{ $banner->title ?? 'N/A' }}</td>
                                    <td>{{ $banner->subtitle ?? 'N/A' }}</td>
                                    <td>{{ $banner->order }}</td>
                                    <td>
                                        @if($banner->is_active)
                                            <span class="badge bg-success">Yes</span>
                                        @else
                                            <span class="badge bg-danger">No</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.banners.edit', $banner->id) }}"
                                            class="btn btn-info btn-sm">Edit</a>
                                        <form action="{{ route('admin.banners.delete', $banner->id) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this banner?');">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end">
                        {{ $banners->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection