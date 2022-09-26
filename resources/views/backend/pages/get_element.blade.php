{{--<ul class="section-nav">--}}
{{--  @foreach ($sections as $section)--}}
{{--    <li class="section-item {{ $section['url'] }}" data-index="{{ $section['id'] }}" data-structure="{{ $section['slug'] }}" data-parentId="{{ ($data['printId']) ? $data['printId'] : 0 }}" data-sid="{{ ($data['sid']) ? $data['sid'] : 0 }}" onclick="addSection(this)">--}}
{{--      @if ($section->slug == 'single-section')--}}
{{--        <div class="section_column section_column_layout_1_1">1/1</div>--}}
{{--      @elseif ($section->slug == 'double-section')--}}
{{--        <div class="section_column section_column_layout_1_2">1/2</div>--}}
{{--        <div class="section_column section_column_layout_1_2">1/2</div>--}}
{{--      @elseif ($section->slug == 'triple-section')--}}
{{--        <div class="section_column section_column_layout_1_3">1/3</div>--}}
{{--        <div class="section_column section_column_layout_1_3">1/3</div>--}}
{{--        <div class="section_column section_column_layout_1_3">1/3</div>--}}
{{--      @endif--}}
{{--    </li>--}}
{{--  @endforeach--}}
{{--</ul>--}}


@if ($data['type'] == "inner" )
  <ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
      <a class="nav-link @if($data['type'] == "inner" || $data['type'] == "nested") {{'active'}} @endif" id="design-elements" data-toggle="tab" href="#dElements" role="tab" aria-controls="dElements" aria-selected=" @if($data['type'] == "inner" || $data['type'] == "nested") {{'true'}} @endif">Design
        Elements</a>
    </li>
    <li class="nav-item" role="presentation">
      <a class="nav-link @if($data['type'] == "section") {{'active'}} @endif " id="nested-columns" data-toggle="tab" href="#nColumns" role="tab" aria-controls="nColumns" aria-selected="true">Nested
        Columns</a>
    </li>
  </ul>
@endif

<div class="tab-content" id="myTabContent">
  @if ($data['type'] != "section")
    <div class="tab-pane fade @if($data['type'] == "inner" || $data['type'] == "nested") {{'show active'}} @endif" id="dElements" role="tabpanel" aria-labelledby="design-elements">
      @if($elements)
        <ul class="section-nav float-left w-100 pl-0">
          @foreach($elements as $element)
            <li class="section-item" data-index="{{ ($element->id) ? $element->id: 0 }}" data-parentId="{{ ($data['printId']) ? $data['printId'] : 0 }}" data-sid="{{ ($data['sid']) ? $data['sid'] : 0 }}" onclick="addInnerElement(this)">
              <div class="section_column section_column_layout_1_1 text-capitalize">{{ ($element->title) ? $element->title : ''}}</div>
            </li>
          @endforeach
        </ul>
      @endif
    </div>
  @endif
  @if ($data['type'] != "nested")
    <div class="tab-pane fade @if($data['type'] == "section") {{'show active'}} @endif " id="nColumns" role="tabpanel" aria-labelledby="nested-columns">
      <ul class="section-nav float-left w-100 pl-0">
        @foreach ($sections as $section)
          <li class="section-item {{ $section['url'] }}" data-index="{{ $section['id'] }}" data-structure="{{ $section['slug'] }}" data-parentId="{{ ($data['printId']) ? $data['printId'] : 0 }}" data-sid="{{ ($data['sid']) ? $data['sid'] : 0 }}" onclick="addSection(this)">
            @if ($section->slug == 'single-section')
              <div class="section_column section_column_layout_1_1">1/1</div>
            @elseif ($section->slug == 'double-section')
              <div class="section_column section_column_layout_1_2">1/2</div>
              <div class="section_column section_column_layout_1_2">1/2</div>
            @elseif ($section->slug == 'triple-section')
              <div class="section_column section_column_layout_1_3">1/3</div>
              <div class="section_column section_column_layout_1_3">1/3</div>
              <div class="section_column section_column_layout_1_3">1/3</div>
            @endif
          </li>
        @endforeach
      </ul>
    </div>
  @endif
</div>
