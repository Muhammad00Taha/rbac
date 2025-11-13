<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Users
        </h2>
    </x-slot>

    @if(session('status'))
        <div data-success-message="{{ session('status') }}" style="display: none;"></div>
    @endif

    @if(session('error'))
        <div data-error-message="{{ session('error') }}" style="display: none;"></div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-medium">User Directory</h3>
                        
                        @can('create', \App\Models\User::class)
                            <a
                                href="{{ route('users.create') }}"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            >
                                Create User
                            </a>
                        @endcan
                    </div>

                    @php
                        $dataTableLanguage = [
                            'search' => 'Search:',
                            'lengthMenu' => 'Show _MENU_ entries',
                            'info' => 'Showing _START_ to _END_ of _TOTAL_ users',
                            'infoEmpty' => 'No users available',
                            'infoFiltered' => '(filtered from _MAX_ total users)',
                            'zeroRecords' => 'No matching users found',
                            'processing' => 'Loading...',
                        ];
                    @endphp

                    <table
                        id="users-table"
                        data-source="{{ route('users.index') }}"
                        data-language='@json($dataTableLanguage)'
                        class="display"
                        style="width:100%"
                    >
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>