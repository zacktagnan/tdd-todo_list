
                @if (session(config('constants.SESSION_NAME'))['type'] === config('constants.SESSION_TYPE'))
                    <div class="w-full mt-4">
                        <div class="px-4 py-3 text-green-700 bg-green-100 border border-green-400 rounded" role="alert">
                            <strong class="font-bold">{{ session(config('constants.SESSION_NAME'))['title'] }}</strong>
                            <span class="block sm:inline">{{ session(config('constants.SESSION_NAME'))['message'] }}</span>
                        </div>
                    </div>
                @else
                    <div class="w-full mt-4">
                        <div class="px-4 py-3 text-red-700 bg-red-100 border border-red-400 rounded" role="alert">
                            <strong class="font-bold">{{ session(config('constants.SESSION_NAME'))['title'] }}</strong>
                            <span class="block sm:inline">{{ session(config('constants.SESSION_NAME'))['message'] }}</span>
                        </div>
                    </div>
                @endif
