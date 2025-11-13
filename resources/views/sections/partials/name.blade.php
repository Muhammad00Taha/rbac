@can('view', $section)
    <a href="{{ route('sections.show', $section) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">
        {{ $section->name }}
    </a>
@else
    {{ $section->name }}
@endcan

