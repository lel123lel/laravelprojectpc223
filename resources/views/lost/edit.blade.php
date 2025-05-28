@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Lost Item</h2>
    <form id="editLostItemForm" action="{{ route('lost.update', $lostItem->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $lostItem->name }}" required>
        </div>
        <div class="mb-3">
            <label for="student_id" class="form-label">Student ID Number</label>
            <input type="text" class="form-control" id="student_id" name="student_id" value="{{ $lostItem->student_id }}" required>
        </div>
        <div class="mb-3">
            <label for="item_name" class="form-label">Item Name</label>
            <input type="text" class="form-control" id="item_name" name="item_name" value="{{ $lostItem->item_name }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="4" required>{{ $lostItem->description }}</textarea>
        </div>
        <div class="mb-3">
            <label for="contact_info" class="form-label">Contact Information</label>
            <input type="text" class="form-control" id="contact_info" name="contact_info" value="{{ $lostItem->contact_info }}" required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Upload Picture</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
            @if($lostItem->image)
                <img src="{{ asset('storage/' . $lostItem->image) }}" alt="Current Image" class="img-fluid mt-2" style="max-height:100px;">
            @endif
        </div>
        <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <input type="text" class="form-control" id="location" name="location" value="{{ $lostItem->location }}" required>
        </div>
        {{-- Date and Time fields --}}
        @php
            $date = \Carbon\Carbon::parse($lostItem->date_lost)->format('Y-m-d');
            $time = \Carbon\Carbon::parse($lostItem->date_lost)->format('H:i');
        @endphp
        <div class="mb-3">
            <label for="date_lost" class="form-label">Date Lost</label>
            <input type="date" class="form-control" id="date_lost" name="date_lost_date" value="{{ $date }}" required>
        </div>
        <div class="mb-3">
            <label for="time_lost" class="form-label">Time Lost</label>
            <input type="time" class="form-control" id="time_lost" name="date_lost_time" value="{{ $time }}" required>
        </div>
        {{-- JS will combine these into a hidden date_lost field --}}
        <button type="submit" class="btn btn-primary w-100">Save Changes</button>
    </form>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('editLostItemForm').addEventListener('submit', function(e) {
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
