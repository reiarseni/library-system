<div>
    @if ($paginator->hasPages())
        <nav class="biblioteca-paginacion-container" aria-label="Paginación">
            <ul class="biblioteca-paginacion">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="pagina-item disabled" aria-disabled="true">
                        <span class="pagina-link" aria-hidden="true"><i class="fas fa-chevron-left"></i></span>
                    </li>
                @else
                    <li class="pagina-item">
                        <button type="button" class="pagina-link" wire:click="previousPage('{{ $paginator->getPageName() }}')" wire:loading.attr="disabled" rel="prev" aria-label="@lang('pagination.previous')"><i class="fas fa-chevron-left"></i></button>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li class="pagina-item disabled" aria-disabled="true">
                            <span class="pagina-link">{{ $element }}</span>
                        </li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="pagina-item active" aria-current="page">
                                    <span class="pagina-link">{{ $page }}</span>
                                </li>
                            @else
                                <li class="pagina-item">
                                    <button type="button" class="pagina-link" wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')" wire:loading.attr="disabled">{{ $page }}</button>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="pagina-item">
                        <button type="button" class="pagina-link" wire:click="nextPage('{{ $paginator->getPageName() }}')" wire:loading.attr="disabled" rel="next" aria-label="@lang('pagination.next')"><i class="fas fa-chevron-right"></i></button>
                    </li>
                @else
                    <li class="pagina-item disabled" aria-disabled="true">
                        <span class="pagina-link" aria-hidden="true"><i class="fas fa-chevron-right"></i></span>
                    </li>
                @endif
            </ul>
        </nav>
        
        <style>
            /* Estilos modernos para la paginación de Livewire */
            .biblioteca-paginacion-container {
                display: flex;
                justify-content: center;
                margin-top: 2rem;
                margin-bottom: 1rem;
            }
            
            .biblioteca-paginacion {
                display: flex;
                list-style: none;
                padding: 0;
                margin: 0;
                gap: 0.25rem;
                border-radius: 0.5rem;
                box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            }
            
            .biblioteca-paginacion .pagina-item {
                margin: 0;
            }
            
            .biblioteca-paginacion .pagina-link {
                display: flex;
                align-items: center;
                justify-content: center;
                min-width: 2.5rem;
                height: 2.5rem;
                padding: 0 0.75rem;
                font-size: 0.9rem;
                border: none;
                color: #4a5568;
                background-color: #fff;
                border-radius: 0.375rem;
                transition: all 0.2s ease;
                cursor: pointer;
            }
            
            .biblioteca-paginacion .pagina-item:not(.active) .pagina-link:hover {
                background-color: #f7fafc;
                color: #2d3748;
                transform: translateY(-1px);
                box-shadow: 0 2px 5px rgba(0,0,0,0.08);
            }
            
            .biblioteca-paginacion .pagina-item.active .pagina-link {
                background-color: #4299e1;
                color: white;
                font-weight: 600;
                box-shadow: 0 2px 5px rgba(66, 153, 225, 0.3);
            }
            
            .biblioteca-paginacion .pagina-item.disabled .pagina-link {
                color: #a0aec0;
                pointer-events: none;
                background-color: #f7fafc;
            }
        </style>
    @endif
</div>
