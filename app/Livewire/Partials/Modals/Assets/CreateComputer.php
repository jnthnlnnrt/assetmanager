<?php

namespace App\Livewire\Partials\Modals\Assets;

use App\Models\Asset;
use App\Models\AssetEvent;
use App\Models\Catalogs\AssetSubtype;
use App\Models\Catalogs\AssetType;
use App\Models\Catalogs\Manufacturer;
use App\Models\Organization\Location;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Masmerise\Toaster\Toaster;

class CreateComputer extends ModalComponent
{
    public static function closeModalOnEscape(): bool {
        return false;
    }

    public static function closeModalOnClickAway(): bool {
        return false;
    }

    //Catalogs
    public $manufacturers, $subtypes, $locations;

    //Properties
    public $manufacturer = '', $model, $serial, $subtype = '', $location = '', $remarks;

    public function mount(){
        $this->manufacturers = Manufacturer::orderBy('name', 'asc')->get();
        $this->subtypes = AssetSubtype::where('type_id', 1)->orderBy('name', 'asc')->get();
        $this->locations = Location::whereIn('type', ['A', 'B'])->orderBy('name', 'asc')->get();
    }

    public function create(){
        if(checkSerial(strtoupper($this->serial)) === 0){
            Toaster::error('Ya existe un registro con el mismo numero de serie.'); 
        } else{
            try {
                DB::beginTransaction();

                $computer = Asset::create([
                    'category_id' => 1,
                    'type_id' => 1,
                    'subtype_id' => $this->subtype,
                    'asset_tag' => 'X',
                    'manufacturer_id' => $this->manufacturer,
                    'model' => $this->model,
                    'serial' => strtoupper($this->serial),
                    'status_id' => 1,
                    'employee_id' => 1,
                    'location_id' => $this->location,
                    'require_maintenance' => AssetType::where('id', 1)->value('require_maitenance'),
                    'frequency_id' => AssetType::where('id', 1)->value('frequency_id'),
                    'last_maintenance' => '2024-01-01',
                    'carry_authorization' => 0,
                    'remarks' => $this->remarks,
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id
                ]);
    
                //Fase 2 - Despues de insertar el registro, se genera el asset_tag y se actualiza el registro insertado.
                Asset::where('id', $computer->id)->update(['asset_tag' => generateAssetTag($computer->id)]);
    
                $ae = AssetEvent::create([
                    'event_tag' => 'X',
                    'event_type_id' => 1,
                    'start_date' => date('Y-m-d'),
                    'end_date' => date('Y-m-d'),
                    'asset_id' => $computer->id,
                    'status' => 0,
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id,                    
                ]);

                AssetEvent::where('id', $ae->id)->update(['event_tag' => 'AE-' . $ae->id]);

                DB::commit();

                $this->dispatch('pg:eventRefresh-computers-table');
                $this->closeModal();
                Toaster::success('Registro insertado correctamente!'); 
            } catch (\Throwable $th) {
                DB::rollBack();
                Toaster::error('Hubo un error al insertar el registro.' . $th->getMessage()); 
            }
        }
    }


    public function cancel(){
        $this->closeModal();
    }

    public function render()
    {
        return <<<'HTML'
        <div>
            <!-- Modal content -->
            <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                <!-- Modal header -->
                <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Agregar equipo de computo
                    </h3>
                </div>
                <!-- Modal body -->
                <form wire:submit="create">
                    <div class="grid gap-4 mb-4 sm:grid-cols-6">
                        <div class="sm:col-span-2">
                            <x-forms.label for="manufacturer">Marca</x-forms.label>
                            <x-forms.select wire:model="manufacturer" required>
                                <option value="" disabled>Seleccione...</option>
                                @foreach($manufacturers as $manufacturer)
                                    <option value="{{$manufacturer->id}}">
                                        {{$manufacturer->name}}
                                    </option>
                                @endforeach
                            </x-forms.select>
                        </div>
                        <div class="sm:col-span-4">
                            <x-forms.label for="model">Modelo</x-forms.label>
                            <x-forms.input type="text" id="model" name="model" placeholder="Modelo del activo" required="" wire:model="model"/>
                        </div>
                        <div class="sm:col-span-2">
                            <x-forms.label for="serial">Numero de serie</x-forms.label>
                            <x-forms.input type="text" class="uppercase" id="serial" name="serial" placeholder="Numero de serie" required="" wire:model="serial"/>
                        </div>
                        <div class="sm:col-span-2">
                            <x-forms.label for="subtype">Tipo</x-forms.label>
                            <x-forms.select wire:model="subtype" required>
                                <option value="" disabled>Seleccione...</option>
                                @foreach($subtypes as $subtype)
                                    <option value="{{$subtype->id}}">
                                        {{$subtype->name}}
                                    </option>
                                @endforeach
                            </x-forms.select>
                        </div>
                        <div class="sm:col-span-2">
                            <x-forms.label for="location">Ubicacion</x-forms.label>
                            <x-forms.select wire:model="location" required>
                                <option value="" disabled>Seleccione...</option>
                                @foreach($locations as $location)
                                    <option value="{{$location->id}}">
                                        {{$location->name}}
                                    </option>
                                @endforeach
                            </x-forms.select>
                        </div>
                        <div class="sm:col-span-6">
                            <x-forms.label>Comentarios</x-forms.label>
                            <x-forms.input type="text" wire:model="remarks" />
                        </div>
                    </div>
                    <div class="flex items-center justify-end space-x-2">
                        <x-buttons.default type="submit">
                            Guardar
                        </x-buttons.default>
                        <x-buttons.red type="button" wire:click="cancel">Cancelar</x-buttons.red>
                    </div>
                </form>
            </div>
        </div>
        HTML;
    }
}
