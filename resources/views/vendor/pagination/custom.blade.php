@if ($paginator->hasPages())
    <div class="mt-8 flex flex-col items-center gap-6">
        <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center gap-4">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="px-8 py-4 rounded-2xl bg-gray-50 text-gray-300 text-[11px] font-black uppercase tracking-[0.2em] italic border border-gray-100 cursor-not-allowed">
                    &larr; Previous
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="px-8 py-4 rounded-2xl bg-white text-gray-900 text-[11px] font-black uppercase tracking-[0.2em] italic border border-gray-100 hover:bg-gray-900 duration-300 hover:text-white transition-all shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    &larr; Previous
                </a>
            @endif

            {{-- Pagination Elements --}}
            <div class="flex items-center gap-3 mx-2">
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <span class="px-2 text-gray-300 font-black italic">...</span>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span class="h-12 w-12 flex items-center justify-center rounded-2xl bg-indigo-600 text-white text-[13px] font-black italic shadow-lg shadow-indigo-500/30">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}" class="h-12 w-12 flex items-center justify-center rounded-2xl bg-white text-gray-900 text-[13px] font-black hover:text-indigo-600 transition-all italic tracking-tighter hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="px-8 py-4 rounded-2xl bg-white text-gray-900 text-[11px] font-black uppercase tracking-[0.2em] italic border border-gray-100 hover:bg-gray-900 duration-300 hover:text-white transition-all shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Next &rarr;
                </a>
            @else
                <span class="px-8 py-4 rounded-2xl bg-gray-50 text-gray-300 text-[11px] font-black uppercase tracking-[0.2em] italic border border-gray-100 cursor-not-allowed">
                    Next &rarr;
                </span>
            @endif
        </nav>

        <div class="text-[11px] font-black text-slate-400 uppercase tracking-widest italic flex items-center gap-2">
            <span class="text-slate-500">EMPLOYEE DIRECTORY</span>
            <span class="text-slate-300">|</span>
            <span>SHOWING {{ $paginator->firstItem() }}-{{ $paginator->lastItem() }} OF {{ $paginator->total() }}</span>
        </div>
    </div>
@endif
