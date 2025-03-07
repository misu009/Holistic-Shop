@if ($paginator->hasPages())
    <nav aria-label="Pagination" class="d-flex justify-content-center mt-4">
        <ul class="pagination pagination-lg d-flex flex-wrap justify-content-center" style="gap: 0.5rem;">
            <li class="page-item {{ $paginator->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link text-white bg-transparent border-0" href="{{ $paginator->previousPageUrl() }}"
                    aria-label="Previous">
                    &lt;
                </a>
            </li>

            @php
                $start = max($paginator->currentPage() - 1, 1);
                $end = min($paginator->currentPage() + 1, $paginator->lastPage());
                $firstPages = [1, 2];
                $lastPages = [$paginator->lastPage() - 1, $paginator->lastPage()];
                $pagesToShow = array_values(array_unique(array_merge($firstPages, range($start, $end), $lastPages))); // Reset keys
            @endphp

            @foreach ($pagesToShow as $key => $page)
                @if ($key > 0 && $pagesToShow[$key - 1] != $page - 1)
                    <li class="page-item disabled"><span class="page-link text-white bg-transparent border-0">...</span>
                    </li>
                @endif

                <li class="page-item {{ $paginator->currentPage() == $page ? 'active' : '' }}">
                    <a class="page-link border-0"
                        href="{{ $paginator->currentPage() == $page ? '#' : $paginator->url($page) }}"
                        style="color: {{ $paginator->currentPage() == $page ? '#70C8C3' : 'white' }}; background: none;">
                        {{ $page }}
                    </a>
                </li>
            @endforeach

            {{-- Next Page Link --}}
            <li class="page-item {{ $paginator->hasMorePages() ? '' : 'disabled' }}">
                <a class="page-link text-white bg-transparent border-0" href="{{ $paginator->nextPageUrl() }}"
                    aria-label="Next">
                    &gt;
                </a>
            </li>

        </ul>
    </nav>

    <style>
        @media (max-width: 768px) {

            /* For tablets and smaller */
            .pagination {
                gap: 0.3rem !important;
                /* Reduce space between page numbers */
            }

            .page-link {
                font-size: 0.9rem;
                /* Make text slightly smaller */
                padding: 0.3rem 0.6rem;
                /* Reduce padding for smaller screens */
            }
        }

        @media (max-width: 480px) {

            /* For mobile screens */
            .pagination {
                gap: 0.2rem !important;
                /* Even smaller gap */
            }

            .page-link {
                font-size: 0.8rem;
                /* Further reduce text size */
                padding: 0.2rem 0.5rem;
                /* Make buttons more compact */
            }
        }
    </style>
@endif
