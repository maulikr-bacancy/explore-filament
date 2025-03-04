<?php
namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Components\TextInput;
use Livewire\WithPagination;
use App\Models\Practice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SwitchPractice extends Page implements HasForms
{
    use WithPagination, InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-arrows-right-left';
    protected static string $view = 'filament.pages.switch-practice';

    public ?string $search = '';

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('search')
                ->label('Search Practice')
                ->placeholder('Enter practice name or id...')
                ->live(), // This makes it update as the user types
        ];
    }

    public function getPracticesProperty()
    {
        $query = Practice::query();

        if (!Auth::user()->isSuperAdmin()) {
            $query->whereIn('ID', Auth::user()->userAuths()->where('status', 1)->pluck('practice_id'));
        }

        if (!empty($this->search)) {
            $query
                ->where('ID', 'like', '%' . $this->search . '%')
                ->orWhere('Name', 'like', '%' . $this->search . '%')
            ;
        }

        return $query->paginate(5);
    }

    public function switchPractice($practiceId)
    {
        if (!Auth::user()->isSuperAdmin()){

            $userAuthorizedPractices = Auth::user()->userAuths()
                ->where('role', '!=', 'none')
                ->where('status', 1)
                ->pluck('practice_id')
                ->toArray();

            if (!in_array($practiceId, $userAuthorizedPractices)) {
                session()->flash('error', 'You are not authorized for this practice.');
                return;
            }

        }

        Session::put('practice_id', $practiceId);
        return redirect()->route('filament.admin.pages.dashboard');
    }
}

