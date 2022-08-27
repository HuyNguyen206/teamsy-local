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
            'document' => 'file|mimes:pdf|max:1024',
        ]);
        $fileName = $this->photo->store('photos', 's3-public');
        $validated = array_merge(Arr::except($validated, 'document'), ['photo' => $fileName, 'password' => bcrypt('password')]);

        $user = User::create($validated);
        $fileName = pathinfo($this->document->getClientOriginalName(), PATHINFO_FILENAME)
            .'-'. now()->timestamp.'.'.$this->document->getClientOriginalExtension();
        $this->document->storeAs("documents/{$user->id}", $fileName, 's3');
        $user->documents()->create([
            'file_name' => $fileName,
            'type' => 'application',
            'extension' => $this->document->getClientOriginalExtension(),
            'size' => $this->document->getSize(),
        ]);

        session()->flash('success_message', 'Member was add successfully!');
    }


    public function render()
    {
        return view('livewire.add-user');
    }
}
