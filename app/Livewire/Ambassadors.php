<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use phpDocumentor\Reflection\Types\Null_;

class Ambassadors extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public function render()
    {
        $users = User::select('first_name', 'last_name', 'code', 'job_title')
    ->where(function ($q) {
        $q->where('email', '<>', 'admin@local.tld')
            ->orWhereNull('email');
        })
        ->paginate(10);


        return view('livewire.ambassadors', [
            'users' => $users,
        ]);
    }
}
