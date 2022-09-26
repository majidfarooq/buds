@php $conter=1; @endphp
@if ($childrens->isNotEmpty())
  <ul class="list-group my-2">
    @foreach($childrens as $children)
      <li class="list-group-item my-1" data-index='{{$children->id}}' data-position='{{$children->position}}'>
        <div class=""><span>{{$conter}} </span><strong>{{$page_element->element->title}}</strong>
          <a href="#" title="Delete item" class="btn btn-danger"
             data-parentId="{{$page_element->id}}"
             data-type="{{ 'child' }}"
             data-id='{{$children->id}}'
             onclick="deleteInnerElement(this)"><i class="fas fa-trash-alt"></i></a>
          <a title="Edit item" class="btn btn-primary" data-toggle="collapse"
             href="#child_element_{{$children->id}}" role="button" aria-expanded="false"
             aria-controls="child_element_{{$children->id}}"><i class="fas fa-edit"></i></a>
        </div>
        <div class="collapse my-2" id="child_element_{{$children->id}}">
          <div class="card card-body">
            <form id="updateElement_{{ $children['id'] }}" data-id="{{$page_element['id']}}" onsubmit="updateInnerElement({{ $children->id }})">
              <input type="hidden" name="elementId" value="{{ $children['id'] }}">
              @csrf
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="class_{{$children->id}}">Css Class</label>
                    <input type="text" class="form-control" id="class_{{$children->id}}" name="class" value="{{ ($children['e_class']) ? $children['e_class'] : '' }}">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="id_{{$children->id}}">Css Id</label>
                    <input type="text" class="form-control" id="id_{{$children->id}}" name="id" value="{{ ($children['e_id']) ? $children['e_id'] : '' }}">
                  </div>
                </div>
              @foreach ($children['content'] as $cont)
                <div class="col-md-6">
                  @if ($cont['field']['type'] == "attachment")
                    <div class="w-100">
                      <label>{{ $cont['field']['title'] }}</label>
                      <img class="w-100" src="{{ asset($cont['content']) }}" alt="{{ $cont['field']['title'] }}" width="{{ ($cont['content']) ? '100px' : '200px' }}">
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
          </div>
        </div>
      </li>
      @php $conter++; @endphp
    @endforeach
  </ul>
@endif

<!-- Tinymce Scripts-->
<script type="application/javascript" src="{{ asset('public/assets/backend/tinymce/tinymce.min.js') }}"></script>
<script type="application/ecmascript">
    tinymce.init({
        selector: '.editElement',
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
</script>

