                                <div class="text-sm">
                                    <x-submenu-link :href="route('tasks.index')" :active="request()->routeIs('tasks.index')" title="{{ __('tasks/index.list.submenu_items.all_title') }}">
                                        {{ __('tasks/index.list.submenu_items.all') }}
                                    </x-submenu-link>
                                    <span class="text-cyan-700">/</span>
                                    <x-submenu-link :href="route('tasks.own-list')" :active="request()->routeIs('tasks.own-list')" title="{{ __('tasks/index.list.submenu_items.mine_title') }}">
                                        {{ __('tasks/index.list.submenu_items.mine') }}
                                    </x-submenu-link>
                                </div>
