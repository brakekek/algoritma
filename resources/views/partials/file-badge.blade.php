@php
    $ext = strtolower(pathinfo($material->original_name, PATHINFO_EXTENSION));
    $kind = match (true) {
        $ext === 'pdf' => 'pdf',
        in_array($ext, ['ppt', 'pptx'], true) => 'slide',
        in_array($ext, ['doc', 'docx', 'odt', 'txt'], true) => 'doc',
        in_array($ext, ['zip', '7z'], true) => 'zip',
        default => 'code',
    };
@endphp
<span class="ext" data-kind="{{ $kind }}" aria-hidden="true">{{ $ext !== '' ? $ext : 'file' }}</span>
