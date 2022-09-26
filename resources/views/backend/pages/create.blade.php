@extends('backend.layouts.app')

@section('style')
  <style>
      img#current_banner {
          width: 100%;
          height: 100px;
          object-fit: cover;
          border: 1px solid #4e73df;
      }
  </style>
@endsection

@section('content')

  <div class="row">
    <div class="col-12">
      <div class="card border-0">
        @if ($message = \Illuminate\Support\Facades\Session::get('error'))
          <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
          </div>
        @elseif ($message = \Illuminate\Support\Facades\Session::get('success'))
          <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
          </div>
      @endif
      <!--end card-body-->
      </div>
    </div>
    <!--end col-->
  </div>

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ ($page->isPage == 1) ?  'Update Page' : 'New Page' }}</h1>
    <a href="{{route('admin.pages.index')}}"
       class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Back</a>
  </div>
  <!-- Content Column -->

  <ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
      <a class="nav-link active" id="pageBasics-tab" data-toggle="tab" href="#pageBasics" role="tab" aria-controls="pageBasics" aria-selected="true">Page Settings</a>
    </li>
    <li class="nav-item" role="presentation">
      <a class="nav-link" id="pageContent-tab" data-toggle="tab" href="#pageContent" role="tab" aria-controls="pageContent" aria-selected="false">Page Content</a>
    </li>
  </ul>

  <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="pageBasics" role="tabpanel" aria-labelledby="pageBasics-tab">
      <div class="card shadow my-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">{{ ($page->isPage == 1) ?  'Update Page' : 'Create New Page' }}</h6>
        </div>
        <div class="card-body">
          <div class="col-12 p-0">
            <div class="row m-0">
              {!! Form::open(["route" => ["admin.pages.update",$page->slug],"files"=> true,"class"=>"w-100","method"=>"PUT"]) !!}
              <input type="hidden" value="{{$page->id}}" name="pageId" id="pageId">
              <div class="row m-0">
                <div class="col-md-12 text-right">
                  <div class="form-group">
                    <input class="btn btn-primary" id="submit" type="submit" value="{{ ($page->isPage == 1) ?  'Update Page' : 'Create Page' }}">
                  </div>
                </div>
                <div class="col-lg-6 p-0">
                  <div class="row m-0">
                    @isset($page->banner)
                      <div class="col-md-5">
                        <div class="form-group">
                          <label for="current_banner">Current Banner</label>
                          <div class="w-100">
                            <img width="100"
                                 src="{{(isset($page->banner) ? asset($page->banner) : asset('/public/storage/placeholder.jpg'))}}"
                                 alt="Current Banner" id="current_banner">
                          </div>
                        </div>
                      </div>
                    @endisset
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="banner">Change Banner</label>
                        <input autocomplete="banner" autofocus class="form-control @error('banner') is-invalid @enderror" id="banner" name="banner" type="file">
                        @error('banner')
                        <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                        @enderror
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="page_type">Page Type</label>
                        <select class="form-control" id="page_type" name="page_type">
                          @foreach($page->types as $type)
                            <option value="{{$type}}" {{ ($page->page_type) === $type ? 'selected' : '' }}>{{$type}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="banner_content">Change Banner Content</label>
                      <textarea class="form-control editor @error('banner_content') is-invalid @enderror"
                                name="banner_content" id="banner_content" cols="2"
                                rows="2">{!! $page->banner_content !!}</textarea>
                      @error('banner_content')
                      <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                      @enderror
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="page_css">Page Css</label>
                      <textarea class="form-control @error('page_css') is-invalid @enderror" cols="2" id="page_css" name="page_css" rows="2">{{ $page->page_css }}</textarea>
                      @error('page_css')
                      <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                      @enderror
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="page_script">Page Script</label>
                      <textarea class="form-control @error('page_script') is-invalid @enderror" cols="2" id="page_script" name="page_script" rows="2">{{ $page->page_script }}</textarea>
                      @error('page_script')
                      <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                      @enderror
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 p-0">
                  <div class="row m-0">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="title">Title</label>
                        <input autocomplete="title" autofocus class="form-control @error('title') is-invalid @enderror" id="title" value="{{$page->title}}" name="title" type="text">
                        @error('title')
                        <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                        @enderror
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="meta_title">Meta Title</label>
                        <input type="text" value="{{$page->meta_title}}"
                               class="form-control @error('meta_title') is-invalid @enderror"
                               id="meta_title" name="meta_title">
                        @error('meta_title')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                        @enderror
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="meta_keywords">Meta Keywords</label>
                        <input type="text" value="{{$page->meta_keywords}}"
                               class="form-control @error('meta_keywords') is-invalid @enderror"
                               id="meta_keywords"
                               name="meta_keywords">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                        @enderror
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="password_confirmation">Meta Description</label>
                        <textarea class="form-control @error('meta_description') is-invalid @enderror"
                                  name="meta_description" id="meta_description" cols="3"
                                  rows="3">{{$page->meta_description}}</textarea>
                        @error('meta_description')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                        @enderror
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="is_home">Is Home</label>
                        <select class="form-control @error('is_home') is-invalid @enderror" name="is_home" id="is_home">
                          <option value="1" {{ $page->is_home == 1 ? 'selected' : '' }}>Yes</option>
                          <option value="0" {{ $page->is_home == 0 ? 'selected' : '' }}>No</option>
                        </select>
                        @error('is_home')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                        @enderror
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="is_disabled">Is Disabled</label>
                        <select class="form-control @error('is_disabled') is-invalid @enderror"
                                name="is_disabled" id="is_disabled">
                          <option value="0">No</option>
                          <option value="1">Yes</option>
                        </select>

                        @error('banner_image')
                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                        @enderror
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              {!! Form::close() !!}
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="tab-pane fade" id="pageContent" role="tabpanel" aria-labelledby="pageContent-tab">
      <div class="card shadow my-4 thisContainer" id="thisContainer">
        <div class="card-header py-3 text-center">
          <h3>To get started, add a Container.</h3>
          <h4 class="mb-3">The building process always starts with a container, then columns, then elements.</h4>
          <button type="submit" class="btn btn-primary" data-id='0' data-sid='0' data-type='section' onclick="getElement(this)">
            <i class="fas fa-plus"></i> Container
          </button>
        </div>
        <div class="card-body" id="sortable_row">
        </div>
      </div>
    </div>
  </div>

  <!-- Begin Page Content -->
  <!-- Content Column -->

  <div class="modal fade" id="addElements" tabindex="-1" role="dialog" aria-labelledby="addElementsTitle"
       aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addElementsTitle">Add Element</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body"></div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('script')

  @include('flashy::message')

  <!-- Tinymce Scripts-->
  <script type="application/javascript" src="{{ asset('public/assets/backend/tinymce/tinymce.min.js') }}"></script>
  <script type="text/javascript">
      $(document).ready(function () {
          getPageSections();
          setTimeout(function () {
              setParentSortable();
          }, 3000);
      });

      // Loading already saved Elements
      function getPageSections() {
          var pageId = $("#pageId").val();
          $.ajax({
              url: "{{ URL::route('admin.getPageSections') }}",
              type: 'post',
              data: {
                  "_token": "{{ csrf_token() }}",
                  pageId: pageId
              },
              success: function (data) {
                  $('.thisContainer').find(".card-body").html(data.success);
                  console.log(data);
              },
          });
      }

      // Ordering/Positioning of Sections
      function setParentSortable() {
          $("#sortable_row").sortable({
              update: function (event, ui) {
                  $(this).children().each(function (index) {
                      if ($(this).attr('data-position') != (index + 1)) {
                          $(this).attr('data-position', (index + 1)).addClass('updated');
                      }
                  });
                  saveParentOrder();
              }
          });
      }

      function saveParentOrder() {
          var orders = [];
          $('.updated').each(function () {
              orders.push([$(this).attr('data-index'), $(this).attr('data-position')]);
              $(this).removeClass('updated');
          });
          $.ajax({
              url: "{{ URL::route('admin.parent.order') }}",
              type: 'post',
              data: {
                  "_token": "{{ csrf_token() }}",
                  orders: orders
              },
              success: function (data) {
                  if (data.success) {
                      getPageSections();
                      var position = 'Position Updated';
                      success(position);
                  } else {
                      fail(data);
                  }
              },
          });

      }

      function removeLoader() {
          $("#loadingDiv").fadeOut(500, function () {
              // fadeOut complete. Remove the loading div
              $("#loadingDiv").remove(); //makes page more lightweight
          });
      }

      function runLoader() {
          $('body').append('<div id="loadingDiv" class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>');
      }

      // Getting Add button Modal
      function getElement(elem) {
          var parentId = $(elem).data("id");
          var sid = $(elem).data("sid");
          var type = $(elem).data("type");
          $.ajax({
              url: "{{ URL::route('admin.getElement') }}",
              type: 'post',
              data: {
                  "_token": "{{ csrf_token() }}",
                  type: type,
                  parentId: parentId,
                  sid: sid,
              },
              beforeSend: function () {
                  runLoader();
              },
              success: function (data) {
                  if (data.success) {
                      removeLoader();
                      $('#addElements').find(".modal-body").html(data.success);
                      $('#addElements').modal().show();
                  } else {
                      fail(data);
                  }
              },
          });
      }

      // SECTION
      //Add Section
      function addSection(elem) {
          var id = $(elem).data("index");
          var slug = $(elem).data("structure");
          var pageId = $("#pageId").val();
          var parentId = $(elem).data("parentid");
          var sid = $(elem).data("sid");
          $.ajax({
              url: "{{ URL::route('admin.addSection') }}",
              type: 'post',
              data: {
                  "_token": "{{ csrf_token() }}",
                  id: id,
                  slug: slug,
                  pageId: pageId,
                  parentId: parentId,
                  sid: sid,
              },
              beforeSend: function () {
                  runLoader();
              },
              success: function (data) {
                  if (data.success) {
                      removeLoader();
                      $('#addElements').modal('hide');
                      $('#addElements').find(".modal-body").html();
                      getPageSections();
                  } else {
                      fail(data);
                  }
              },
          });
      }

      //Delete Section
      function deleteSection(elem) {
          var id = $(elem).data("id");
          if (confirm('Are you sure you want to delete?')) {
              $.ajax({
                  url: "{{ URL::route('admin.delete.section') }}",
                  type: 'post',
                  data: {
                      "_token": "{{ csrf_token() }}",
                      id: id
                  },
                  beforeSend: function () {
                      runLoader();
                  },
                  success: function (data) {
                      if (data.success) {
                          removeLoader();
                          success(data.success);
                          getPageSections();
                      } else {
                          fail(data);
                      }
                  },
              });
          }
      }

      //Update Section properties
      function updateSectionSelector(elem) {
          var id = $(elem).data("id");
          var parent = $(elem).closest('.section-collapse');
          var cssClass = parent.find("#sectionClass").val();
          var cssId = parent.find("#sectionId").val();
          var width = parent.find("#width").val();
          parent.removeClass('show')
          $.ajax({
              url: "{{ URL::route('admin.changeSelector') }}",
              type: 'post',
              data: {
                  "_token": "{{ csrf_token() }}",
                  id: id,
                  cssClass: cssClass,
                  cssId: cssId,
                  width: width
              },
              success: function (data) {
                  if (data.success) {
                      success(data.success);
                  } else {
                      fail(data);
                  }
              },
          });

      }

      // ELEMENT
      //Add Element
      function addInnerElement(elem) {
          var elementId = $(elem).data("index"); //
          var pageId = $("#pageId").val(); // pageId
          var parentId = $(elem).data("parentid"); // page_sectionId
          var sid = $(elem).data("sid"); // sub_section
          $.ajax({
              url: "{{ URL::route('admin.storeInnerElement') }}",
              type: 'post',
              data: {
                  "_token": "{{ csrf_token() }}",
                  elementId: elementId,
                  parentId: parentId,
                  sid: sid,
                  pageId: pageId
              },
              beforeSend: function () {
                  runLoader();
              },
              success: function (data) {
                  if (data.success) {
                      removeLoader();
                      $('#addElements').modal('hide');
                      $('#addElements').find(".modal-body").html();
                      getPageSections();
                  } else {
                      fail(data);
                  }
              },
          });
      }

      //Delete Element
      function deleteInnerElement(elem) {
          var id = $(elem).data("id");
          var type = $(elem).data("type");
          var prentId = $(elem).data("parentid");
          if (confirm('Are you sure you want to delete?')) {
              $.ajax({
                  url: "{{ URL::route('admin.element.delete') }}",
                  type: 'post',
                  data: {
                      "_token": "{{ csrf_token() }}",
                      id: id,
                      type: type,
                      prentId: prentId,
                  },
                  beforeSend: function () {
                      runLoader();
                  },
                  success: function (data) {
                      console.log(data);
                      if (data.success) {
                          removeLoader();
                          if (type == 'parent') {
                              success(data.success);
                              getPageSections();
                          } else {
                              getChildPageElement(prentId);
                          }
                      } else {
                          fail(data);
                          getPageSections();
                      }
                  },
              });
          }
      }

      //Get Update Element Form
      function editInnerElement(elem) {
          var id = $(elem).data("id");
          $.ajax({
              url: "{{ URL::route('admin.editInnerElement') }}" + "/" + id,
              type: 'get',
              "_token": "{{ csrf_token() }}",
              beforeSend: function () {
                  runLoader();
              },
              success: function (data) {
                  removeLoader();
                  $('#addElements').find(".modal-body").html(data);
                  $('#addElements').modal().show();
              },
          });
      }

      // Update Element
      function updateInnerElement(id) {
          var updateElement = $('form#updateElement_' + id);
          var pageElementId = updateElement.data('id');
          tinyMCE.triggerSave(true, true);
          event.preventDefault();
          var data = new FormData($('form#updateElement_' + id)[0]);
          $.ajax({
              processData: false,
              contentType: false,
              data: data,
              dataType: 'json',
              type: 'post',
              url: "{{ URL::route('admin.updateInnerElement') }}",
              beforeSend: function () {
                  runLoader();
              },
              success: function (response) {
                  if (response.success) {
                      removeLoader();
                      if (pageElementId == 0) {
                          $('#addElements').modal('hide');
                          $('#addElements').find(".modal-body").html();
                          getPageSections();
                      } else {
                          getChildPageElement(pageElementId);
                      }
                      success(response.success);

                  } else {
                      $('#addElements').modal('hide');
                      $('#addElements').find(".modal-body").html();
                      fail(response);
                  }
              }
          });
      }

      function storeChildPe(elem) {
          var pageEid = $(elem).data("pageeid");
          $.ajax({
              url: "{{ URL::route('admin.storeChildPe') }}",
              type: 'post',
              data: {
                  "_token": "{{ csrf_token() }}",
                  pageEid: pageEid,
              },
              beforeSend: function () {
                  runLoader();
              },
              success: function (data) {
                  if (data.success) {
                      removeLoader();
                      success(data.success);
                      getChildPageElement(pageEid);
                  } else {
                      fail(data);
                  }

              }
          });
      }

      function getChildPageElement(id) {
          $.ajax({
              url: "{{ URL::route('admin.getChildPageElement') }}",
              type: 'post',
              data: {
                  "_token": "{{ csrf_token() }}",
                  id: id,
              },
              beforeSend: function () {
                  runLoader();
              },
              success: function (data) {
                  if (data.success) {
                      removeLoader();
                      $('#childPageElement').html(data.success);
                  } else {
                      fail(data);
                  }
              }
          });
      }

      function success(data) {
          $('.messages').html('<div class="alert alert-success mt-4 mb-4 p-2">' +
              '<button type="button" class="close" data-dismiss="alert">×</button>' +
              '<strong>' + data + '</strong>' +
              '</div>');
      }

      function fail(data) {
          $('.messages').html('<div class="alert alert-danger mt-4 mb-4 p-2">' +
              '<button type="button" class="close" data-dismiss="alert">×</button>' +
              '<strong>' + data + '</strong>' +
              '</div>');
      }

      tinymce.init({
          selector: '.editor',
          extended_valid_elements: 'i[class]',
          height: "180",
          forced_root_block: "",
          force_br_newlines: false,
          force_p_newlines: false,
          toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
          relative_urls: false,
          remove_script_host: false,
          convert_urls: false,
          plugins: [
              "advlist autolink lists link image charmap print preview hr anchor pagebreak",
              "searchreplace wordcount visualblocks visualchars code fullscreen",
              "insertdatetime media nonbreaking save table directionality",
              "emoticons template paste textpattern"
          ],
      });

      // Prevent bootstrap dialog from blocking focusin
      $(document).on('focusin', function (e) {
          if ($(e.target).closest(".tox-tinymce-aux, .moxman-window, .tam-assetmanager-root").length) {
              e.stopImmediatePropagation();
          }
      });
  </script>
@endsection

