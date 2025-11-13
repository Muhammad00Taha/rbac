<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Services\ClassService;
use App\Services\SectionService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class ClassController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(
        private ClassService $classService,
        private SectionService $sectionService
    ) {
    }

    /**
     * Display a listing of classes.
     */
    public function index(Request $request): View|JsonResponse
    {
        // Check authorization using ClassPolicy
        Gate::authorize('viewAny', ClassModel::class);

        if ($request->ajax()) {
            $query = ClassModel::query()->with('section')->select('classes.*');

            return DataTables::eloquent($query)
                ->addColumn('section_name', static function (ClassModel $class): string {
                    return view('classes.partials.section', compact('class'))->render();
                })
                ->addColumn('actions', static function (ClassModel $class): string {
                    return view('classes.partials.actions', compact('class'))->render();
                })
                ->editColumn('class_name', static function (ClassModel $class): string {
                    return view('classes.partials.name', compact('class'))->render();
                })
                ->rawColumns(['class_name', 'section_name', 'actions'])
                ->toJson();
        }

        return view('classes.index');
    }

    /**
     * Show the form for creating a new class.
     */
    public function create(): View
    {
        // Check authorization using ClassPolicy
        Gate::authorize('create', ClassModel::class);

        return view('classes.create');
    }

    /**
     * Store a newly created class in storage.
     */
    public function store(Request $request)
    {
        // Check authorization using ClassPolicy
        Gate::authorize('create', ClassModel::class);

        $validated = $request->validate([
            'class_name' => ['required', 'string', 'max:255'],
            'section_id' => ['required', 'integer', 'exists:sections,id'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        // Use ClassService to create the class
        $class = $this->classService->createClass($validated);

        return redirect()->route('classes.index')->with('status', 'Class created successfully.');
    }

    /**
     * Display the specified class.
     */
    public function show(ClassModel $class): View
    {
        // Check authorization using ClassPolicy
        Gate::authorize('view', $class);

        return view('classes.show', [
            'class' => $class,
        ]);
    }

    /**
     * Show the form for editing the specified class.
     */
    public function edit(ClassModel $class): View
    {
        // Check authorization using ClassPolicy
        Gate::authorize('update', $class);

        return view('classes.edit', [
            'class' => $class,
        ]);
    }

    /**
     * Update the specified class in storage.
     */
    public function update(Request $request, ClassModel $class)
    {
        // Check authorization using ClassPolicy
        Gate::authorize('update', $class);

        $validated = $request->validate([
            'class_name' => ['required', 'string', 'max:255'],
            'section_id' => ['required', 'integer', 'exists:sections,id'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        // Use ClassService to update the class
        $this->classService->updateClass($class, $validated);

        return redirect()->route('classes.index')->with('status', 'Class updated successfully.');
    }

    /**
     * Remove the specified class from storage.
     */
    public function destroy(ClassModel $class)
    {
        // Check authorization using ClassPolicy
        Gate::authorize('delete', $class);

        // Use ClassService to delete the class
        $this->classService->deleteClass($class);

        return redirect()->route('classes.index')->with('status', 'Class deleted successfully.');
    }

    /**
     * Get sections for Select2 AJAX.
     */
    public function getSections(Request $request): JsonResponse
    {
        try {
            $search = $request->get('q', '');
            $page = $request->get('page', 1);
            $perPage = 10;

            $query = \App\Models\Section::query();

            if ($search) {
                $query->where('name', 'like', "%{$search}%");
            }

            $sections = $query->paginate($perPage, ['*'], 'page', $page);

            return response()->json([
                'results' => $sections->map(fn ($section) => [
                    'id' => $section->id,
                    'text' => $section->name,
                ])->values(),
                'pagination' => [
                    'more' => $sections->hasMorePages(),
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'results' => [],
                'pagination' => ['more' => false],
                'error' => $e->getMessage(),
            ]);
        }
    }
}

