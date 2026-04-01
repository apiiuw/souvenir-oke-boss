@if ($paginator->hasPages())
<nav class="flex justify-center mt-6">

    <ul class="inline-flex items-center gap-1 bg-white p-2 rounded-2xl shadow">

        {{-- PREVIOUS --}}
        @if ($paginator->onFirstPage())
            <li class="px-3 py-2 text-gray-300 cursor-not-allowed">
                ‹
            </li>
        @else
            <li>
                <a href="{{ $paginator->previousPageUrl() }}"
                   class="px-3 py-2 rounded-lg text-gray-600 hover:bg-pink-100 hover:text-pink-oke-boss transition">
                    ‹
                </a>
            </li>
        @endif

        {{-- NUMBER --}}
        @foreach ($elements as $element)
            @if (is_array($element))
                @foreach ($element as $page => $url)

                    @if ($page == $paginator->currentPage())
                        <li>
                            <span class="px-4 py-2 rounded-lg bg-pink-oke-boss text-white font-semibold shadow">
                                {{ $page }}
                            </span>
                        </li>
                    @else
                        <li>
                            <a href="{{ $url }}"
                               class="px-4 py-2 rounded-lg text-gray-700 hover:bg-pink-100 hover:text-pink-oke-boss transition">
                                {{ $page }}
                            </a>
                        </li>
                    @endif

                @endforeach
            @endif
        @endforeach

        {{-- NEXT --}}
        @if ($paginator->hasMorePages())
            <li>
                <a href="{{ $paginator->nextPageUrl() }}"
                   class="px-3 py-2 rounded-lg text-gray-600 hover:bg-pink-100 hover:text-pink-oke-boss transition">
                    ›
                </a>
            </li>
        @else
            <li class="px-3 py-2 text-gray-300 cursor-not-allowed">
                ›
            </li>
        @endif

    </ul>

</nav>
@endif
