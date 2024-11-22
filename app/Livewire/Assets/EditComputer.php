<?php

namespace App\Livewire\Assets;

use App\Models\Asset;
use App\Models\Catalogs\AssetSubtype;
use App\Models\Catalogs\Manufacturer;
use App\Models\Organization\Location;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class EditComputer extends Component
{
    //Catalogs
    public $manufacturers, $subtypes, $locations;

    //Properties
    public $id, $asset, $asset_tag, $manufacturer = '', $model, $serial, $subtype = '', $status, $employee, $department, $location = '', $remarks;

    public function mount($id){
        $this->asset = Asset::where('id', $id)->first();

        $this->asset_tag = $this->asset->asset_tag;
        $this->manufacturer = $this->asset->manufacturer_id;
        $this->model = $this->asset->model;
        $this->serial = $this->asset->serial;
        $this->subtype = $this->asset->subtype_id;
        $this->status = $this->asset->status->name;
        $this->employee = $this->asset->employee->name;
        $this->department = $this->asset->employee->department->name;
        $this->location = $this->asset->location_id;
        $this->remarks = $this->asset->remarks;

        $this->manufacturers = Manufacturer::orderBy('name', 'asc')->get();
        $this->subtypes = AssetSubtype::where('type_id', 1)->orderBy('name', 'asc')->get();
        $this->locations = Location::whereIn('type', ['A', 'B'])->orderBy('name', 'asc')->get();
    }

    public function update(){
        try{
            if(($this->asset->location_id != $this->location) && ($this->employee != 'Sin Usuario')){
                Toaster::error('La ubicacion solo se puede cambiar si el activo no se encuentra asignado');
                $this->location = $this->asset->location_id;
            } else {
                DB::beginTransaction();
                Asset::where('id', $this->id)->update([
                    'manufacturer_id' => $this->manufacturer,
                    'model' => $this->model,
                    'serial' => strtoupper($this->serial),
                    'subtype_id' => $this->subtype,
                    'location_id' => $this->location,
                    'remarks' => $this->remarks,
                    'updated_by' => Auth::user()->id,
                ]);

                DB::commit();
                Toaster::success('Registro actualizado correctamente!'); 
            }
        } catch(\Throwable $e){ 
            DB::rollBack();
            Toaster::error('Hubo un error al actualizar el registro.' . $e->getMessage()); 
        }
    }

    #[On('asset-allocated')]
    public function reloadAsset($id)
    {
        $this->asset = Asset::where('id', $id)->first();

        $this->status = $this->asset->status->name;
        $this->employee = $this->asset->employee->name;
        $this->department = $this->asset->employee->department->name;
        $this->location = $this->asset->location_id;
    }

    public function render()
    {
        return view('livewire.assets.edit-computer');
    }
}
