<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('tasks/index.general_label') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="w-1/2 mx-auto border rounded-lg shadow border-cyan-700 shadow-cyan-500">
                        <div class="px-4 py-2.5 bg-blue-100 rounded-none rounded-t-lg">
                            <div class="flex items-center justify-between">
                                <div class="flex items-end">
                                    <h3 class="text-lg font-medium leading-none">{{ __('tasks/index.list.own_section_label') }}</h3>
                                    <span class="ml-1 text-xs">({{ $totalTasks }})</span>
                                </div>

                                @include('tasks.submenu-items')

                                <a href="{{ route('tasks.create') }}" class="px-4 py-2 font-bold text-white bg-blue-700 rounded hover:bg-blue-500" title="{{ __('tasks/index.button.create') }}">
                                    {{ __('tasks/index.button.create') }}
                                </a>
                            </div>
                        </div>

                        <div class="px-4">
                            @if (session()->has('status'))
                                {{-- <x-flash-messages :sessionType="'success'" :color="'green'" :title="'¡¡Éxito!!'" /> --}}
                                <x-flash-messages />
                            @endif

                            @forelse ($ownTasks as $task)

                                <div class="w-full mt-4 border rounded-lg shadow border-cyan-700 shadow-cyan-500">
                                    <div class="px-4 py-2.5 bg-sky-100 rounded-none rounded-t-lg">
                                        <div class="flex items-center justify-between">
                                            <h4 class="text-base font-medium leading-none">{{ $task->title }}</h4>

                                            <div class="flex flex-col items-end justify-center text-sm leading-none">
                                                <p>
                                                    <span class="mr-2">{{ __('tasks/index.list.created_label') }}:</span><span class="text-xs underline">{{ $task->createdAtWithFormat() }}</span>
                                                </p>
                                                <p class="text-[10px] font-bold">{{ $task->createdAtDiffForHumans() }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="p-4">
                                        <div class="w-full p-4 border rounded-lg shadow border-cyan-700 shadow-cyan-500">
                                            {{ $task->description }}
                                        </div>
                                    </div>

                                    <div class="px-4 py-2.5 flex rounded-none rounded-b-lg justify-evenly bg-sky-100">
                                        {{-- <div class="flex">
                                            <a href="#" class="w-56 px-4 py-2 font-bold text-white bg-green-700 rounded hover:bg-green-500" title="{{ __('tasks/index.button.mark_as_completed') }}">
                                                {{ __('tasks/index.button.mark_as_completed') }}
                                            </a>
                                        </div> --}}

                                        <form action="{{ route('tasks.toggle-mine', $task) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <div class="flex items-center">
                                                <span class="mr-2 text-sm">{{ __('tasks/index.list.completed_label') }}:</span>

                                                @php
                                                    $checkboxTitle = $task->completed ? 'Marcar como PENDIENTE' : 'Marcar como COMPLETADA';
                                                @endphp

                                                <label class="switch" title="{{ $checkboxTitle }}">
                                                    <input onclick="this.form.submit()" type="checkbox" {{ $task->completed ? 'checked' : '' }}>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                            <input type="hidden" name="redirect_page" value="{{ $ownTasks->currentPage() }}" />
                                        </form>


                                        <div class="flex justify-end w-full">
                                            <a href="{{ route('tasks.edit', [$task, 'referer' => 'own-' . $ownTasks->currentPage()]) }}" class="px-4 py-2 font-bold text-white bg-gray-700 rounded hover:bg-gray-500" title="{{ __('tasks/index.button.edit') }}">
                                                {{ __('tasks/index.button.edit') }}
                                            </a>

                                            <form action="{{ route('tasks.destroy-mine', $task) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"class="px-4 py-2 font-bold text-white bg-red-700 rounded ms-2 hover:bg-red-500" title="{{ __('tasks/index.button.delete') }}" onclick="return confirm('{{ __('¿En verdad se desea ELIMINAR este registro?') }}')">{{ __('tasks/index.button.delete') }}</button>
                                                <input type="hidden" name="redirect_page" value="{{ $ownTasks->currentPage() }}" />
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            @empty
                                <div class="w-full p-4 mt-4 text-center text-white border rounded-lg shadow border-slate-700 shadow-slate-500 bg-slate-400">
                                    :: <span class="italic">No hay tareas propias disponibles actualmente</span> ::
                                </div>
                            @endforelse


                        </div>

                        {{-- <div class="h-4 mt-4 bg-blue-100 rounded-none rounded-b-lg"></div> --}}
                        <div class="px-4 py-2 mt-4 bg-blue-100 rounded-none rounded-b-lg">
                            {{ $ownTasks->links() }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
