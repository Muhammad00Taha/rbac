<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Details') }}
        </h2>
    </x-slot>

    @if(session('status'))
        <div data-success-message="{{ session('status') }}" style="display: none;"></div>
    @endif

    @if(session('error'))
        <div data-error-message="{{ session('error') }}" style="display: none;"></div>
    @endif

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">{{ __('Name') }}</dt>
                            <dd class="mt-1 text-base text-gray-900">{{ $user->name }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">{{ __('Email') }}</dt>
                            <dd class="mt-1 text-base text-gray-900">{{ $user->email }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">{{ __('Roles') }}</dt>
                            <dd class="mt-1 text-base text-gray-900">
                                {{ $user->getRoleNames()->implode(', ') ?: __('N/A') }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">{{ __('Created At') }}</dt>
                            <dd class="mt-1 text-base text-gray-900">{{ $user->created_at?->toDayDateTimeString() }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-3">
                @can('update', $user)
                    <a
                        href="{{ route('users.edit', $user) }}"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    >
                        {{ __('Edit User') }}
                    </a>
                @endcan

                @can('delete', $user)
                    <form method="POST" action="{{ route('users.destroy', $user) }}" data-confirm-delete>
                        @csrf
                        @method('DELETE')
                        <x-danger-button>
                            {{ __('Delete User') }}
                        </x-danger-button>
                    </form>
                @endcan
            </div>
        </div>
    </div>
</x-app-layout>

