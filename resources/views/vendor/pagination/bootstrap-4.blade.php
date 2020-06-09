@if ($paginator->hasPages())
    <nav class="my-3">
        <ul style="list-style-type: none;display: flex;flex-direction: row-reverse;">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="disabled" aria-disabled="true" aria-label="قبلی">
                    <span class="right-horizon bg-dark-gray py-2 px-3" aria-hidden="true">&rsaquo;</span>
                </li>
            @else
                <li>
                    <a class="right-horizon bg-dark-gray py-2 px-3" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="قبلی">&rsaquo;</a>
                </li>
            @endif


            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="disabled" aria-disabled="true"><span class="bg-dark-gray py-2 px-3">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li aria-current="page"><span class="bg-gray py-2 px-3">{{ $page }}</span></li>
                        @else
                            <li><a class="bg-dark-gray py-2 px-3" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a class="bg-dark-gray left-horizon py-2 px-3" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="بعدی">&lsaquo;</a>
                </li>
            @else
                <li class="disabled" aria-disabled="true" aria-label="بعدی">
                    <span class="bg-dark-gray left-horizon py-2 px-3" aria-hidden="true">&lsaquo;</span>
                </li>
            @endif

        </ul>
    </nav>
@endif
