<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MeetingController extends Controller
{
    public function index(): View
    {
        $meetings = Meeting::withCount('materials')
            ->orderBy('sort_order')->orderBy('number')->get();

        return view('admin.dashboard', compact('meetings'));
    }

    public function create(): View
    {
        return view('admin.meeting-form', ['meeting' => new Meeting()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['number'] . '-' . $data['title']);
        $data['is_open'] = $request->boolean('is_open');

        Meeting::create($data);

        return redirect()->route('admin.dashboard')->with('success', 'Pertemuan berhasil dibuat.');
    }

    public function edit(Meeting $meeting): View
    {
        $meeting->load('materials');
        return view('admin.meeting-form', compact('meeting'));
    }

    public function update(Request $request, Meeting $meeting): RedirectResponse
    {
        $data = $this->validated($request, $meeting);
        $data['slug'] = $this->uniqueSlug($data['number'] . '-' . $data['title'], $meeting->id);
        $data['is_open'] = $request->boolean('is_open');
        $meeting->update($data);

        return redirect()->route('admin.dashboard')->with('success', 'Pertemuan berhasil diperbarui.');
    }

    public function toggleVisibility(Request $request, Meeting $meeting): RedirectResponse
    {
        $meeting->update(['is_open' => ! $meeting->is_open]);

        return back()->with('success', 'Status pertemuan berhasil diubah menjadi ' . ($meeting->is_open ? 'Open.' : 'Hide.'));
    }

    public function destroy(Meeting $meeting): RedirectResponse
    {
        foreach ($meeting->materials as $material) {
            \Illuminate\Support\Facades\Storage::disk('local')->delete($material->stored_path);
            $material->delete();
        }
        $meeting->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Pertemuan dan seluruh materinya dihapus.');
    }

    private function validated(Request $request, ?Meeting $meeting = null): array
    {
        return $request->validate([
            'number' => ['required', 'integer', 'min:1', 'max:100', Rule::unique('meetings', 'number')->ignore($meeting?->id)],
            'title' => ['required', 'string', 'max:180'],
            'description' => ['nullable', 'string', 'max:5000'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:1000'],
        ]);
    }

    private function uniqueSlug(string $source, ?int $ignoreId = null): string
    {
        $base = Str::slug($source) ?: 'pertemuan';
        $slug = $base;
        $i = 2;

        while (Meeting::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }
}
