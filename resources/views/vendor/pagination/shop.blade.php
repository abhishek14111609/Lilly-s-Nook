@if ($paginator->hasPages())
    <nav class="shop-pagination-nav" aria-label="Pagination">
        <div class="shop-pagination-summary">
            <span>Showing</span>
            <strong>{{ $paginator->firstItem() }}</strong>
            <span>to</span>
            <strong>{{ $paginator->lastItem() }}</strong>
            <span>of</span>
            <strong>{{ $paginator->total() }}</strong>
            <span>results</span>
        </div>

        <ul class="shop-pagination-list">
            @if ($paginator->onFirstPage())
                <li class="disabled" aria-disabled="true" aria-label="Previous">
                    <span class="shop-pagination-link">&lsaquo;</span>
                </li>
            @else
                <li>
                    <a class="shop-pagination-link" href="{{ $paginator->previousPageUrl() }}" rel="prev"
                        aria-label="Previous">
                        &lsaquo;
                    </a>
                </li>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="disabled" aria-disabled="true"><span
                            class="shop-pagination-link">{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active" aria-current="page"><span
                                    class="shop-pagination-link">{{ $page }}</span></li>
                        @else
                            <li><a class="shop-pagination-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li>
                    <a class="shop-pagination-link" href="{{ $paginator->nextPageUrl() }}" rel="next"
                        aria-label="Next">
                        &rsaquo;
                    </a>
                </li>
            @else
                <li class="disabled" aria-disabled="true" aria-label="Next">
                    <span class="shop-pagination-link">&rsaquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
