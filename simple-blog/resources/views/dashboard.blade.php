<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        /* Custom styles */
        .article-item img {
            max-width: 100%;
            height: 150px;
            object-fit: cover;
        }
        .card {
            height: 100%;
        }
        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Admin Dashboard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('articles.create') }}">Create Article</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('categories.index') }}">Manage Categories</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('tags.index') }}">Manage Tags</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="container my-4">
        <h2 class="mb-3 text-center">All Articles</h2>

        <!-- Article Grid -->
        <div class="row">
            @forelse($articles as $article)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm">
                        <!-- Image -->
                        @if($article->image && file_exists(public_path('storage/' . $article->image)))
                            <img src="{{ asset('storage/' . $article->image) }}" alt="Article Image" class="card-img-top article-item">
                        @else
                            <img src="https://via.placeholder.com/150" alt="No Image" class="card-img-top article-item">
                        @endif

                        <!-- Article Content -->
                        <div class="card-body">
                            <h5 class="card-title">{{ $article->title }}</h5>
                            <p class="card-text text-truncate" title="{{ $article->description }}">{{ Str::limit($article->description, 80) }}</p>
                            <div class="d-flex justify-content-between mt-3">
                                <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('articles.destroy', $article->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this article?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p class="text-muted">No articles found. Start by <a href="{{ route('articles.create') }}">creating one</a>.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3">
        <p class="mb-0">&copy; {{ date('Y') }} Admin Dashboard. All rights reserved.</p>
    </footer>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
