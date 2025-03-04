<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Illuminate\Support\Facades\Auth;

class ImpersonateUser extends Widget implements HasForms
{
    use InteractsWithForms;

    protected static string $view = 'filament.widgets.impersonate-user';

    public ?array $data = [];
    public ?int $user_id = null;

    // define the original user variable with original user detail

    public $original_user = null;


    public function mount()
    {
        $this->form->fill([
            'user_id' => session('original_user') ?: null,
        ]);
        if (session()->has('original_user')) {
            $this->original_user = User::find(session('original_user'));
        }
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label('Switch User')
                    ->options(User::where('id', '!=', Auth::id())->pluck('name', 'id'))
                    ->searchable()
            ]);
    }

    public function switchUser()
    {
        if ($this->user_id) {
            $user = User::find($this->user_id);
            if (!$user->activePractices()->count()){
                session()->flash('error', 'This User does not have any active assigned practice');
                return ;
            }

            session(['original_user' => Auth::id()]);
            Auth::login($user);

            return redirect('/admin/switch-practice');
        }
    }

    public function leaveImpersonation()
    {
        Auth::loginUsingId(session('original_user'));
        session()->forget(['original_user']);
        return redirect('/admin');
    }
}


