<?php

namespace App\Http\Livewire;

use App\Models\Department;
use Livewire\Component;

class DepartmentForm extends Component
{
    public $name;
    public $success = false;

    public function mount($departmentId = null)
    {
        if ($departmentId) {
            $name = Department::findOrFail($departmentId)->name;
        }
    }

    public function submit()
    {
        Department::create([
            'name' => $this->name,
            'tenant_id' => sess
        ]);
        $this->success = true;
    }
    public function render()
    {
        return view('livewire.department-form');
    }
}
