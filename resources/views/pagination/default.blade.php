@if ($paginator->hasPages())


<ul data-plugin="paginator" data-total="50" data-skin="pagination-gap" class="pagination pagination-gap">

{{-- line:65  and line 71=> ld style is <span class="icon wb-chevron-left-mini "> , new is fa fa-chevron-left--}}

        @if ($paginator->onFirstPage())
           <li class="pagination-prev page-item disabled">
               <a class="page-link" href="javascript:void(0)" aria-label="Prev"><span class=" fa fa-chevron-left"></span></a>
           </li>        
        @else
            <li class="pagination-prev page-item">
               <a class="page-link" href="{{ $paginator->previousPageUrl() }}" aria-label="Prev"><span class="fa fa-chevron-left"></span></a>
           </li> 
            
        @endif
        
        @foreach ($elements as $element)

            @if (is_string($element))
            
               <li class="pagination-items page-item disabled" data-value="{{ $element }}">
                   <a class="page-link" href="javascript:void(0)">{{ $element }}</a>
               </li>
               
            @endif


            {{-- Array Of Links --}}

            @if (is_array($element))

                @foreach ($element as $page => $url)

                    @if ($page == $paginator->currentPage())

                       
                        <li class="pagination-items page-item active" data-value="{{ $page }}">
                           <a class="page-link" href="javascript:void(0)">{{ $page }}</a>
                        </li>

                    @else

              
                        <li class="pagination-items page-item" data-value="{{ $page }}">
                           <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                        
                    @endif

                @endforeach

            @endif

        @endforeach
        
        {{-- Next Page Link --}}
        
        {{-- line:65  and line 71=> ld style is <span class="icon wb-chevron-right-mini ">  , new is fa fa-chevron-right --}}

        @if ($paginator->hasMorePages())

            <li class="pagination-next page-item">
               <a class="page-link" href="{{ $paginator->nextPageUrl() }}" aria-label="Next"><span class=" fa fa-chevron-right"></span></a>
            </li>
        @else

    
            <li class="pagination-next page-item disabled">
               <a class="page-link" href="javascript:void(0)" aria-label="Next"><span class="fa  fa-chevron-right"></span></a>
           </li>
        @endif

</ul>

   
@endif