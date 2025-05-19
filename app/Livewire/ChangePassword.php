<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\User;

class ChangePassword extends Component
{
    public $current_password = '';
    public $password = '';
    public $password_confirmation = '';
    
    public $showModal = false;
    
    protected $listeners = ['openChangePasswordModal' => 'openModal'];
    
    protected $rules = [
        'current_password' => 'required',
        'password' => 'required|confirmed',
    ];
    
    protected $messages = [
        'current_password.required' => 'La contraseña actual es obligatoria.',
        'password.required' => 'La nueva contraseña es obligatoria.',
        'password.confirmed' => 'Las contraseñas no coinciden.'
    ];
    
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    
    public function openModal()
    {
        $this->resetValidation();
        $this->reset(['current_password', 'password', 'password_confirmation']);
        $this->showModal = true;
        
        // Emitir evento para mostrar el modal desde JavaScript
        $this->dispatch('showModal');
    }
    
    public function closeModal()
    {
        $this->showModal = false;
    }
    
    public function changePassword()
    {
        $this->validate();
        
        $userId = Auth::id();
        $user = User::findOrFail($userId);
        
        // Verificar que la contraseña actual sea correcta
        if (!Hash::check($this->current_password, $user->password)) {
            $this->addError('current_password', 'La contraseña actual no es correcta.');
            return;
        }
        
        // Verificar que la nueva contraseña no sea igual a la actual
        if (Hash::check($this->password, $user->password)) {
            $this->addError('password', 'La nueva contraseña debe ser diferente a la actual.');
            return;
        }
        
        // Actualizar la contraseña
        $user->password = Hash::make($this->password);
        $user->save();
        
        // Limpiar los campos y cerrar el modal
        $this->reset(['current_password', 'password', 'password_confirmation']);
        $this->showModal = false;
        
        // Mostrar mensaje de éxito
        session()->flash('password_changed', 'Tu contraseña ha sido actualizada correctamente.');
    }
    
    public function render()
    {
        return view('livewire.change-password');
    }
}
