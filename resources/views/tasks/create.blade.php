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
                        <div class="px-4 py-2.5 bg-blue-100 rounded-none rounded-t-lg h-[60px] flex items-center">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-medium leading-none">{{ __('tasks/index.form.create_section_label') }}</h3>
                            </div>
                        </div>

                        <div class="p-4">
                            {{-- <x-flash-messages :sessionType="'success'" :color="'green'" :title="'¡¡Éxito!!'" /> --}}

                            <div class="flex">
                                <div class="w-full">
                                    <label for="title" class="block text-base font-bold text-gray-700 dark:text-white">
                                        {{ __('tasks/index.form.title_label_input') }}
                                    </label>
                                    <input
                                        type="text" name="title" id="title"
                                        {{-- value="{{ old('title', $task->title) }}" --}}
                                        class="block w-full p-4 mt-2 bg-white border rounded-lg shadow-md border-cyan-200 focus:outline-none focus:border-slate-300 focus:shadow-cyan-200 focus:ring-cyan-300 focus:ring-1"
                                    />
                                    @error('title')
                                        <p class="text-xs italic text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="w-[16%] ml-7">
                                    <label for="completed" class="block text-base font-bold text-gray-700 dark:text-white">
                                        {{ __('tasks/index.form.completed_label_checkbox') }}
                                    </label>
                                    {{-- <input type="text" name="title" id="title"
                                        class="block w-full p-4 mt-2 bg-white border rounded-lg shadow-md border-cyan-200 focus:outline-none focus:border-slate-300 focus:shadow-cyan-200 focus:ring-cyan-300 focus:ring-1" /> --}}

                                    <div class="flex items-center justify-center mt-2 h-2/3">
                                        <label class="switch">
                                            <input type="checkbox" name="completed" id="completed" checked>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    @error('completed')
                                    <p class="text-xs italic text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-4">
                                <label for="description" class="block text-base font-bold text-gray-700 dark:text-white">
                                    {{ __('tasks/index.form.description_label_input') }}
                                </label>
                                {{-- dentro de la etiqueta {{ old('description', $category->description) }} --}}
                                <textarea name="description" id="description"
                                    class="w-full p-4 mt-2 bg-white border rounded-lg shadow-md border-cyan-200 focus:outline-none focus:border-slate-300 focus:shadow-cyan-200 focus:ring-cyan-300 focus:ring-1"></textarea>
                                @error('description')
                                <p class="text-xs italic text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="px-4 py-2.5 flex rounded-none rounded-b-lg justify-end bg-blue-100">
                            <a href="{{ route('tasks.index') }}" class="px-4 py-2 font-bold text-white bg-gray-700 rounded hover:bg-gray-500" title="{{ __('tasks/index.button.cancel') }}">
                                {{ __('tasks/index.button.cancel') }}
                            </a>

                            <a href="#" class="px-4 py-2 font-bold text-white rounded ms-2 bg-cyan-700 hover:bg-cyan-500" title="{{ __('tasks/index.button.store') }}">
                                {{ __('tasks/index.button.store') }}
                            </a>

                            <a href="#" class="px-4 py-2 font-bold text-white bg-red-700 rounded ms-2 hover:bg-red-500" title="{{ __('tasks/index.button.delete') }}">
                                {{ __('tasks/index.button.delete') }}
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>