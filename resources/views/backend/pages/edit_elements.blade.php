<form id="updateElement_{{ $pageElements['id'] }}" data-id="0" onsubmit="updateInnerElement({{ $pageElements['id'] }})">
  <input type="hidden" name="elementId" value="{{ $pageElements['id'] }}">
  @csrf
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="class_{{$pageElements->id}}">Css Class</label>
        <input type="text" class="form-control" id="class_{{$pageElements->id}}" name="class" value="{{ ($pageElements['e_class']) ? $pageElements['e_class'] : '' }}">
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="id_{{$pageElements->id}}">Css Id</label>
        <input type="text" class="form-control" id="id_{{$pageElements->id}}" name="id" value="{{ ($pageElements['e_id']) ? $pageElements['e_id'] : '' }}">
      </div>
    </div>

    @foreach ($pageElements['content'] as $cont)
      <div class="col">
        @if ($cont['field']['type'] == "attachment")
          <div class="w-100">
            <label>{{ $cont['field']['title'] }}</label>
            <img class="w-100" src="{{ asset($cont['content']) }}" id="img_{{ $cont['id'] }}" alt="{{ $cont['field']['title'] }}" width="{{ ($cont['content']) ? '100px' : '200px' }}">
          </div>
          <div class="form-group">
            <label for="file_{{ $cont['id'] }}">{{ $cont['field']['title'] }}</label>
            <input type="file" class="form-control" id="file_{{ $cont['id'] }}" name="file_{{ $cont['id'] }}">
          </div>
        @elseif ($cont['field']['type'] == "textarea")
          <div class="form-group">
            <label for="ta_{{ $cont['id'] }}">{{ $cont['field']['title'] }}</label>
            <textarea class="form-control editElement" id="ta_{{ $cont['id'] }}" name="ta_{{ $cont['id'] }}" rows="10">{!! $cont['content'] !!}</textarea>
          </div>
        @elseif ($cont['field']['type'] == "text")
          <div class="form-group">
            <label for="tf_{{ $cont['id'] }}">{{ $cont['field']['title'] }}</label>
            <textarea class="form-control" id="tf_{{ $cont['id'] }}" name="tf_{{ $cont['id'] }}" rows="5">{!! $cont['content'] !!}</textarea>
          </div>
        @endif
      </div>
    @endforeach
  </div>

  <div class="col-md-12">
    <div class="form-group">
      <button type="submit" class="btn btn-primary">Update</button>
    </div>
  </div>
</form>

@if ($pageElements->element->type == 'parent')
  <div class="col-12 my-2">
    <button type="button" data-divId="#{{ $pageElements->element->title.'_'.$pageElements['id'] }}"
            data-pageEId="{{ $pageElements['id'] }}" onclick="storeChildPe(this)"
            class="btn btn-primary"><strong>+</strong> {{$pageElements->element->title}}</button>
    <div id="childPageElement">
    </div>
    <script> setTimeout(function () {
            getChildPageElement({{$pageElements->id}});
        }, 1000); </script>
  </div>
@endif

<!-- Tinymce Scripts-->
<script type="application/javascript" src="{{ asset('public/assets/backend/tinymce/tinymce.min.js') }}"></script>
<script type="application/ecmascript">
    tinymce.init({
        selector: '.editElement',
        extended_valid_elements: 'i[class]',
        forced_root_block: "",
        force_br_newlines: false,
        force_p_newlines: false,
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
        relative_urls: false,
        remove_script_host: false,
        convert_urls: false,
        // plugins: ["colorpicker contextmenu directionality emoticons fullpage fullscreen help hr image imagetools importcss insertdatetime legacyoutput link lists media nonbreaking noneditable pagebreak paste preview print quickbars save searchreplace spellchecker tabfocus table template textcolor textpattern toc visualblocks visualchars wordcount advlist anchor autolink autoresize autosave bbcode charmap code codesample"],
        plugins: [ "advlist autolink lists link image charmap print preview hr anchor pagebreak searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking save table directionality emoticons template paste textpattern"],
    });
</script>


{{--<div class="row m-0">--}}
{{--    <div class="col-md-12">--}}
{{--        <form id="storeElement" action="{{ route('store.element') }}" enctype="multipart/form-data" method="POST">--}}
{{--            @csrf--}}
{{--            <input type="hidden" value="{{ $data['pageId'] }}" name="pageId">--}}
{{--            <input type="hidden" value="{{ $data['elements']['id'] }}" name="elementId">--}}
{{--            @foreach ($data['elements']['fields'] as $fields)--}}
{{--                <div class="col-md-12">--}}
{{--                    <div class="form-group">--}}
{{--                        @if ($fields['type'] == 'attachment')--}}
{{--                            <label for="file_{{$fields['id']}}">{{ $fields['title'] }}</label>--}}
{{--                            <input type="file" autofocus class="form-control" id="file_{{$fields['id']}}"--}}
{{--                                   name="file_{{$fields['id']}}">--}}
{{--                        @elseif ($fields['type'] == 'textarea')--}}
{{--                            <label for="ta_{{$fields['id']}}">{{$fields['title']}}</label>--}}
{{--                            <textarea class="form-control elementEditor" id="ta_{{$fields['id']}}"--}}
{{--                                      name="ta_{{$fields['id']}}" rows="10">{{$fields['title']}}</textarea>--}}
{{--                        @elseif ($fields['type'] == 'text')--}}
{{--                            <label for="tf_{{$fields['id']}}">{{$fields['title']}}</label>--}}
{{--                            <textarea class="form-control elementEditor" id="tf_{{$fields['id']}}"--}}
{{--                                      name="tf_{{$fields['id']}}" rows="10">{{$fields['title']}}</textarea>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @endforeach--}}
{{--            <div class="col-md-12">--}}
{{--                <div class="form-group">--}}
{{--                    <input class="btn btn-primary" id="submit" type="submit" onclick="storeElement(this)"--}}
{{--                           value="Create Element">--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </form>--}}
{{--    </div>--}}
{{--</div>--}}

