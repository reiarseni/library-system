<div>
    {{-- Success is as dangerous as failure. --}}
    <!-- Modal para cambio de contraseña -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" wire:ignore.self aria-hidden="{{ $showModal ? 'false' : 'true' }}">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="changePasswordModalLabel">
                        <i class="fas fa-key me-2 text-primary"></i>Cambiar Contraseña
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar" wire:click="closeModal"></button>
                </div>
                <div class="modal-body p-4">
                    @if (session()->has('password_changed'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('password_changed') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                        </div>
                    @endif

                    <form wire:submit.prevent="changePassword" class="needs-validation">
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Contraseña actual</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-lock text-primary"></i>
                                </span>
                                <input type="password" class="form-control border-start-0 @error('current_password') is-invalid @enderror" 
                                    id="current_password" wire:model.live="current_password" placeholder="Ingresa tu contraseña actual">
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Nueva contraseña</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-key text-primary"></i>
                                </span>
                                <input type="password" class="form-control border-start-0 @error('password') is-invalid @enderror" 
                                    id="password" wire:model.live="password" placeholder="Ingresa tu nueva contraseña">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-text">La contraseña debe tener al menos 8 caracteres.</div>
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">Confirmar nueva contraseña</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-check-circle text-primary"></i>
                                </span>
                                <input type="password" class="form-control border-start-0" 
                                    id="password_confirmation" wire:model.live="password_confirmation" placeholder="Confirma tu nueva contraseña">
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Guardar nueva contraseña
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Script para controlar el modal -->
    <script>
        document.addEventListener('livewire:initialized', function () {
            // Asegurarse de que el elemento modal existe
            const modalElement = document.getElementById('changePasswordModal');
            if (!modalElement) {
                console.error('Modal element not found');
                return;
            }
            
            // Inicializar el modal de Bootstrap
            let modal;
            try {
                modal = new bootstrap.Modal(modalElement);
            } catch (e) {
                console.error('Error initializing modal:', e);
                return;
            }
            
            // Escuchar eventos directos
            Livewire.on('showModal', () => {
                modal.show();
            });
            
            Livewire.on('hideModal', () => {
                modal.hide();
            });
            
            // Observar cambios en la propiedad showModal
            @this.watch('showModal', (value) => {
                if (value) {
                    modal.show();
                } else {
                    modal.hide();
                }
            });
            
            // Escuchar cuando se cierra el modal para actualizar la propiedad
            modalElement.addEventListener('hidden.bs.modal', () => {
                @this.$set('showModal', false);
            });
        });
    </script>
</div>
