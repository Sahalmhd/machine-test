<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
</head>
<body>
    <h1>Edit Category</h1>

    <form action="{{ route('update.category', $category->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="name">Category Name:</label>
        <input type="text" name="name" id="name" value="{{ $category->name }}" required>
        <button type="submit">Update</button>
    </form>
</body>
</html>
