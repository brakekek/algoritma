@extends('layouts.course')
@section('title', 'Dashboard Dosen')
@section('content')
@php($openCount = $meetings->where('is_open', true)->count())
<section class="hero compact">
    <h1>Dashboard dosen</h1>
    <p class="lead">
        @if($meetings->isEmpty())
            Kelola materi dan tentukan pertemuan mana yang bisa diakses mahasiswa.
        @else
            {{ $meetings->count() }} pertemuan: {{ $openCount }} Open dan {{ $meetings->count() - $openCount }} Hide. Hanya pertemuan Open yang tampil untuk mahasiswa.
        @endif
    </p>
</section>

<section class="panel" aria-labelledby="daftar-heading">
    <div class="panel-head">
        <h2 id="daftar-heading">Daftar pertemuan</h2>
        <a class="btn sm" href="{{ route('admin.meetings.create') }}">
            <svg width="16" height="16" viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M10 4v12M4 10h12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            Tambah pertemuan
        </a>
    </div>
    @if($meetings->isEmpty())
        <div class="empty">
            <h2>Belum ada pertemuan</h2>
            <p>Buat pertemuan pertama, lalu unggah materinya.</p>
            <a class="btn" href="{{ route('admin.meetings.create') }}">Tambah pertemuan</a>
        </div>
    @else
        <ul class="rows">
        @foreach($meetings as $meeting)
            <li class="row">
                <span class="node sm {{ $meeting->is_open ? '' : 'hidden-state' }}" aria-label="Pertemuan {{ $meeting->number }}">{{ $meeting->number }}</span>
                <div style="min-width:0">
                    <h2>{{ $meeting->title }}</h2>
                    <div class="muted">{{ $meeting->materials_count }} file materi</div>
                </div>
                <span class="pill" data-state="{{ $meeting->is_open ? 'open' : 'hide' }}">{{ $meeting->is_open ? 'Open' : 'Hide' }}</span>
                <div class="actions">
                    <a class="btn secondary sm" href="{{ route('admin.meetings.edit', $meeting) }}">Kelola</a>
                    <form method="POST" action="{{ route('admin.meetings.visibility', $meeting) }}">@csrf @method('PATCH')
                        <button class="btn sm {{ $meeting->is_open ? 'secondary' : '' }}" type="submit">{{ $meeting->is_open ? 'Hide' : 'Open' }}</button>
                    </form>
                    <form method="POST" action="{{ route('admin.meetings.destroy', $meeting) }}" onsubmit="return confirm('Hapus pertemuan beserta semua file?')">@csrf @method('DELETE')
                        <button class="btn quiet-danger sm" type="submit">Hapus</button>
                    </form>
                </div>
            </li>
        @endforeach
        </ul>
    @endif
</section>
@endsection
