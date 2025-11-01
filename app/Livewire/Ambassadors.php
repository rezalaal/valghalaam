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
        $users = User::where(function ($q) {
            $q->where('email', '<>', 'admin@local.tld')
                ->orWhereNull('email');
        })
        ->when($this->search, function ($q) {
            $q->where('last_name', 'like', '%'.$this->search.'%');
        })
        ->with('code')
        ->select('id', 'first_name', 'last_name', 'job_title')
        ->paginate(10);

        $rows = $users->getCollection()->transform(function ($user) {
            return [
                'code_value' => $user->code_value,
                'first_name' => $user->first_name,
                'last_name'  => $user->last_name,
                'job_title'  => $user->job_title,
            ];
        });
        return view('livewire.ambassadors', [
            'users' => $users,
        ]);
    }
}
