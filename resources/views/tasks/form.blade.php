                        <form action="{{ $action }}" method="POST">
                            @csrf
                            @method($method)
                            <div class="px-4 py-2.5 bg-blue-100 rounded-none rounded-t-lg h-[60px] flex items-center">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-medium leading-none">{{ $sectionLabel }}</h3>
                                </div>
                            </div>

                            <div class="p-4">
                                <div class="flex">
                                    <div class="w-full">
                                        <label for="title" class="block text-base font-bold text-gray-700 dark:text-white">
                                            {{ __('tasks/index.form.title_label_input') }}
                                        </label>
                                        <input
                                            autofocus
                                            type="text" name="title" id="title"
                                            value="{{ old('title', $task->title) }}"
                                            class="block w-full p-4 mt-2 bg-white border rounded-lg shadow-md border-cyan-200 focus:outline-none focus:border-slate-300 focus:shadow-cyan-200 focus:ring-cyan-300 focus:ring-1"
                                        />
                                        @error('title')
                                            <p class="mt-0.5 text-sm italic text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="w-[16%] ml-7">
                                        <label for="completed" class="block text-base font-bold text-gray-700 dark:text-white">
                                            {{ __('tasks/index.form.completed_label_checkbox') }}
                                        </label>
                                        <div class="flex items-center justify-center mt-2 h-2/3">
                                            <label class="switch">
                                                <input
                                                    type="checkbox" name="completed" id="completed"
                                                    {{ old('completed', $task->completed) ? 'checked' : '' }}
                                                />
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <label for="description" class="block text-base font-bold text-gray-700 dark:text-white">
                                        {{ __('tasks/index.form.description_label_input') }}
                                    </label>
                                    <textarea name="description" id="description"
                                        class="w-full p-4 mt-2 bg-white border rounded-lg shadow-md border-cyan-200 focus:outline-none focus:border-slate-300 focus:shadow-cyan-200 focus:ring-cyan-300 focus:ring-1">{{ old('description', $task->description) }}</textarea>
                                    @error('description')
                                    <p class="mt-0.5 text-sm italic text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="px-4 py-2.5 flex rounded-none rounded-b-lg justify-end bg-blue-100">
                                <a href="{{ $routeForCancelBtn }}" class="px-4 py-2 font-bold text-white bg-gray-700 rounded hover:bg-gray-500" title="{{ __('tasks/index.button.cancel') }}">
                                    {{ __('tasks/index.button.cancel') }}
                                </a>

                                <button type="submit" class="px-4 py-2 font-bold text-white rounded ms-2 bg-cyan-700 hover:bg-cyan-500" title="{{ $submit }}">
                                    {{ $submit }}
                                </button>

                                @if ($method === 'PUT')
                                {{-- <a href="#" class="px-4 py-2 font-bold text-white bg-red-700 rounded ms-2 hover:bg-red-500" title="{{ __('tasks/index.button.delete') }}">
                                    {{ __('tasks/index.button.delete') }}
                                </a> --}}
                                <button type="submit" form="f_delete_task" class="px-4 py-2 font-bold text-white bg-red-700 rounded ms-2 hover:bg-red-500"
                                    title="{{ __('tasks/index.button.delete') }}"
                                    onclick="return confirm('{{ __('¿En verdad se desea ELIMINAR este registro?') }}')">{{ __('tasks/index.button.delete') }}</button>
                                <input type="hidden" name="redirect_route" value="{{ $redirectRoute }}" />
                                <input type="hidden" name="redirect_page" value="{{ $redirectPage }}" />
                                @endif
                            </div>

                        </form>

                        @if ($method === 'PUT')
                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline" id="f_delete_task">
                            @csrf
                            @method('DELETE')
                        </form>
                        @endif
