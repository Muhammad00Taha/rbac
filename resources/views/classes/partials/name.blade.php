@can('view', $class)
    <a href="{{ route('classes.show', $class) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">
        {{ $class->class_name }}
    </a>
@else
    {{ $class->class_name }}
@endcan

