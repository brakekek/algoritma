@extends('layouts.course')
@section('title', $meeting->exists ? 'Edit Pertemuan' : 'Tambah Pertemuan')
@section('content')
<section class="hero compact">
    <nav class="crumbs" aria-label="Navigasi halaman">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span aria-hidden="true">/</span>
        <span aria-current="page">{{ $meeting->exists ? 'Pertemuan '.$meeting->number : 'Pertemuan baru' }}</span>
    </nav>
    <h1>{{ $meeting->exists ? 'Edit pertemuan '.$meeting->number : 'Tambah pertemuan' }}</h1>
    <p class="lead">Pertemuan berstatus Hide tidak tampil untuk mahasiswa.</p>
</section>

<section class="panel" aria-label="Data pertemuan">
    <div class="panel-body">
        <form method="POST" action="{{ $meeting->exists ? route('admin.meetings.update', $meeting) : route('admin.meetings.store') }}">
            @csrf
            @if($meeting->exists) @method('PUT') @endif

            <div class="two">
                <div class="field">
                    <label class="lbl" for="number">Nomor pertemuan</label>
                    <input id="number" name="number" type="number" min="1" max="100" value="{{ old('number', $meeting->number) }}" required>
                    <p class="hint">Angka 1–100, tidak boleh sama dengan pertemuan lain.</p>
                </div>
                <div class="field">
                    <label class="lbl" for="sort_order">Urutan tampil</label>
                    <input id="sort_order" name="sort_order" type="number" min="0" max="1000" value="{{ old('sort_order', $meeting->sort_order ?? 0) }}">
                    <p class="hint">Angka kecil tampil lebih dulu. Jika sama, diurutkan menurut nomor.</p>
                </div>
            </div>

            <div class="field">
                <label class="lbl" for="title">Judul pertemuan</label>
                <input id="title" name="title" value="{{ old('title', $meeting->title) }}" maxlength="180" required>
            </div>

            <div class="field">
                <label class="lbl" for="description">Deskripsi atau instruksi <span class="muted" style="font-weight:400">(opsional)</span></label>
                <textarea id="description" name="description" rows="5">{{ old('description', $meeting->description) }}</textarea>
            </div>

            <div class="field">
                <label class="switch">
                    <input type="checkbox" name="is_open" value="1" @checked(old('is_open', $meeting->is_open))>
                    <span class="track" aria-hidden="true"></span>
                    <span><strong>Open untuk mahasiswa</strong><small>Matikan untuk menyimpan sebagai Hide.</small></span>
                </label>
            </div>

            <div class="form-actions">
                <button class="btn" type="submit">Simpan pertemuan</button>
                <a class="btn secondary" href="{{ route('admin.dashboard') }}">Batal</a>
            </div>
        </form>
    </div>
</section>

@if($meeting->exists)
<section class="panel" aria-labelledby="upload-heading">
    <div class="panel-head"><h2 id="upload-heading">Materi pertemuan</h2><span class="muted small">{{ $meeting->materials->count() }} file</span></div>
    <div class="panel-body">
        <form method="POST" action="{{ route('admin.materials.store', $meeting) }}" enctype="multipart/form-data">
            @csrf
            <label class="drop" for="materials">
                <svg width="30" height="30" viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M10 13V4m0 0L6.5 7.5M10 4l3.5 3.5M4 13.5v2A1.5 1.5 0 0 0 5.5 17h9a1.5 1.5 0 0 0 1.5-1.5v-2" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <strong>Pilih file atau seret ke sini</strong>
                <span class="small muted">Maksimal 10 file sekali unggah, 20 MB per file.</span>
                <span class="small muted">PDF, PPT/PPTX, DOC/DOCX, ODT, TXT, ZIP/7Z, C/C++, Python, Java, JS, HTML, CSS</span>
                <input id="materials" name="materials[]" type="file" multiple required accept=".pdf,.ppt,.pptx,.doc,.docx,.odt,.txt,.zip,.7z,.c,.cpp,.h,.py,.java,.js,.html,.css">
            </label>
            <ul id="picked" class="picked" aria-live="polite"></ul>
            <p id="picked-note" class="picked-note" hidden></p>
            <div class="form-actions" style="margin-top:18px;padding-top:0;border-top:0">
                <button class="btn" type="submit">Unggah file</button>
            </div>
        </form>
    </div>

    <h3 class="visually-hidden">File yang sudah diunggah</h3>
    @if($meeting->materials->isEmpty())
        <div class="empty" style="border-top:1px solid var(--line)"><p>Belum ada file. Unggah file pertama di atas.</p></div>
    @else
        <ul class="files" style="border-top:1px solid var(--line)">
        @foreach($meeting->materials as $material)
            <li>
                @include('partials.file-badge', ['material' => $material])
                <div class="meta">
                    <span class="name">{{ $material->original_name }}</span>
                    <span class="muted small">{{ $material->formatted_size }}</span>
                </div>
                <form method="POST" action="{{ route('admin.materials.destroy', $material) }}" onsubmit="return confirm('Hapus file ini?')">@csrf @method('DELETE')
                    <button class="btn quiet-danger sm" type="submit">Hapus file</button>
                </form>
            </li>
        @endforeach
        </ul>
    @endif
</section>

@push('scripts')
<script>
(function () {
    var input = document.getElementById('materials');
    var list = document.getElementById('picked');
    var note = document.getElementById('picked-note');
    if (!input) return;
    input.addEventListener('change', function () {
        var files = Array.prototype.slice.call(input.files);
        list.innerHTML = '';
        files.forEach(function (f) {
            var li = document.createElement('li');
            var name = document.createElement('span');
            var size = document.createElement('span');
            name.textContent = f.name;
            size.textContent = (f.size / 1048576).toFixed(1) + ' MB';
            if (f.size > 20 * 1048576) { li.className = 'over'; size.textContent += ' (lebih dari 20 MB)'; }
            li.appendChild(name); li.appendChild(size); list.appendChild(li);
        });
        note.hidden = files.length <= 10;
        note.textContent = files.length > 10 ? 'Anda memilih ' + files.length + ' file. Maksimal 10 file sekali unggah.' : '';
    });
})();
</script>
@endpush
@endif
@endsection
