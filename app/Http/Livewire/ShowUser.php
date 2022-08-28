<?php

namespace App\Http\Livewire;

use App\Models\Tenant;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class ShowUser extends Component {

    use WithPagination;

    public $perPage = 10;
    public $sortField = 'name';
    public $sortAsc = true;
    public $search = '';
    public $super;
    public $tenants;
    public $selectedTenant;

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }

    public function mount()
    {
        if (session()->has('tenant_id')) {
            $this->super = false;
        } else {
            $this->super = true;
            $this->tenants = Tenant::all()->pluck('name', 'id')->toArray();
        }
    }

    public function render()
    {
        $query = User::search($this->search)
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
        if ($this->super && $this->selectedTenant) {
            $query->where('tenant_id', $this->selectedTenant);
        }

        return view('livewire.show-user', [
            'users' => $query->with('documents')->paginate($this->perPage),
        ]);
    }

    public function impersonate($impersonateUserId)
    {
        $user = auth()->user();
        if ($user === null) {
            return $this->redirect(route('login'));
        }
        if (! $user->isSuperAdmin()) {
            abort(403);
        }
        session()->put('origin_user_id', $user->id());
        auth()->loginUsingId($impersonateUserId);

        return $this->redirect(route('team.index'));

    }
}
