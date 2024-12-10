<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Article</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container my-4">
    <h1 class="text-center">Edit Article</h1>

    <form action="{{ route('articles.update', ['id' => $article->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') <!-- HTTP method for updating resources -->

        <!-- Title -->
        <div class="form-group">
            <label for="title">Title:</label>
            <input 
                type="text" 
                name="title" 
                id="title" 
                class="form-control @error('title') is-invalid @enderror" 
                value="{{ old('title', $article->title) }}" 
                required>
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Description -->
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea 
                name="description" 
                id="description" 
                class="form-control @error('description') is-invalid @enderror" 
                required>{{ old('description', $article->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Category -->
        <div class="form-group">
            <label for="category_id">Category:</label>
            <select 
                name="category_id" 
                id="category_id" 
                class="form-control @error('category_id') is-invalid @enderror" 
                required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $article->category_id) == $category->id ? 'selected' : '' }}>
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
                name="tags[]" 
                id="tags" 
                class="form-control @error('tags') is-invalid @enderror" 
                multiple>
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', $article->tags->pluck('id')->toArray())) ? 'selected' : '' }}>
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
                name="image" 
                id="image" 
                class="form-control @error('image') is-invalid @enderror">
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            @if($article->image && file_exists(public_path('storage/' . $article->image)))
                <p class="mt-3">Current Image:</p>
                <img src="{{ asset('storage/' . $article->image) }}" alt="Article Image" width="100">
            @endif
        </div>

        <!-- Submit and Cancel Buttons -->
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Update Article</button>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@2.11.7/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
