<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('errors/index.general_label') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="w-1/2 mx-auto border border-red-700 rounded-lg shadow shadow-red-500">

                        <div class="px-4 py-2.5 bg-red-200 rounded-none rounded-t-lg h-[60px] flex items-center">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-medium leading-none text-red-600">{{ __('errors/index.404.section_label') }}</h3>
                            </div>
                        </div>

                        <div class="p-4">
                            <div class="flex">
                                <div class="w-full">
                                    <p class="text-sm text-center text-red-500">:: <span class="italic">{{ __('errors/index.404.section_message') }}</span> ::</p>
                                </div>
                            </div>
                        </div>

                        <div class="h-4 px-4 py-2.5 flex rounded-none rounded-b-lg justify-end bg-red-200"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
