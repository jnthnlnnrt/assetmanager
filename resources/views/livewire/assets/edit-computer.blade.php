<div class="space-y-3">
    <form class="space-y-3" wire:submit="update">
        <header class="pb-2 border-b border-gray-300 flex justify-between items-center">
            <div>
                <div class="text-2xl font-semibold flex items-center">
                    <a href="{{ route('computers') }}" wire:navigate
                        class="font-sm font-medium text-blue-600 dark:text-blue-500 hover:underline me-2">
                        <i class="fa-solid fa-circle-chevron-left"></i>
                    </a>
                    Editar equipo de computo
                </div>
            </div>
            <div class="space-x-1">
                <x-buttons.default type="submit">Guardar</x-buttons.default>

                <x-buttons.default type="button" id="dropdownDefaultButton" data-dropdown-toggle="dropdownActions">
                    Acciones
                    <i class="fa-solid fa-chevron-down ms-2"></i>
                </x-buttons.default>

                <!-- Dropdown menu -->
                <div id="dropdownActions"
                    class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-56 dark:bg-gray-700">
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                        <li>
                            <a href="#"
                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                wire:click="$dispatch('openModal', { component: 'partials.modals.assets.allocate', arguments: { asset: {{ $asset->id }} }})">
                                <i class="fa-solid fa-user-check me-2 w-4 h-4"></i>
                                <span>
                                    Asignar activo
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#"
                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                wire:click="$dispatch('openModal', { component: 'partials.modals.maintenances.register', arguments: { asset: {{ $asset->id }} }})">
                                <i class="fa-solid fa-brush me-2 w-4 h-4"></i>
                                <span>
                                    Registrar mantenimiento
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>

            </div>
        </header>
        <div class="grid sm:grid-cols-10 gap-4">
            <div class="sm:col-span-2">
                <x-forms.label for="assset_tag">Asset Tag</x-forms.label>
                <x-forms.input-white type="text" class="uppercase" id="assset_tag" name="assset_tag"
                    placeholder="Asset Tag" required="" wire:model="asset_tag" readonly />
            </div>
            <div class="sm:col-span-2">
                <x-forms.label for="id">Marca</x-forms.label>
                <x-forms.select-white wire:model="manufacturer" required>
                    <option value="" disabled>Seleccione...</option>
                    @foreach($manufacturers as $manufacturer)
                    <option value="{{$manufacturer->id}}">
                        {{$manufacturer->name}}
                    </option>
                    @endforeach
                </x-forms.select-white>
            </div>
            <div class="sm:col-span-3">
                <x-forms.label for="model">Modelo</x-forms.label>
                <x-forms.input-white type="text" id="model" name="model" placeholder="Modelo" required=""
                    wire:model="model" />
            </div>
            <div class="sm:col-span-2">
                <x-forms.label for="serial">Serie</x-forms.label>
                <x-forms.input-white type="text" class="uppercase" id="serial" name="serial"
                    placeholder="Numero de serie" required="" wire:model="serial" />
            </div>
            <div class="sm:col-span-2">
                <x-forms.label for="subtype">Tipo</x-forms.label>
                <x-forms.select-white wire:model="subtype" required>
                    <option value="" disabled>Seleccione...</option>
                    @foreach($subtypes as $subtype)
                    <option value="{{$subtype->id}}">
                        {{$subtype->name}}
                    </option>
                    @endforeach
                </x-forms.select-white>
            </div>
            <div class="sm:col-span-8 hidden sm:block">

            </div>
            <div class="sm:col-span-2">
                <x-forms.label for="status">Estatus</x-forms.label>
                <x-forms.input-white type="text" id="status" name="status" placeholder="Estatus" required=""
                    wire:model="status" readonly />
            </div>
            <div class="sm:col-span-3">
                <x-forms.label for="employee">Usuario actual</x-forms.label>
                <x-forms.input-white type="text" id="employee" name="employee" placeholder="Usuario actual" required=""
                    wire:model="employee" readonly />
            </div>
            <div class="sm:col-span-2">
                <x-forms.label for="department">Departamento</x-forms.label>
                <x-forms.input-white type="text" id="department" name="department" placeholder="Departamento"
                    required="" wire:model="department" readonly />
            </div>
            <div class="sm:col-span-2">
                <x-forms.label for="location">Ubicacion</x-forms.label>
                <x-forms.select-white wire:model="location" required>
                    <option value="" disabled>Seleccione...</option>
                    @foreach($locations as $location)
                    <option value="{{$location->id}}">
                        {{$location->name}}
                    </option>
                    @endforeach
                </x-forms.select-white>
            </div>
            <div class="sm:col-span-10">
                <x-forms.label for="name">Comentarios</x-forms.label>
                <x-forms.input-white type="text" id="remarks" name="remarks" placeholder="Comentarios"
                    wire:model="remarks" />
            </div>
        </div>
    </form>
    <div>
        <livewire:partials.tables.maintenances asset={{$id}}/>
    </div>
</div>