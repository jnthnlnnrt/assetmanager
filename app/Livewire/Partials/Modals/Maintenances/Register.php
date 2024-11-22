<?php

namespace App\Livewire\Partials\Modals\Maintenances;

use App\Models\Asset;
use App\Models\AssetEvent;
use App\Models\Catalogs\AssetEventType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Masmerise\Toaster\Toaster;

class Register extends ModalComponent
{
    public static function modalMaxWidth(): string {
        return 'sm';
    }

    public static function closeModalOnEscape(): bool {
        return false;
    }

    public static function closeModalOnClickAway(): bool {
        return false;
    }

    //Catalogs
    public $maintenance_types;

    //Properties
    public $asset, $maintenance_type = '', $date, $remarks;

    public function mount(){
        $this->maintenance_types = AssetEventType::whereIn('id', ['3', '4'])->orderBy('name', 'asc')->get();
    }

    public function save(){
        try {
            DB::beginTransaction();
            //Creamos el registro del mantenimiento
            $maintenance = AssetEvent::create([
                'event_tag' => 'X',
                'event_type_id' => $this->maintenance_type,
                'start_date' => $this->date,
                'end_date' => $this->date,
                'asset_id' => $this->asset,
                'status' => 0,
                'remarks' => $this->remarks,
                'created_by' => Auth::user()->id,
                'updated_by' => Auth::user()->id
            ]);

            AssetEvent::where('id', $maintenance->id)->update(['event_tag' => 'AE-' . $maintenance->id]);

            //Actualizamos el activo con la nueva asignacion y autorizacion de salida
            if($this->maintenance_type === '3'){
                Asset::where('id', $this->asset)->update([
                    'last_maintenance' => $this->date,
                    'updated_by' => Auth::user()->id,  
                ]);
            }

            DB::commit();

            $this->closeModal();
            Toaster::success('Mantenimiento registrado correctamente!');
        } catch (\Throwable $e) {
            DB::rollBack();
            Toaster::error('Hubo un error al registrar el mantenimiento.' . $e->getMessage()); 
        } 
    }    

    public function cancel(){
        $this->closeModal();
    }

    public function render()
    {
        return <<<'HTML'
        <div>
            <div class="flex flex-col bg-white border shadow-sm rounded-xl pointer-events-auto dark:bg-neutral-800 dark:border-neutral-700 dark:shadow-neutral-700/70">
                <div class="flex justify-between items-center py-3 px-4 border-b dark:border-neutral-700">
                    <x-typography.h5 class="font-semibold">Registrar mantenimiento</x-typogrphy.h5>
                </div>
                <div class="p-4 overflow-y-auto">
                    <form wire:submit="save">
                        <div class="grid sm:grid-cols-2 gap-4 mb-4">
                            <div class="sm:col-span-2"> 
                                <x-forms.label>Tipo de mantenimiento</x-forms.label>
                                <x-forms.select wire:model="maintenance_type" required>
                                    <option value="" disabled>Seleccione...</option>
                                    @foreach($maintenance_types as $mt)
                                        <option value="{{$mt->id}}">
                                            {{$mt->name}}
                                        </option>
                                    @endforeach
                                </x-forms.select>
                            </div>
                            <div class="sm:col-span-2">
                                <x-forms.label>Fecha del mantenimiento</x-forms.label>
                                <x-forms.input type="text" id="datepicker"  wire:model="date" data-picker required/>
                            </div>
                            <div class="sm:col-span-2">
                                <x-forms.label>Comentarios</x-forms.label>
                                <x-forms.textarea rows="4" wire:model="remarks"></x-forms.textarea>
                            </div>
                        </div>
                        <div class="flex items-center justify-end space-x-2">
                            <x-buttons.default type="submit">Guardar</x-buttons.default>
                            <x-buttons.red type="button" wire:click="cancel">Cancelar</x-buttons.red>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        HTML;
    }
}
