<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('tasks/general.section_label') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="w-1/2 mx-auto border rounded-lg shadow border-cyan-700 shadow-cyan-500">
                        @include('tasks.form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
