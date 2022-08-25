<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Arr;
use Livewire\Component;
use Livewire\WithFileUploads;

class AddUser extends Component
{
    use WithFileUploads;
    public $name = "Kevin McKee";
    public $email = "kevin@lc.com";
    public $department = 'information_technology';
    public $title = "Instructor";
    public $photo;
    public $document;
    public $status = 1;
    public $role = 'admin';

    public function submit()
    {
       $validated = $this->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'department' => 'required|string',
            'title' => 'required|string',
            'status' => 'required|boolean',
            'role' => 'required|string',
            'photo' => 'image|max:1024',
            'application' => 'file|mimes:pdf|max:1024',
        ]);
        $fileName = $this->photo->store('photos', 's3-public');
        $validated = array_merge(Arr::except($validated, 'application'), ['photo' => $fileName, 'password' => bcrypt('password')]);
        $user = User::create($validated);
        $documentName = $this->document->store('documents', 's3');
        $user->documents()->create([
            'file_name' => $documentName
        ]);
        session()->flash('success_message', 'Member was add successfully!');
    }


    public function render()
    {
        return view('livewire.add-user');
    }
}
