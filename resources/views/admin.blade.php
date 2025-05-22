<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Lost & Found</title>
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
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px 8px 0 0;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light w-100 mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Lost & Found Items</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item me-2">
                        <a class="btn btn-outline-secondary" href="{{ url('/') }}">
                            Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger">
                                Log out
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <!-- Custom Alert -->
        <div id="customAlert" class="alert d-none" role="alert"></div>
        <h1 class="mb-4">All Lost Items</h1>
        @if($lostItems->isEmpty())
            <p class="text-center text-muted">No lost items reported yet.</p>
        @else
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
                                <p class="card-text"><strong>Date Lost:</strong> {{ $item->date_lost }}</p>
                                <div class="d-flex justify-content-center gap-2 mt-3">
                                    <a href="{{ route('lost.edit', $item->id) }}" class="btn btn-sm btn-success">Edit</a>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $item->id }}">
                                        Delete
                                    </button>
                                    <form class="found-form" data-item="{{ $item->id }}" action="#" method="POST" style="display:inline;">
                                        {{-- TODO: Implement mark as found route --}}
                                        @csrf
                                        <button type="button" class="btn btn-sm btn-warning" disabled>Mark as Found</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Confirmation Modal -->
                    <div class="modal fade" id="deleteModal-{{ $item->id }}" tabindex="-1" aria-labelledby="deleteModalLabel-{{ $item->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel-{{ $item->id }}">Confirm Delete</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete this lost item?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <form class="delete-form" data-item="{{ $item->id }}" action="{{ route('lost.destroy', $item->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Show custom alert
    function showCustomAlert(message, type = 'success') {
        const alertDiv = document.getElementById('customAlert');
        alertDiv.className = 'alert alert-' + type;
        alertDiv.textContent = message;
        alertDiv.classList.remove('d-none');
        setTimeout(() => {
            alertDiv.classList.add('d-none');
        }, 2500);
    }

    // You can add similar logic for edit/mark as found if needed
    </script>
</body>
</html>