@php
    $roleNames = collect($roles ?? [])
        ->filter()
        ->map(fn ($role) => (string) $role)
        ->values();
@endphp

@if ($roleNames->isEmpty())
    <span class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600">
        N/A
    </span>
@else
    <div class="flex flex-wrap gap-2 justify-start">
        @foreach ($roleNames as $role)
            <span
                class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold text-indigo-600 bg-indigo-50 border border-transparent hover:bg-indigo-100 transition"
            >
                {{ __($role) }}
            </span>
        @endforeach
    </div>
@endif


