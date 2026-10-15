@extends('layouts.course')
@section('title', 'Pertemuan '.$meeting->number.' | '.$meeting->title)
@section('content')
<section class="hero compact">
    <nav class="crumbs" aria-label="Navigasi halaman">
        <a href="{{ route('home') }}">Semua pertemuan</a>
        <span aria-hidden="true">/</span>
        <span aria-current="page">Pertemuan {{ $meeting->number }}</span>
    </nav>
    <h1>{{ $meeting->title }}</h1>
    @if($meeting->description)<p class="lead desc">{{ $meeting->description }}</p>@endif
</section>

<section class="panel" aria-labelledby="materi-heading">
    <div class="panel-head">
        <h2 id="materi-heading">Materi pembelajaran</h2>
        <span class="muted small">{{ $meeting->materials->count() }} file</span>
    </div>
    @if($meeting->materials->isEmpty())
        <div class="empty"><p>Belum ada file materi pada pertemuan ini. Cek lagi nanti.</p></div>
    @else
        <ul class="files">
        @foreach($meeting->materials as $material)
            <li>
                @include('partials.file-badge', ['material' => $material])
                <div class="meta">
                    <span class="name">{{ $material->original_name }}</span>
                    <span class="muted small">{{ $material->formatted_size }}</span>
                </div>
                <a class="btn sm" href="{{ route('materials.download', $material) }}" aria-label="Unduh {{ $material->original_name }}">
                    <svg width="16" height="16" viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M10 3v10m0 0 4-4m-4 4L6 9M4 16.5h12" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Unduh
                </a>
            </li>
        @endforeach
        </ul>
    @endif
</section>
@endsection
