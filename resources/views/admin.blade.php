<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Lost & Found</title>
</head>
<body>
    <h1>Admin Panel</h1>
    <a href="{{ route('welcome') }}">Go to Welcome Panel</a>
    <h2>All Lost Items</h2>
    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Item Name</th>
            <th>Description</th>
            <th>Date Lost</th>
            <th>Actions</th>
        </tr>
        @foreach($lostItems as $item)
        <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->description }}</td>
            <td>{{ $item->date_lost }}</td>
            <td>
                <a href="{{ route('lost.edit', $item->id) }}">Edit</a> |
                <form action="{{ route('lost.destroy', $item->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Delete this item?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</body>
</html>