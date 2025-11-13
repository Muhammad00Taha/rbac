<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Services\SectionService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class SectionController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(private SectionService $sectionService)
    {
    }

    /**
     * Display a listing of sections.
     */
    public function index(Request $request): View|JsonResponse
    {
        // Check authorization using SectionPolicy
        Gate::authorize('viewAny', Section::class);

        if ($request->ajax()) {
            $query = Section::query()->select('sections.*');

            return DataTables::eloquent($query)
                ->addColumn('actions', static function (Section $section): string {
                    return view('sections.partials.actions', compact('section'))->render();
                })
                ->editColumn('name', static function (Section $section): string {
                    return view('sections.partials.name', compact('section'))->render();
                })
                ->rawColumns(['name', 'actions'])
                ->toJson();
        }

        return view('sections.index');
    }

    /**
     * Show the form for creating a new section.
     */
    public function create(): View
    {
        // Check authorization using SectionPolicy
        Gate::authorize('create', Section::class);

        return view('sections.create');
    }

    /**
     * Store a newly created section in storage.
     */
    public function store(Request $request)
    {
        // Check authorization using SectionPolicy
        Gate::authorize('create', Section::class);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:sections,name'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        // Use SectionService to create the section
        $section = $this->sectionService->createSection($validated);

        return redirect()->route('sections.index')->with('status', 'Section created successfully.');
    }

    /**
     * Display the specified section.
     */
    public function show(Section $section): View
    {
        // Check authorization using SectionPolicy
        Gate::authorize('view', $section);

        return view('sections.show', [
            'section' => $section,
        ]);
    }

    /**
     * Show the form for editing the specified section.
     */
    public function edit(Section $section): View
    {
        // Check authorization using SectionPolicy
        Gate::authorize('update', $section);

        return view('sections.edit', [
            'section' => $section,
        ]);
    }

    /**
     * Update the specified section in storage.
     */
    public function update(Request $request, Section $section)
    {
        // Check authorization using SectionPolicy
        Gate::authorize('update', $section);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:sections,name,' . $section->id],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        // Use SectionService to update the section
        $this->sectionService->updateSection($section, $validated);

        return redirect()->route('sections.index')->with('status', 'Section updated successfully.');
    }

    /**
     * Remove the specified section from storage.
     */
    public function destroy(Section $section)
    {
        // Check authorization using SectionPolicy
        Gate::authorize('delete', $section);

        // Use SectionService to delete the section
        $this->sectionService->deleteSection($section);

        return redirect()->route('sections.index')->with('status', 'Section deleted successfully.');
    }
}

