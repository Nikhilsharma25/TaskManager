@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Task</h1>
    
    <form action="{{ route('tasks.update', $task->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('Put')

        <!-- Title -->
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $task->title) }}" required>
            @error('title')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <!-- Description -->
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description', $task->description) }}</textarea>
            @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <!-- Status -->
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select id="status" name="status" class="form-select @error('status') is-invalid @enderror">
                <option value="pending" {{ old('status', $task->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="completed" {{ old('status', $task->status) == 'completed' ? 'selected' : '' }}>Completed</option>
            </select>
            @error('status')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <!-- Due Date -->
        <div class="mb-3">
            <label for="due_date" class="form-label">Due Date</label>
            <input type="date" id="due_date" name="due_date" class="form-control @error('due_date') is-invalid @enderror" value="{{ old('due_date', $task->due_date) }}" required>
            @error('due_date')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <!-- File Attachment (optional) -->
        <div class="mb-3">
            <label for="file" class="form-label">Attachment</label>
            <input type="file" id="file" name="file" class="form-control @error('file') is-invalid @enderror">
            <small class="form-text text-muted">Accepted file types: jpg, png, pdf, docx (Max size: 2MB)</small>
            @error('file')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            @if ($task->file_path)
                <p><strong>Current File:</strong> <a href="{{ Storage::url($task->file_path) }}" target="_blank">{{ basename($task->file_path) }}</a></p>
            @endif
        </div>

        <!-- Submit Button -->
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Update Task</button>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
