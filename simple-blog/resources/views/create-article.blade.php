<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Article</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container my-5">
    <h1 class="text-center mb-4">Create New Article</h1>

    <!-- Display Errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Title -->
        <div class="form-group">
            <label for="title">Title:</label>
            <input 
                type="text" 
                class="form-control @error('title') is-invalid @enderror" 
                name="title" 
                id="title" 
                value="{{ old('title') }}" 
                required>
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Description -->
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea 
                class="form-control @error('description') is-invalid @enderror" 
                name="description" 
                id="description" 
                rows="4" 
                required>{{ old('description') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Category -->
        <div class="form-group">
            <label for="category_id">Category:</label>
            <select 
                class="form-control @error('category_id') is-invalid @enderror" 
                name="category_id" 
                id="category_id" 
                required>
                <option value="" disabled selected>Select a category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Tags -->
        <div class="form-group">
            <label for="tags">Tags:</label>
            <select 
                class="form-control @error('tags') is-invalid @enderror" 
                name="tags[]" 
                id="tags" 
                multiple>
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', [])) ? 'selected' : '' }}>
                        {{ $tag->name }}
                    </option>
                @endforeach
            </select>
            @error('tags')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Image -->
        <div class="form-group">
            <label for="image">Image:</label>
            <input 
                type="file" 
                class="form-control-file @error('image') is-invalid @enderror" 
                name="image" 
                id="image" 
                required>
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Submit Button -->
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Create Article</button>
        </div>
    </form>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@2.11.7/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
