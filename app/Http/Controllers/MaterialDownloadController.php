<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MaterialDownloadController extends Controller
{
    public function download(Material $material): StreamedResponse
    {
        $material->loadMissing('meeting');
        abort_unless($material->meeting && $material->meeting->is_open, 404);

        abort_unless(Storage::disk('local')->exists($material->stored_path), 404);

        return Storage::disk('local')->download(
            $material->stored_path,
            $material->original_name
        );
    }
}
