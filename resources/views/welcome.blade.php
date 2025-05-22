<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome - Lost & Found</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-img-container {
            position: relative;
            height: 250px;
            width: 100%;
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 1px solid #ddd;
        }
        .card-img-top {
            max-height: 230px;
            max-width: 100%;
            object-fit: contain;
            border-radius: 8px 8px 0 0;
            background: #f8f9fa;
            display: block;
            margin: auto;
        }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-light bg-light w-100 mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Lost & Found</a>
            <div class="d-flex">
                <a href="{{ route('admin') }}" class="btn btn-primary">Inventory</a>
            </div>
        </div>
    </nav>
    <div class="container my-5">
        <h2 class="mb-4 text-center">Reported Lost Items</h2>
        @if(isset($lostItems) && $lostItems->isNotEmpty())
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @foreach($lostItems as $item)
                    <div class="col">
                        <div class="card shadow-sm h-100">
                            <div class="card-img-container">
                                @if($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}"
                                         class="card-img-top"
                                         alt="{{ $item->item_name }}">
                                @else
                                    <img src="{{ asset('storage/no-image.png') }}"
                                         class="card-img-top"
                                         alt="No Image">
                                @endif
                            </div>
                            <div class="card-body">
                                <h5 class="card-title text-primary">{{ $item->name }}</h5>
                                <p class="card-text"><strong>Item Name:</strong> {{ $item->item_name }}</p>
                                <p class="card-text"><strong>Description:</strong> {{ $item->description }}</p>
                                <p class="card-text"><strong>Last Seen Location:</strong> {{ $item->location }}</p>
                                <p class="card-text"><strong>Contact Info:</strong> {{ $item->contact_info }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-info text-center mt-5">
                <h3>Welcome</h3>
                <p>No lost items has been added yet.</p>
            </div>
        @endif
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
