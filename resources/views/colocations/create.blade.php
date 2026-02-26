<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>colocation create</title>
</head>
<body>
    <form action="{{ route('colocations.store') }}" method="POST">
        @csrf

        <input type="text" name="name" placeholder="Name"><br>

        <button type="submit">create</button>
    </form>
</body>
</html>