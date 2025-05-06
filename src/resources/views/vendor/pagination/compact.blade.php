@if ($paginator->hasPages())
    <nav>
        <ul class="pagination compact">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="disabled"><span>&laquo;</span></li>
            @else
                <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a></li>
            @endif

            {{-- First 3 pages --}}
            @foreach (range(1, min(3, $paginator->lastPage())) as $i)
                @if ($i == $paginator->currentPage())
                    <li class="active"><span>{{ $i }}</span></li>
                @else
                    <li><a href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
                @endif
            @endforeach

            {{-- Dots if needed --}}
            @if ($paginator->lastPage() > 3 && $paginator->currentPage() <= 3)
                <li class="disabled"><span>…</span></li>
            @endif

            {{-- Current page if it's not in first 3 or last --}}
            @if ($paginator->currentPage() > 3 && $paginator->currentPage() < $paginator->lastPage())
                @if ($paginator->currentPage() > 4)
                    <li class="disabled"><span>…</span></li>
                @endif
                <li class="active"><span>{{ $paginator->currentPage() }}</span></li>
                <li class="disabled"><span>…</span></li>
            @endif

            {{-- Last page if it's beyond page 3 --}}
            @if ($paginator->lastPage() > 3)
                <li><a href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a></li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li><a href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a></li>
            @else
                <li class="disabled"><span>&raquo;</span></li>
            @endif
        </ul>
    </nav>
@endif 