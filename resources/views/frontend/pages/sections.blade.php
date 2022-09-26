@if (isset($page))
  @foreach ($page->pageSections as $pg)
    <div class="{{ ($pg->container_type) ? $pg->container_type : '' }} mb-4 {{ ($pg->e_class) ? $pg->e_class : '' }}" id="{{ ($pg->e_id) ? $pg->e_id : '' }}">
      <div class='row mx-0 '>
        @foreach ($pg->section->PageSubSections as $ss)
          <div class='col-md-{{$ss->row_width}} parent-col'>
            @isset($pg->subsection)
              @foreach ($pg->subsection as $subsection)
                @if ($subsection->sub_section_id == $ss->id)
                  <div class="row mb-4">
                    @foreach ($subsection->section->PageSubSections as $pss)
                      <div class='col-md-{{$pss->row_width}}'>
                        @isset($subsection->PageElements)
                          <?php
                          $pageContent = '';
                          foreach ($subsection->PageElements as $pSubE) {
                          if ($pss->id == $pSubE->sub_section_id && $pSubE['element']['type'] != 'daughter') {
                          ?>
                          @include('frontend.pages.element',['pageElement'=>$pSubE])
                          <?php }} ?>
                          @isset($pContent)
                            {!! isset($pContent) ? $pContent : '' !!}
                          @endisset
                        @endisset
                      </div>
                    @endforeach
                  </div>
                @endif
              @endforeach
            @endisset

            @isset($pg->PageElements)
              <?php
              $pageContent = '';
              foreach ($pg->PageElements as $pgE) {
              if ($pgE->sub_section_id == $ss->id && $pgE['element']['type'] != 'daughter') {
              ?>
              @include('frontend.pages.element',['pageElement'=>$pgE])
              <?php }} ?>
              @isset($pageContent)
                {!! isset($pageContent) ? $pageContent : '' !!}
              @endisset
            @endisset
          </div>
        @endforeach
      </div>
    </div>
  @endforeach
@endisset