<?php

namespace App\Livewire\Organization;

use App\Models\Organization\Department;
use App\Models\Organization\Employee;
use App\Models\Organization\Location;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class EditEmployee extends Component
{
    //Properties
    public $departments, $locations;

    public $id, $employee, $internal_id, $name, $email, $department = '', $location = '', $status, $remarks;

    public function update(){
        try{
            DB::beginTransaction();
                Employee::where('id', $this->id)->update([
                    'internal_id' => strtoupper($this->internal_id),
                    'name' => $this->name,
                    'email' => $this->email,
                    'department_id' => $this->department,
                    'location_id' => $this->location,
                    'status' => $this->status,
                    'remarks' => $this->remarks,
                    'updated_by' => Auth::user()->id,
                ]);
            DB::commit();

            Toaster::success('Registro actualizado correctamente!'); 
        } catch(\Throwable $e){ 
            DB::rollBack();
            Toaster::error('Hubo un error al actualizar el registro.' . $e->getMessage()); 
        }
    
    }

    public function mount($id){
        $this->employee = Employee::where('id', $id)->first();

        $this->internal_id = $this->employee->internal_id;
        $this->name = $this->employee->name;
        $this->email = $this->employee->email;
        $this->department = $this->employee->department_id;
        $this->location = $this->employee->location_id;
        $this->status = $this->employee->status;
        $this->remarks = $this->employee->remarks;

        $this->departments = Department::orderBy('name', 'asc')->get();
        $this->locations = Location::whereIn('type', ['U','B'])->orderBy('name', 'asc')->get();
    }

    public function render()
    {
        return view('livewire.organization.edit-employee');
    }
}
