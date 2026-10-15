@extends('layouts.course')
@section('title', 'Materi Kuliah | Algoritma dan Dasar Pemrograman')
@section('content')
<section class="hero">
    <h1>Algoritma dan Dasar Pemrograman</h1>
    @if($meetings->isEmpty())
        <p class="lead">Pilih pertemuan untuk membaca deskripsi dan mengunduh materi perkuliahan.</p>
    @else
        <p class="lead">{{ $meetings->count() }} pertemuan sudah dibuka dengan total {{ $meetings->sum('materials_count') }} file materi. Pilih pertemuan untuk membaca deskripsi dan mengunduh materinya.</p>
    @endif
</section>

@if($meetings->isEmpty())
    <div class="panel empty">
        <h2>Belum ada materi yang dibuka</h2>
        <p>Materi akan muncul di halaman ini setelah dosen membuka pertemuan. Coba cek lagi nanti.</p>
    </div>
@else
    <h2 class="visually-hidden">Daftar pertemuan</h2>
    <ol class="flow">
    @foreach($meetings as $meeting)
        <li>
            <span class="node" aria-label="Pertemuan {{ $meeting->number }}">{{ $meeting->number }}</span>
            <article class="step">
                <h2>{{ $meeting->title }}</h2>
                <p class="desc">{{ \Illuminate\Support\Str::limit($meeting->description, 160) ?: 'Materi dan sumber belajar pertemuan ini.' }}</p>
                <div class="step-foot">
                    <span class="count">
                        <svg width="16" height="16" viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M5 2.5h6.5L16 7v10a.5.5 0 0 1-.5.5h-10A.5.5 0 0 1 5 17V2.5Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M11.5 2.5V7H16" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
                        {{ $meeting->materials_count > 0 ? $meeting->materials_count.' file materi' : 'Belum ada file' }}
                    </span>
                    <a class="btn" href="{{ route('meetings.show', $meeting) }}" aria-label="Buka materi pertemuan {{ $meeting->number }}: {{ $meeting->title }}">Buka materi</a>
                </div>
            </article>
        </li>
    @endforeach
    </ol>
@endif
@endsection
