@can('view', $user)
    <a href="{{ route('users.show', $user) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">
        {{ $user->name }}
    </a>
@else
    {{ $user->name }}
@endcan

