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
        <p class="lead">Report your lost items and we'll reconnect you with your belongings.</p>
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
                        <div class="mb-3">
                            <label for="date_lost" class="form-label">Date Lost</label>
                            <input type="date" class="form-control" id="date_lost" name="date_lost_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="time_lost" class="form-label">Time Lost</label>
                            <input type="time" class="form-control" id="time_lost" name="date_lost_time" required>
                        </div>
                        <!-- JS will combine these into a hidden date_lost field -->
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
                                         class="card-img-top lost-img"
                                         alt="{{ $item->item_name }}"
                                         data-bs-toggle="modal"
                                         data-bs-target="#imageModal-{{ $item->id }}"
                                         style="max-height: 240px; max-width: 100%; object-fit: contain; display: block; margin: auto; border-radius: 8px 8px 0 0; box-shadow: 0 2px 8px rgba(0,0,0,0.08); background: #f8f9fa; cursor:pointer;">
                                @else
                                    <img src="{{ asset('storage/no-image.png') }}"
                                         class="card-img-top lost-img"
                                         alt="No Image"
                                         data-bs-toggle="modal"
                                         data-bs-target="#imageModal-{{ $item->id }}"
                                         style="max-height: 240px; max-width: 100%; object-fit: contain; display: block; margin: auto; border-radius: 8px 8px 0 0; background: #f8f9fa; cursor:pointer;">
                                @endif
                            </div>
                            <div class="card-body">
                                <h5 class="card-title text-primary">{{ $item->name }}</h5>
                                <p class="card-text"><strong>Item Name:</strong> {{ $item->item_name }}</p>
                                <p class="card-text"><strong>Description:</strong> {{ $item->description }}</p>
                                <p class="card-text"><strong>Last Seen Location:</strong> {{ $item->location }}</p>
                                <p class="card-text"><strong>Contact Info:</strong> {{ $item->contact_info }}</p>
                                <p class="card-text"><strong>Date Lost:</strong> {{ \Carbon\Carbon::parse($item->date_lost)->format('F d, Y h:i A') }}</p>
                                <div class="d-flex justify-content-center align-items-center mt-3 gap-2 flex-wrap">
                                    {{-- Edit Button (opens reference modal) --}}
                                    <button type="button" class="btn btn-success btn-lg me-2"
                                        data-bs-toggle="modal" data-bs-target="#referenceModal-{{ $item->id }}">
                                        Edit
                                    </button>
                                    {{-- Delete Button (opens delete modal) --}}
                                    <button type="button" class="btn btn-danger btn-lg me-2"
                                        data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $item->id }}">
                                        Delete
                                    </button>

                                    {{-- Status Badge and Icon --}}
                                    @if(isset($item->status) && $item->status === 'found')
                                        <span class="d-inline-flex align-items-center ms-2">
                                            <span class="btn btn-success btn-lg" style="pointer-events: none; cursor: default;">
                                                Item Found
                                            </span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="#28a745"
                                                class="bi bi-check-circle-fill ms-2" viewBox="0 0 16 16" style="vertical-align: middle;">
                                                <circle cx="8" cy="8" r="8" fill="#fff"/>
                                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM6.97 11.03a.75.75 0 0 0 1.07 0l3.992-3.992a.75.75 0 1 0-1.06-1.06L7.5 9.44 6.03 7.97a.75.75 0 1 0-1.06 1.06l1.997 1.997z"/>
                                            </svg>
                                        </span>
                                    @else
                                        <span class="d-inline-flex align-items-center ms-2">
                                            <span class="btn btn-warning btn-lg" style="pointer-events: none; cursor: default; color: #b45309; background-color: #facc15; border-color: #facc15; font-weight: 600;">
                                                Item Not Found
                                            </span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" class="bi bi-x-circle-fill ms-2"
                                                viewBox="0 0 16 16" style="vertical-align: middle;">
                                                <circle cx="8" cy="8" r="8" fill="#fff"/>
                                                <circle cx="8" cy="8" r="8" fill="#dc2626" fill-opacity="0.8"/>
                                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" fill="#000"/>
                                            </svg>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Reference ID Modal -->
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

                    {{-- Modal for image preview --}}
                    <div class="modal fade" id="imageModal-{{ $item->id }}" tabindex="-1" aria-labelledby="imageModalLabel-{{ $item->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content bg-transparent border-0 position-relative p-0">
                                <div class="modal-body text-center p-0 position-relative" style="display: flex; justify-content: center; align-items: center;">
                                    <div style="display: inline-block; position: relative;">
                                        {{-- Close button, sized and positioned relative to the image --}}
                                        <button type="button"
                                            class="d-flex align-items-center justify-content-center"
                                            data-bs-dismiss="modal" aria-label="Close"
                                            style="
                                                position: absolute;
                                                top: 12px;
                                                right: 12px;
                                                z-index: 10;
                                                background: #dc2626;
                                                border-radius: 50%;
                                                width: 38px;
                                                height: 38px;
                                                border: none;
                                                box-shadow: 0 2px 8px rgba(0,0,0,0.12);
                                                padding: 0;
                                                display: flex;
                                                align-items: center;
                                                justify-content: center;
                                            ">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 16 16" fill="none">
                                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" fill="#000"/>
                                            </svg>
                                        </button>
                                        <img src="{{ $item->image ? asset('storage/' . $item->image) : asset('storage/no-image.png') }}"
                                             alt="{{ $item->item_name }}"
                                             style="max-width: 100%; max-height: 80vh; border-radius: 12px; box-shadow: 0 4px 24px rgba(0,0,0,0.25); background: #fff; display: block;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Place this after @endforeach --}}
    <div class="modal fade" id="editLostItemModal" tabindex="-1" aria-labelledby="editLostItemModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="editLostItemModalContent">
                {{-- AJAX-loaded content goes here --}}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function() {
    // ADD lost item via AJAX
    $('#lostItemForm').on('submit', function(e) {
        e.preventDefault();
        let form = $(this)[0];
        let formData = new FormData(form);
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#lostFormModal').modal('hide');
                reloadLostItems();
                alert('Lost item reported successfully!');
                form.reset();
            },
            error: function(xhr) {
                alert('Error adding lost item.');
            }
        });
    });

    // DELETE lost item via AJAX
    $(document).on('submit', 'form[action*="verifyDeleteReference"]', function(e) {
        e.preventDefault();
        let form = $(this);
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                $('.modal').modal('hide');
                reloadLostItems();
                alert('Lost item deleted successfully!');
            },
            error: function() {
                alert('Error deleting lost item.');
            }
        });
    });

    // Handle Reference ID verification for Edit (show edit form in modal via AJAX)
    $(document).on('submit', 'form[action*="verifyReference"]', function(e) {
        e.preventDefault();
        let form = $(this);
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                $('.modal').modal('hide');
                $('#editLostItemModalContent').html(response);
                $('#editLostItemModal').modal('show');
            },
            error: function(xhr) {
                alert('Invalid Reference ID or error. Please try again.');
            }
        });
    });

    // EDIT lost item (submit edit form in modal, NO AJAX, just normal submit)
    $(document).on('submit', 'form[action*="lost/update"]', function() {
        // Let the form submit normally (no preventDefault, no AJAX)
        // The controller should redirect to lost.index after update
    });

    // Reload lost items list via AJAX
    function reloadLostItems() {
        $.get("{{ route('lost.index') }}", function(data) {
            let html = $(data).find('.container').eq(1).html();
            $('.container').eq(1).html(html);
        });
    }
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let now = new Date();
    let pad = n => n < 10 ? '0' + n : n;
    let formatted = now.getFullYear() + '-' +
        pad(now.getMonth() + 1) + '-' +
        pad(now.getDate()) + ' ' +
        pad(now.getHours()) + ':' +
        pad(now.getMinutes()) + ':' +
        pad(now.getSeconds());
    document.getElementById('date_lost').value = formatted;
});
</script>
<script>
document.getElementById('lostItemForm').addEventListener('submit', function(e) {
    let date = document.getElementById('date_lost').value;
    let time = document.getElementById('time_lost').value;
    if(date && time) {
        let combined = date + ' ' + time + ':00';
        let hidden = document.getElementById('combined_date_lost');
        if(!hidden) {
            hidden = document.createElement('input');
            hidden.type = 'hidden';
            hidden.name = 'date_lost';
            hidden.id = 'combined_date_lost';
            this.appendChild(hidden);
        }
        hidden.value = combined;
    }
});
</script>
@endsection
