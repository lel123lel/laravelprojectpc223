<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Lost & Found</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1a2233 0%, #28416e 100%) fixed;
            color: #f1f1f1;
            min-height: 100vh;
        }
        .navbar {
            background: #22325a !important;
        }
        .navbar .navbar-brand,
        .navbar .navbar-nav .nav-link {
            color: #f1f1f1 !important;
        }
        .navbar .navbar-nav .nav-link.active {
            color: #4b6fae !important;
            font-weight: 600;
        }
        .navbar .navbar-nav .nav-link:hover {
            color: #28416e !important;
        }
        .btn-primary {
            background-color: #28416e;
            border-color: #28416e;
            color: #f1f1f1;
        }
        .btn-primary:hover, .btn-primary:focus {
            background-color: #3a5a99;
            border-color: #3a5a99;
            color: #f1f1f1;
        }
        .btn-outline-secondary {
            color: #28416e;
            border-color: #28416e;
        }
        .btn-outline-secondary:hover, .btn-outline-secondary:focus {
            background-color: #28416e;
            color: #f1f1f1;
        }
        .card {
            background: #22325a;
            color: #f1f1f1;
            border: none;
            border-radius: 1rem;
            box-shadow: 0 2px 16px rgba(40,65,110,0.15);
        }
        .card-img-container {
            position: relative;
            height: 250px;
            width: 100%;
            background-color: #1a2233;
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 1px solid #28416e;
        }
        .card-img-top {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px 8px 0 0;
        }
        .card-body {
            min-height: 220px;
            padding-bottom: 2.5rem;
            color: #f1f1f1;
        }
        .card-body .d-flex.gap-2 {
            gap: 1.25rem !important;
            margin-top: 1.25rem !important;
        }
        .form-control {
            background: #1a2233;
            color: #f1f1f1;
            border: 1px solid #28416e;
        }
        .form-control:focus {
            background: #22325a;
            color: #f1f1f1;
            border-color: #4b6fae;
            box-shadow: 0 0 0 0.2rem rgba(40,65,110,0.15);
        }
        ::placeholder {
            color: #b6c6e3 !important;
            opacity: 1;
        }
        /* For Firefox */
        input.form-control::-moz-placeholder {
            color: #b6c6e3 !important;
            opacity: 1;
        }
        /* For Internet Explorer */
        input.form-control:-ms-input-placeholder {
            color: #b6c6e3 !important;
        }
        /* For Edge */
        input.form-control::-ms-input-placeholder {
            color: #b6c6e3 !important;
        }
        /* For Chrome, Safari, Opera */
        input.form-control::placeholder {
            color: #b6c6e3 !important;
            opacity: 1;
        }
        .modal-content {
            background: #22325a;
            color: #f1f1f1;
            border-radius: 1rem;
        }
        .modal-header {
            background: #28416e;
            color: #f1f1f1;
            border-radius: 1rem 1rem 0 0;
            border-bottom: none;
        }
        .btn-close {
            filter: invert(1) grayscale(1) brightness(1.5);
        }
        .alert {
            background: #28416e;
            color: #f1f1f1;
            border: none;
        }
        h1, h2, h3, h4, h5, h6, label, .card-title, .card-text, .modal-title, .form-label, .btn, .navbar-brand, .nav-link, p, span, strong {
            color: #f1f1f1 !important;
        }
        .text-primary {
            color: #4b6fae !important;
        }
        .text-muted {
            color: #b6c6e3 !important;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light w-100 mb-4">
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
                            <button type="submit" class="btn btn-danger" style="color:#fff; font-weight:600;">
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

        <!-- Search Form -->
        <form method="GET" action="{{ route('admin') }}" class="mb-4">
            <div class="input-group" style="max-width: 400px; margin: 0 auto;">
                <input type="text" name="search" class="form-control" placeholder="Search by Item Name or Reference ID" value="{{ request('search') }}">
                <button class="btn btn-primary" type="submit">Search</button>
                @if(request('search'))
                    <a href="{{ route('admin') }}" class="btn btn-outline-secondary">Clear</a>
                @endif
            </div>
        </form>
        <!-- End Search Form -->

        @if($lostItems->isEmpty())
            <p class="text-center text-muted">No lost items reported yet.</p>
        @else
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @foreach($lostItems as $item)
                    <div class="col">
                        <div class="card shadow-sm h-100 position-relative">
                            @if(isset($item->status) && $item->status === 'found')
                                <span class="position-absolute top-0 end-0 m-2" title="Item Found">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#28a745" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                                        <circle cx="8" cy="8" r="8" fill="#fff"/>
                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM6.97 11.03a.75.75 0 0 0 1.07 0l3.992-3.992a.75.75 0 1 0-1.06-1.06L7.5 9.44 6.03 7.97a.75.75 0 1 0-1.06 1.06l1.997 1.997z"/>
                                    </svg>
                                </span>
                            @endif
                            <div class="card-img-container">
    @if($item->image)
        <img src="{{ asset('storage/' . $item->image) }}"
             class="card-img-top"
             alt="{{ $item->item_name }}"
             data-bs-toggle="modal"
             data-bs-target="#imageModal-{{ $item->id }}"
             style="cursor:pointer; max-height: 240px; max-width: 100%; object-fit: contain;">
    @else
        <img src="{{ asset('storage/no-image.png') }}"
             class="card-img-top"
             alt="No Image"
             data-bs-toggle="modal"
             data-bs-target="#imageModal-{{ $item->id }}"
             style="cursor:pointer; max-height: 240px; max-width: 100%; object-fit: contain;">
    @endif
</div>
<div class="modal fade" id="imageModal-{{ $item->id }}" tabindex="-1" aria-labelledby="imageModalLabel-{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-transparent border-0 position-relative p-0">
            <div class="modal-body text-center p-0 position-relative" style="display: flex; justify-content: center; align-items: center;">
                <div style="display: inline-block; position: relative;">
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
                         style="max-width: 100%; max-height: 80vh; border-radius: 12px; box-shadow: 0 4px 24px rgba(0,0,0,0.25); background: #1a2233; display: block;">
                </div>
            </div>
        </div>
    </div>
</div>
                            <div class="card-body">
                                <h5 class="card-title text-primary">{{ $item->name }}</h5>
                                <p class="card-text"><strong>Item Name:</strong> {{ $item->item_name }}</p>
                                <p class="card-text"><strong>Description:</strong> {{ $item->description }}</p>
                                <p class="card-text"><strong>Date Lost:</strong> {{ \Carbon\Carbon::parse($item->date_lost)->format('F d, Y h:i A') }}</p>
                                <div class="d-flex justify-content-center gap-2 mt-3">
                                    {{-- Replace the Edit button in the button row with this improved version --}}
                                    <a href="{{ route('lost.edit', $item->id) }}" class="btn btn-primary btn-sm d-flex align-items-center px-3 py-2" style="font-weight:600;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square me-2" viewBox="0 0 16 16">
                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706l-1 1a.5.5 0 0 1-.708 0l-1-1a.5.5 0 1 1 .708-.708l.646.647.646-.647a.5.5 0 0 1 .708 0z"/>
                                            <path d="M13.5 3.207l-8 8V13.5h2.293l8-8-2.293-2.293zm-7.854 8.854A.5.5 0 0 1 5 12.5v-1.293l8-8L14.293 4.5l-8 8z"/>
                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-7a.5.5 0 0 0-1 0v7a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5h7a.5.5 0 0 0 0-1h-7A1.5 1.5 0 0 0 1 2.5v11z"/>
                                        </svg>
                                        Edit
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $item->id }}">
                                        Delete
                                    </button>
                                    @if(!isset($item->status) || $item->status !== 'found')
                                        <button type="button" class="btn btn-warning btn-sm mark-found-btn" data-id="{{ $item->id }}">
                                            Mark as Found
                                        </button>
                                        <span class="d-inline-flex align-items-center ms-2">
                                            <span class="btn btn-warning btn-sm" style="pointer-events: none; cursor: default; color: #b45309; background-color: #facc15; border-color: #facc15; font-weight: 600;">
                                                Item Not Found
                                            </span>
                                        </span>
                                    @else
                                        <span class="d-inline-flex align-items-center ms-2">
                                            <span class="btn btn-success btn-sm" style="pointer-events: none; cursor: default; font-weight: 600;">
                                                Item Found
                                            </span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#28a745" class="bi bi-check-circle-fill ms-2" viewBox="0 0 16 16" style="vertical-align: middle;">
                                                <circle cx="8" cy="8" r="8" fill="#fff"/>
                                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM6.97 11.03a.75.75 0 0 0 1.07 0l3.992-3.992a.75.75 0 1 0-1.06-1.06L7.5 9.44 6.03 7.97a.75.75 0 1 0-1.06 1.06l1.997 1.997z"/>
                                            </svg>
                                        </span>
                                    @endif
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

    $(function() {
        // Mark as Found via Ajax (use event delegation!)
        $(document).on('click', '.mark-found-btn', function() {
            let btn = $(this);
            let itemId = btn.data('id');
            $.ajax({
                url: '/lost/' + itemId + '/ajax-mark-found',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if(response.success) {
                        // Remove the Item Not Found badge if present
                        btn.next('span.d-inline-flex').remove();
                        // Replace the button with the "Item Found" badge and check icon
                        btn.replaceWith(
                            `<span class="d-inline-flex align-items-center ms-2">
                                <span class="btn btn-success btn-sm" style="pointer-events: none; cursor: default; font-weight: 600;">
                                    Item Found
                                </span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#28a745" class="bi bi-check-circle-fill ms-2" viewBox="0 0 16 16" style="vertical-align: middle;">
                                    <circle cx="8" cy="8" r="8" fill="#fff"/>
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM6.97 11.03a.75.75 0 0 0 1.07 0l3.992-3.992a.75.75 0 1 0-1.06-1.06L7.5 9.44 6.03 7.97a.75.75 0 1 0-1.06 1.06l1.997 1.997z"/>
                                </svg>
                            </span>`
                        );
                        showCustomAlert('Item marked as found.', 'success');
                        // Optionally, update the top-right green badge in the card if you want to reflect instantly
                        let card = btn.closest('.card');
                        if (card.find('.position-absolute.top-0.end-0.m-2').length === 0) {
                            card.prepend(
                                `<span class="position-absolute top-0 end-0 m-2" title="Item Found">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#28a745" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                                        <circle cx="8" cy="8" r="8" fill="#fff"/>
                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM6.97 11.03a.75.75 0 0 0 1.07 0l3.992-3.992a.75.75 0 1 0-1.06-1.06L7.5 9.44 6.03 7.97a.75.75 0 1 0-1.06 1.06l1.997 1.997z"/>
                                    </svg>
                                </span>`
                            );
                        }
                    } else {
                        showCustomAlert('Failed to mark item as found. Please try again.', 'danger');
                    }
                },
                error: function() {
                    showCustomAlert('An error occurred. Please try again.', 'danger');
                }
            });
        });

      
    });
</script>
</body>
</html>