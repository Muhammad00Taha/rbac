<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Section Details
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium mb-4">{{ $section->name }}</h3>

                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <span class="font-semibold text-gray-700">Name:</span>
                                <span class="text-gray-600">{{ $section->name }}</span>
                            </div>

                            <div>
                                <span class="font-semibold text-gray-700">Description:</span>
                                <span class="text-gray-600">{{ $section->description ?? 'N/A' }}</span>
                            </div>

                            <div>
                                <span class="font-semibold text-gray-700">Created At:</span>
                                <span class="text-gray-600">{{ $section->created_at?->format('M d, Y H:i') ?? 'N/A' }}</span>
                            </div>

                            <div>
                                <span class="font-semibold text-gray-700">Updated At:</span>
                                <span class="text-gray-600">{{ $section->updated_at?->format('M d, Y H:i') ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3">
                        <a
                            href="{{ route('sections.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"
                        >
                            Back to Sections
                        </a>

                        @can('update', $section)
                            <a
                                href="{{ route('sections.edit', $section) }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 focus:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            >
                                Edit
                            </a>
                        @endcan

                        @can('delete', $section)
                            <form method="POST" action="{{ route('sections.destroy', $section) }}" class="inline-flex" data-confirm-delete>
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                >
                                    Delete
                                </button>
                            </form>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

