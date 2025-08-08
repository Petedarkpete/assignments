@extends('layouts.page')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/confirm_details.css') }}?v={{ time() }}">
@endpush

@section('content')
<main id="main" class="main">
<div class=" page-loading">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-enhanced">
                <p style="font-size: 1rem; margin: 0;">{{ session('success') }}</p>
            </div>
        @endif

        <div class="confirm-card">
            <!-- Header Section -->
            <div class="confirm-header">
                {{-- <div class="confirm-icon">
                    📝
                </div> --}}
                <h1 class="confirm-title">Review Assignment Details</h1>
                <p class="confirm-subtitle">Please review the information below before confirming submission</p>
            </div>

            <!-- Assignment Details -->
            <div class="assignment-details">
                <!-- Basic Information Section -->
                <div class="detail-section">
                    <h3 class="section-title">
                        <span class="section-icon">📋</span>
                        Basic Information
                    </h3>
                    <div class="detail-grid">
                        <div class="detail-item">
                            <div class="detail-label">
                                📝 Assignment Title
                            </div>
                            <div class="detail-value">{{ $assignment->title ?? 'Math Homework - Chapter 5' }}</div>
                        </div>
                        <div class="detail-item date">
                            <div class="detail-label">
                                📅 Due Date
                            </div>
                            <div class="detail-value">
                                {{ isset($assignment->due_date) ? \Carbon\Carbon::parse($assignment->due_date)->format('F j, Y') : 'January 15, 2024' }}
                            </div>
                        </div>
                        <div class="detail-item subject">
                            <div class="detail-label">
                                📚 Subject
                            </div>
                            <div class="detail-value">{{ $assignment->subject->name ?? 'Mathematics' }}</div>
                        </div>
                        <div class="detail-item class">
                            <div class="detail-label">
                                🏫 Class
                            </div>
                            <div class="detail-value">{{ $assignment->class->label ?? 'Grade 10 A' }}</div>
                        </div>
                    </div>
                </div>

                <!-- Description Section -->
                <div class="detail-section">
                    <h3 class="section-title">
                        <span class="section-icon">📄</span>
                        Assignment Description
                    </h3>
                    <div class="description-box">
                        {{ $assignment->description ?? 'Complete exercises 1-20 from Chapter 5: Algebra Fundamentals. Show all working steps and provide detailed explanations for word problems. Use proper mathematical notation and submit neat, organized work.' }}
                    </div>
                </div>

                <!-- Attachments & Resources Section -->
                @if(($assignment->file ?? false) || ($assignment->external_link ?? false))
                <div class="detail-section">
                    <h3 class="section-title">
                        <span class="section-icon">📎</span>
                        Attachments & Resources
                    </h3>
                    <div class="detail-grid">
                        @if($assignment->file ?? false)
                        <div class="detail-item">
                            <div class="detail-label">
                                📁 Attached File
                            </div>
                            <div class="file-preview">
                                <div class="file-icon">📄</div>
                                <div>
                                    <div class="detail-value">{{ basename($assignment->file) }}</div>
                                    <small class="text-muted">{{ number_format(filesize(storage_path('app/public/' . $assignment->file)) / 1024, 2) }} KB</small>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($assignment->external_link ?? false)
                        <div class="detail-item">
                            <div class="detail-label">
                                🔗 External Resource
                            </div>
                            <div class="link-preview">
                                <a href="{{ $assignment->external_link }}" target="_blank">
                                    {{ $assignment->external_link }}
                                </a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Assignment Metadata -->
                <div class="detail-section">
                    <h3 class="section-title">
                        <span class="section-icon">ℹ️</span>
                        Assignment Metadata
                    </h3>
                    <div class="detail-grid">
                        <div class="detail-item">
                            <div class="detail-label">
                                👨‍🏫 Created By
                            </div>
                            <div class="detail-value">{{ $assignment->teacher->name ?? auth()->user()->name }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">
                                📅 Created Date
                            </div>
                            <div class="detail-value">
                                {{ isset($assignment->created_at) ? $assignment->created_at->format('F j, Y \a\t g:i A') : now()->format('F j, Y \a\t g:i A') }}
                            </div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">
                                🆔 Assignment ID
                            </div>
                            <div class="detail-value">#{{ $assignment->id ?? 'ASG-' . str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT) }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">
                                📊 Status
                            </div>
                            <div class="detail-value" style="color: #f39c12; font-weight: 700;">Pending Confirmation</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <form action="{{ route('assignments.confirm', $assignment->id ?? 1) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-confirm">
                        ✓ Confirm & Submit Assignment
                    </button>
                </form>

                <a href="{{ route('assignments.edit', $assignment->id ?? 1) }}" class="btn btn-edit">
                    ✏️ Edit Assignment Details
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add smooth scrolling and animations
    const sections = document.querySelectorAll('.detail-section');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.style.animation = `slideInUp 0.6s ease-out forwards`;
                }, index * 100);
            }
        });
    }, {
        threshold: 0.1
    });

    sections.forEach(section => {
        section.style.opacity = '0';
        section.style.transform = 'translateY(30px)';
        observer.observe(section);
    });

    // Add confirmation dialog
    document.querySelector('.btn-confirm').addEventListener('click', function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Confirm Assignment Submission?',
            text: 'Once confirmed, this assignment will be published and visible to students.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Confirm!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                this.closest('form').submit();
            }
        });
    });
});
</script>
@endpush

@endsection
