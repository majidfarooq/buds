@foreach ($pageSections as $pg)
  <div class='row text-center  ui-state-default' data-index="{{ $pg->id }}" data-position="{{ $pg->order }}">
    <div class='section-controls'>
      <a class='nav-item' data-id='{{$pg->id}}' onclick='deleteSection(this)' title='Delete'><span><i class='far fa-trash-alt'></i></span></a>
      <a class='nav-item' href='#collapseSection_{{$pg->id}}' data-toggle='collapse' role='button' aria-expanded='false' aria-controls='collapseCardExample' data-id='{{$pg->id}}' title='Edit'>
        <span><i class='fas fa-pencil-alt'></i></span>
      </a>
    </div>
    <div class='collapse section-collapse shadow bg-white text-left' id='collapseSection_{{$pg->id}}'>
      <div class='col-md-12'>
        <div class='form-group'>
          <label for='sectionClass'>CSS Class</label>
          <input type='text' value='{{$pg->e_class}}' class='form-control ' id='sectionClass' name='sectionClass'>
        </div>
        <div class='form-group'>
          <label for='sectionId'>CSS ID</label>
          <input type='text' value='{{$pg->e_id}}' class='form-control ' id='sectionId' name='sectionId'>
        </div>
        <div class='form-group'>
          <label for='width'>Content Width</label>
          <select class='form-control' name="width" id="width">
            <option value="container-fluid" {{ ( $pg->container_type == 'container-fluid') ? 'selected' : '' }}>{{ '100% Width' }}</option>
            <option value="container" {{ ( $pg->container_type == 'container') ? 'selected' : '' }}>{{ 'Site Width' }}</option>
          </select>
        </div>
      </div>
      <div class='col-md-12'>
        <div class='form-group'>
          <button type='button' class='btn btn-primary w-100 text-center' data-id='{{$pg->id}}'
                  onclick='updateSectionSelector(this)'>Save
          </button>
        </div>
      </div>
      <div class='col-md-12'>
        <div class='form-group'>
          <a type='button' href='#collapseSection_{{$pg->id}}' data-toggle='collapse' role='button'
             aria-expanded='false' data-id='{{$pg->id}}' class='btn btn-primary w-100 text-center'>Cancel</a>
        </div>
      </div>
    </div>

    @foreach ($pg->section->PageSubSections as $ss)
      <div class='col-md-{{$ss->row_width}} p-2 parent-col ui-state-default'>
        @isset($pg->subsection)
          @foreach ($pg->subsection as $subsection)

            @if ($subsection->sub_section_id == $ss->id)
              <div class="row mx-0 inner-row">
                @foreach ($subsection->section->PageSubSections as $pss)
                  <div class='col-md-{{$pss->row_width}} p-2 inner-col'>
                    <ul id="sortable" class="pl-0">
                      @foreach ($subsection->PageElements as $element)
                        @if ($pss->id == $element->sub_section_id && $element->element['type'] != 'daughter')
                          <li class="card shadow mb-4 ui-state-default"
                              data-index="{{ $element['id'] }}"
                              data-position="{{ $element['position'] }}">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between text-capitalize">
                              <h6 class="m-0 font-weight-bold text-primary w-100" data-id="{{ $element['id'] }}"
                                  onclick="editInnerElement(this)">{{ $element['element']['title'] }}</h6>
                              <div class="dropdown no-arrow">
                                <a class="font-weight-bold text-danger py-2 px-3"
                                   data-parentId="0"
                                   data-type="{{ 'parent' }}"
                                   data-id="{{ $element['id'] }}"
                                   onclick="deleteInnerElement(this)">
                                  <i class="fas fa-trash-alt"></i></a>
                                {{--                                <a class="dropdown-toggle" href="#" role="button"--}}
                                {{--                                   id="{{ 'dropdownMenuLink_'.$element['id'] }}"--}}
                                {{--                                   data-toggle="dropdown"--}}
                                {{--                                   aria-haspopup="true" aria-expanded="false">--}}
                                {{--                                  <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>--}}
                                {{--                                </a>--}}
                                {{--                                <div  class="dropdown-menu dropdown-menu-right shadow animated--fade-in"--}}
                                {{--                                  aria-labelledby="{{ 'dropdownMenuLink_'.$element['id'] }}">--}}
                                {{--                                  <div--}}
                                {{--                                    class="dropdown-header">{{ $element['element']['title'] }}</div>--}}
                                {{--                                  <a class="dropdown-item"--}}
                                {{--                                     href="#{{ 'collapseCard_'.$element['id'] }}"--}}
                                {{--                                     data-toggle="collapse" role="button"--}}
                                {{--                                     aria-expanded="false"--}}
                                {{--                                     aria-controls="collapseCardExample"--}}
                                {{--                                     data-id="{{ $element['id'] }}"--}}
                                {{--                                     onclick="editInnerElement(this)">Edit</a>--}}
                                {{--                                  <div class="dropdown-divider"></div>--}}
                                {{--                                  <a class="dropdown-item"--}}
                                {{--                                     data-parentId="0"--}}
                                {{--                                     data-type="{{ 'parent' }}"--}}
                                {{--                                     data-id="{{ $element['id'] }}"--}}
                                {{--                                     onclick="deleteInnerElement(this)">Delete</a>--}}
                                {{--                                </div>--}}

                              </div>
                            </div>
                          </li>
                        @endif
                      @endforeach
                    </ul>
                    <button class='btn btnNewElement' data-type='nested' data-id='{{$subsection->id}}'
                            data-sid='{{$pss->id}}' onclick='getElement(this)'>
                      <i class='fas fa-plus'></i>
                    </button>
                  </div>
                @endforeach
              </div>
            @endif
          @endforeach
        @endisset

        @isset($pg->PageElements)
          <ul id="sortable" class="pl-0">
            @foreach ($pg->PageElements as $element)
              @if ($element->sub_section_id == $ss->id && $element->element['type'] != 'daughter')
                <li class="card shadow mb-4 ui-state-default" data-index="{{ $element['id'] }}"
                    data-position="{{ $element['position'] }}">
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between text-capitalize">
                    <h6 class="m-0 font-weight-bold text-primary w-100" data-id="{{ $element['id'] }}"
                        onclick="editInnerElement(this)">{{ $element['element']['title'] }}</h6>
                    <div class="dropdown no-arrow">
                      <a class="font-weight-bold text-danger py-2 px-3"
                         data-parentId="0"
                         data-type="{{ 'parent' }}"
                         data-id="{{ $element['id'] }}"
                         onclick="deleteInnerElement(this)">
                        <i class="fas fa-trash-alt"></i></a>
                      {{--                      <a class="dropdown-toggle" href="#" role="button"--}}
                      {{--                         id="{{ 'dropdownMenuLink_'.$element['id'] }}" data-toggle="dropdown"--}}
                      {{--                         aria-haspopup="true" aria-expanded="false">--}}
                      {{--                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>--}}
                      {{--                      </a>--}}
                      {{--                      <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"--}}
                      {{--                           aria-labelledby="{{ 'dropdownMenuLink_'.$element['id'] }}">--}}
                      {{--                        <div class="dropdown-header">{{ $element['element']['title'] }}</div>--}}
                      {{--                        <a class="dropdown-item" href="#{{ 'collapseCard_'.$element['id'] }}"--}}
                      {{--                           data-toggle="collapse" role="button" aria-expanded="false"--}}
                      {{--                           aria-controls="collapseCardExample" data-id="{{ $element['id'] }}"--}}
                      {{--                           onclick="editInnerElement(this)">Edit</a>--}}
                      {{--                        <div class="dropdown-divider"></div>--}}
                      {{--                        <a class="dropdown-item"--}}
                      {{--                           data-parentId="0"--}}
                      {{--                           data-type="{{ 'parent' }}"--}}
                      {{--                           data-id="{{ $element['id'] }}"--}}
                      {{--                           onclick="deleteInnerElement(this)">Delete</a>--}}
                      {{--                      </div>--}}
                    </div>
                  </div>
                </li>
              @endif
            @endforeach
          </ul>
        @endisset
        <div class="col-12 px-0">
          <button class='btn btnNewElement' data-id='{{$pg->id}}' data-sid='{{$ss->id}}' data-type='inner'
                  onclick='getElement(this)'>
            <i class='fas fa-plus'></i>
          </button>
        </div>

      </div>
    @endforeach
  </div>
@endforeach
