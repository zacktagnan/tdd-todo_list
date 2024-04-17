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
                        <div class="px-4 py-2.5 bg-blue-100 rounded-none rounded-t-lg">
                            <div class="flex items-center justify-between">
                                {{-- <h3>Mis Tareas</h3> --}}
                                {{-- <h3>{{ __('Mis Tareas') }}</h3> --}}
                                <h3 class="text-lg font-medium leading-none" alt="Mis Tareas">{{ __('tasks/index.section_label') }}</h3>

                                <a href="#" class="px-4 py-2 font-bold text-white bg-blue-700 rounded hover:bg-blue-500">
                                    {{ __('Crear Tarea') }}
                                </a>
                            </div>
                        </div>

                        <div class="p-4">
                            <div class="w-full p-4 mb-4 border rounded-lg shadow border-cyan-700 shadow-cyan-500">
                                Tarea actualizada con éxito
                            </div>
                            <x-flash-messages :sessionType="'success'" :color="'green'" :title="'¡¡Éxito!!'" />

                            {{-- Cuadro de Tarea --}}
                            <div class="w-full border rounded-lg shadow border-cyan-700 shadow-cyan-500">
                                <div class="px-4 py-2.5 bg-sky-100 rounded-none rounded-t-lg">
                                    <div class="flex items-center justify-between">
                                        {{-- <h3>Mis Tareas</h3> --}}
                                        {{-- <h3>{{ __('Mis Tareas') }}</h3> --}}
                                        <h4 class="text-base font-medium leading-none">Título de la tarea</h4>

                                        <label class="switch">
                                            <input type="checkbox" checked>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="p-4">
                                    <div class="w-full p-4 border rounded-lg shadow border-cyan-700 shadow-cyan-500">
                                        Descripción de la tarea
                                    </div>
                                </div>

                                <div class="px-4 py-2.5 flex rounded-none rounded-b-lg justify-evenly bg-sky-100">
                                    <a href="#" class="px-4 py-2 font-bold text-white bg-green-700 rounded hover:bg-green-500">
                                        {{ __('Marcar como Completada') }}
                                    </a>

                                    <a href="#" class="px-4 py-2 font-bold text-white bg-gray-700 rounded hover:bg-gray-500">
                                        {{ __('Editar') }}
                                    </a>

                                    <a href="#" class="px-4 py-2 font-bold text-white bg-red-700 rounded hover:bg-red-500">
                                        {{ __('Eliminar') }}
                                    </a>
                                </div>
                            </div>


                        </div>

                        <div class="h-4 bg-blue-100 rounded-none rounded-b-lg"></div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
