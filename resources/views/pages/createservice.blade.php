@extends('layouts.navbar')
@section('content')
<div class="p-6">
    <h2 class="text-xl font-bold mb-4">Add New Service</h2>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('services.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <label>Service Name</label>
            <input type="text" name="name" value="{{ old('name') }}"
                   class="border rounded w-full p-2" placeholder="e.g. Wash & Fold">
        </div>

        <div>
            <label>Price ($)</label>
            <input type="number" step="0.01" name="price" value="{{ old('price') }}"
                   class="border rounded w-full p-2" placeholder="e.g. 5.00">
        </div>

        <div>
            <label>Description</label>
            <textarea name="description" class="border rounded w-full p-2">{{ old('description') }}</textarea>
        </div>

        <div>
            <label>Image</label>
            <input type="file" name="image" class="border rounded w-full p-2">
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
            Save
        </button>
    </form>
</div>
@endsection