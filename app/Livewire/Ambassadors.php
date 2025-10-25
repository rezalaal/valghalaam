<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Ambassadors extends Component
{
    use WithPagination;

    public $search = '';

    protected $paginationTheme = 'tailwind';

    public function updatingSearch()
    {
        // وقتی سرچ تغییر می‌کنه، به صفحه ۱ برگرد
        $this->resetPage();
    }

    public function render()
    {
        $users = User::select('first_name', 'last_name', 'code', 'job_title')
            ->where(function ($q) {
                $q->where('email', '<>', 'admin@local.tld')
                  ->orWhereNull('email');
            })
            ->when($this->search, function ($q) {
                $q->where('last_name', 'like', '%'.$this->search.'%');
            })
            ->paginate(10);

        return view('livewire.ambassadors', [
            'users' => $users,
        ]);
    }
}
