<div>
    @if ($paginator->hasPages())
        <div class="">
            <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-between">
                <button wire:click="previousPage" wire:loading.attr="disabled" rel="prev">
                    <span
                        class="pag__previous__next__link {{ $paginator->onFirstPage() ? "pag__previous__next__link__inactive" : "pag__previous__next__link__active" }} ">
                        Anterior
                    </span>
                </button>
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <span aria-disabled="true">
                            <span
                                class="relative border-none inline-flex items-center p-2 px-4 text-sm font-medium text-gray-700 bg-white border border-gray-300 cursor-default leading-5">{{ $element }}
                            </span>
                        </span>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li wire:click="gotoPage({{ $page }})"
                                        class="pag__link__active">
                                        {{ $page }}
                                    </li>
                                @else
                                    <li wire:click="gotoPage({{ $page }})"
                                        class="pag__link__inactive">
                                        {{ $page }}
                                    </li>
                                @endif
                        @endforeach
                    @endif
                @endforeach
                <button wire:click="nextPage" wire:loading.attr="disabled" rel="prev">
                    <span
                        class="pag__previous__next__link {{ !$paginator->hasMorePages() ? "pag__previous__next__link__inactive" : "pag__previous__next__link__active" }} ">
                        Siguiente
                    </span>
                </button>
            </nav>
        </div>
    @endif
</div>
