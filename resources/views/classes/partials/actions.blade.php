<div class="flex justify-end items-center gap-2">
    @can('view', $class)
        <a
            href="{{ route('classes.show', $class) }}"
            class="inline-flex items-center px-3 py-1 text-xs font-semibold text-indigo-600 bg-indigo-50 border border-transparent rounded-full hover:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition"
        >
            {{ __('View') }}
        </a>
    @endcan

    @can('update', $class)
        <a
            href="{{ route('classes.edit', $class) }}"
            class="inline-flex items-center px-3 py-1 text-xs font-semibold text-gray-700 bg-gray-100 border border-transparent rounded-full hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 transition"
        >
            {{ __('Edit') }}
        </a>
    @endcan

    @can('delete', $class)
        <form method="POST" action="{{ route('classes.destroy', $class) }}" class="inline-flex" data-confirm-delete>
            @csrf
            @method('DELETE')
            <button
                type="submit"
                class="inline-flex items-center px-3 py-1 text-xs font-semibold text-red-600 bg-red-50 border border-transparent rounded-full hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition"
            >
                {{ __('Delete') }}
            </button>
        </form>
    @endcan
</div>

