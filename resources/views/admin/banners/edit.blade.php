@extends('admin.layouts.app')

@section('title', 'Edit Banner')

@section('admin_content')
    <div class="container-fluid">
        <h1>Edit Banner</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <div class="card-header">Banner Details</div>
            <div class="card-body">
                <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') {{-- Use PUT method for update --}}
                    <div class="mb-3">
                        <label for="title" class="form-label">Title (Optional)</label>
                        <input type="text" class="form-control" id="title" name="title"
                            value="{{ old('title', $banner->title) }}">
                    </div>
                    <div class="mb-3">
                        <label for="subtitle" class="form-label">Subtitle (Optional)</label>
                        <input type="text" class="form-control" id="subtitle" name="subtitle"
                            value="{{ old('subtitle', $banner->subtitle) }}">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description (Optional)</label>
                        <textarea class="form-control" id="description" name="description"
                            rows="3">{{ old('description', $banner->description) }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="link_url" class="form-label">Link URL (Optional)</label>
                        <input type="url" class="form-control" id="link_url" name="link_url"
                            value="{{ old('link_url', $banner->link_url) }}">
                    </div>
                    <div class="mb-3">
                        <label for="order" class="form-label">Order</label>
                        <input type="number" class="form-control" id="order" name="order"
                            value="{{ old('order', $banner->order) }}" required>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', $banner->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Is Active</label>
                    </div>
                    <div class="mb-3">
                        <label for="image_path" class="form-label">Banner Image (Leave blank to keep current)</label>
                        <input type="file" class="form-control" id="image_path" name="image_path">
                        @if($banner->image_path)
                            <div class="mt-2">
                                Current Image: <img src="{{ asset('storage/' . $banner->image_path) }}"
                                    alt="Current Banner Image" style="width: 150px; height: auto; border-radius: 8px;">
                            </div>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary">Update Banner</button>
                    <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
@endsection