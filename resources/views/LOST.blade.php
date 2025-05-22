@extends('layouts.app')

@section('content')
<style>
    .card {
        height: 100%; /* Allow cards to adjust dynamically */
        overflow: hidden;
        border: 1px solid #ddd;
        border-radius: 8px;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .card:hover {
        transform: scale(1.02);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }
    .card-img-container {
        position: relative;
        height: 250px; /* Adjust image height */
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
    .card-body {
        padding: 20px;
    }
    .btn-custom {
        border-radius: 20px;
        padding: 10px 20px;
    }
</style>

<!-- Navbar (same as landing.blade.php) -->
<nav class="navbar navbar-expand-lg navbar-light bg-light w-100 mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Lost & Found</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-center">
                @auth
                <li class="nav-item me-2">
                    <a class="btn btn-outline-success" href="{{ route('admin') }}">
                        Inventory
                    </a>
                </li>
                @endauth
                @guest
                @endguest
            </ul>
        </div>
    </div>
</nav>


<div class="container">
    {{-- Removed duplicate Log in button. Use only the navbar/upper right button for login --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="text-center my-4">
        <h1 class="display-5">Lost Something?</h1>
        <p class="lead">Report your lost items here and help us reconnect you with your belongings.</p>
        <button type="button" class="btn btn-success btn-lg btn-custom" data-bs-toggle="modal" data-bs-target="#lostFormModal">
            Post Lost Item
        </button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="lostFormModal" tabindex="-1" aria-labelledby="lostFormModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="lostFormModalLabel">Post About Your Lost Item</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="lostItemForm" action="{{ route('lost.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                            <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="student_id" class="form-label">Student ID Number</label>
                            <input type="text" class="form-control" id="student_id" name="student_id" required>
                        </div>
                        <div class="mb-3">
                            <label for="item_name" class="form-label">Item Name</label>
                            <input type="text" class="form-control" id="item_name" name="item_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="contact_info" class="form-label">Contact Information</label>
                            <input type="text" class="form-control" id="contact_info" name="contact_info" required>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Upload Picture</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" class="form-control" id="location" name="location" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <hr class="my-5">

    <!-- Move the lost items section up by reducing margin-top and margin-bottom -->
    <div class="container" style="margin-top: 10px; margin-bottom: 20px;">
        <h2 class="text-center mb-4">Reported Lost Items</h2>
        @if($lostItems->isEmpty())
            <p class="text-center text-muted">No lost items reported yet.</p>
        @else
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 justify-content-center">
                @foreach($lostItems as $item)
                    <div class="col">
                        <div class="card shadow-sm h-100">
                            <div class="card-img-container" style="height:260px; background:#fff; display:flex; align-items:center; justify-content:center;">
                                @if($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}"
                                         class="card-img-top"
                                         alt="{{ $item->item_name }}"
                                         style="max-height: 240px; max-width: 100%; object-fit: contain; display: block; margin: auto; border-radius: 8px 8px 0 0; box-shadow: 0 2px 8px rgba(0,0,0,0.08); background: #f8f9fa;">
                                @else
                                    <img src="{{ asset('storage/no-image.png') }}"
                                         class="card-img-top"
                                         alt="No Image"
                                         style="max-height: 240px; max-width: 100%; object-fit: contain; display: block; margin: auto; border-radius: 8px 8px 0 0; background: #f8f9fa;">
                                @endif
                            </div>
                            <div class="card-body">
                                <h5 class="card-title text-primary">{{ $item->name }}</h5>
                                <p class="card-text"><strong>Item Name:</strong> {{ $item->item_name }}</p>
                                <p class="card-text"><strong>Description:</strong> {{ $item->description }}</p>
                                <p class="card-text"><strong>Last Seen Location:</strong> {{ $item->location }}</p>
                                <p class="card-text"><strong>Contact Info:</strong> {{ $item->contact_info }}</p>
                                @auth
                                <div class="d-flex justify-content-center mt-3">
                                    <button type="button" class="btn btn-success btn-sm me-2" data-bs-toggle="modal" data-bs-target="#referenceModal-{{ $item->id }}">
                                        Edit
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $item->id }}">
                                        Delete
                                    </button>
                                </div>
                                @endauth
                            </div>
                        </div>
                    </div>

                    <!-- Reference ID Modal -->
                    @auth
                    <div class="modal fade" id="referenceModal-{{ $item->id }}" tabindex="-1" aria-labelledby="referenceModalLabel-{{ $item->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="referenceModalLabel-{{ $item->id }}">Enter Reference ID</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('lost.verifyReference', $item->id) }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="reference_id" class="form-label">Reference ID</label>
                                            <input type="text" class="form-control" id="reference_id" name="reference_id" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100">Verify</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Reference ID Modal -->
                    <div class="modal fade" id="deleteModal-{{ $item->id }}" tabindex="-1" aria-labelledby="deleteModalLabel-{{ $item->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel-{{ $item->id }}">Enter Reference ID to Delete</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('lost.verifyDeleteReference', $item->id) }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="delete_reference_id" class="form-label">Reference ID</label>
                                            <input type="text" class="form-control" id="delete_reference_id" name="reference_id" required>
                                        </div>
                                        <button type="submit" class="btn btn-danger w-100">Verify and Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endauth
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function() {
    // Add Lost Item via Ajax
    $('#lostItemForm').on('submit', function(e) {
        e.preventDefault();
        let form = $(this);
        let formData = new FormData(this);
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#lostFormModal').modal('hide');
                form[0].reset();
                location.reload(); // For simplicity, reload. For full Ajax, update DOM here.
            },
            error: function(xhr) {
                alert('Error adding lost item.');
            }
        });
    });

    // Edit Lost Item via Ajax
    $('form[id^="editLostItemForm-"]').on('submit', function(e) {
        e.preventDefault();
        let form = $(this);
        let formData = new FormData(this);
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('.modal').modal('hide');
                alert('Lost item updated successfully.');
                location.reload(); // For simplicity, reload. For full Ajax, update DOM here.
            },
            error: function(xhr) {
                alert('Error editing lost item.');
            }
        });
    });

    // Delete Lost Item via Ajax
    $('form[id^="deleteLostItemForm-"]').on('submit', function(e) {
        e.preventDefault();
        let form = $(this);
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                $('.modal').modal('hide');
                alert('Lost item deleted successfully.');
                location.reload(); // For simplicity, reload. For full Ajax, remove item from DOM.
            },
            error: function(xhr) {
                alert('Error deleting lost item.');
            }
        });
    });
});
</script>
@endsection
