<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\Meeting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    private const ALLOWED_MIMES = [
        'pdf', 'ppt', 'pptx', 'doc', 'docx', 'odt', 'txt',
        'zip', '7z', 'c', 'cpp', 'h', 'py', 'java', 'js', 'html', 'css',
    ];

    public function store(Request $request, Meeting $meeting): RedirectResponse
    {
        $request->validate([
            'materials' => ['required', 'array', 'min:1', 'max:10'],
            'materials.*' => ['required', 'file', 'max:20480', 'mimes:' . implode(',', self::ALLOWED_MIMES)],
        ]);

        foreach ($request->file('materials', []) as $file) {
            $path = $file->store('course-materials/' . $meeting->id, 'local');

            $meeting->materials()->create([
                'original_name' => basename($file->getClientOriginalName()),
                'stored_path' => $path,
                'mime_type' => $file->getMimeType() ?: 'application/octet-stream',
                'size_bytes' => $file->getSize(),
            ]);
        }

        return back()->with('success', 'Materi berhasil diunggah.');
    }

    public function destroy(Material $material): RedirectResponse
    {
        Storage::disk('local')->delete($material->stored_path);
        $material->delete();

        return back()->with('success', 'File materi berhasil dihapus.');
    }
}
