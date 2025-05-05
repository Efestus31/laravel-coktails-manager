@if ($paginator->hasPages())
    {{-- Nav semplificato: un solo contenitore flex centrato --}}
    <nav class="d-flex justify-content-center my-4" aria-label="Pagination Navigation">
        {{-- Mobile: prev/next testuale --}}
        <ul class="pagination pagination-sm pagination-dark justify-content-center small d-flex d-sm-none">
            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled"><span class="page-link">@lang('pagination.previous')</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}">@lang('pagination.previous')</a></li>
            @endif
            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}">@lang('pagination.next')</a></li>
            @else
                <li class="page-item disabled"><span class="page-link">@lang('pagination.next')</span></li>
            @endif
        </ul>

        {{-- Desktop: numeri e frecce --}}
        <ul class="pagination pagination-sm pagination-dark justify-content-center small d-none d-sm-flex mb-0">
            {{-- Previous icon --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled"><span class="page-link">&lsaquo;</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}">&lsaquo;</a></li>
            @endif

            {{-- Numbered links --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next icon --}}
            @if ($paginator->hasMorePages())
                <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}">&rsaquo;</a></li>
            @else
                <li class="page-item disabled"><span class="page-link">&rsaquo;</span></li>
            @endif
        </ul>
    </nav>
@endif
