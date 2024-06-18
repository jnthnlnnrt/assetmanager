<?php

namespace App\Livewire\Organization;

use App\Models\Department;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Departamentos')]
class Departments extends Component
{
    public $title = 'Departamentos';
    public
        $departments;

    public function mount(){
        $this->departments = Department::all();
    }

    public function render()
    {
        return view('livewire.organization.departments');
    }
}
