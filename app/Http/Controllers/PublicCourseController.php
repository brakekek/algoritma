<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use Illuminate\View\View;

class PublicCourseController extends Controller
{
    public function index(): View
    {
        $meetings = Meeting::query()
            ->where('is_open', true)
            ->withCount('materials')
            ->orderBy('sort_order')
            ->orderBy('number')
            ->get();

        return view('course.index', compact('meetings'));
    }

    public function show(Meeting $meeting): View
    {
        abort_unless($meeting->is_open, 404);
        $meeting->load('materials');

        return view('course.show', compact('meeting'));
    }
}
