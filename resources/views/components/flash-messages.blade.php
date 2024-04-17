@props(['sessionType', 'color', 'title'])

                    <div class="w-full mt-0 mb-4">
                        <div class="px-4 py-3 text-{{ $color }}-700 bg-{{ $color }}-100 border border-{{ $color }}-400 rounded" role="alert">
                            <strong class="font-bold">{{ $title }}</strong>
                            {{-- <span class="block sm:inline">{{ session($sessionType) }}</span> --}}
                            <span class="block sm:inline">Tarea actualizada con éxito</span>
                        </div>
                    </div>
