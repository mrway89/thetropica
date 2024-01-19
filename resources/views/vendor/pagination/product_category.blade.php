@if ($paginator->hasPages())
<div class="paging-first pull-left mr-2"><a href="{{ $paginator->toArray()['first_page_url'] }}">First</a></div>
    <ul class="paging-product pull-left  mr-2">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="disabled"><a href=""><i class="fa fa-caret-left"></i></a></li>
        @else
            <li><a href="{{ $paginator->previousPageUrl() }}"><i class="fa fa-caret-left"></i></a></li>
        @endif

        @if($paginator->currentPage() > 3)
            <li><a href="{{ $paginator->url(1) }}">1</a></li>
        @endif
        @if($paginator->currentPage() > 4)
            <li><a>...</a></li>
        @endif
        @foreach(range(1, $paginator->lastPage()) as $i)
            @if($i >= $paginator->currentPage() - 2 && $i <= $paginator->currentPage() + 2)
                @if ($i == $paginator->currentPage())
                    <li class="active"><a href="">{{ $i }}</a></li>
                @else
                    <li><a href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
                @endif
            @endif
        @endforeach
        @if($paginator->currentPage() < $paginator->lastPage() - 3)
            <li><a>...</a></li>
        @endif
        @if($paginator->currentPage() < $paginator->lastPage() - 2)
            <li><a href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a></li>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}"><i class="fa fa-caret-right"></i></a></li>
        @else
            <li class="disabled"><a href=""><i class="fa fa-caret-right"></i></a></li>
        @endif
    </ul>
    <div class="paging-last pull-left"><a href="{{ $paginator->toArray()['last_page_url'] }}">Last</a></div>
@endif
