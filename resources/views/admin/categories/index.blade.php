@extends('admin.layouts.app')

@section('title', 'Category Management')

@section('admin_content')
    <div class="container-fluid">
        <h1>Category Management</h1>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-success mb-3">Add New Category</a>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->slug }}</td>
                        <td>
                            <a href="{{ route('admin.categories.edit', $category->id) }}"
                                class="btn btn-primary btn-sm">Edit</a>
                            <form action="{{ route('admin.categories.delete', $category->id) }}" method="POST"
                                style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No categories found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $categories->links() }}
    </div>
@endsection