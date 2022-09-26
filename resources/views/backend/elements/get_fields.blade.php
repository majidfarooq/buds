@php $conter=1; @endphp

@if ($element)
  <ul class="list-group my-2">
    @foreach($element->fields as $field)
      <li class="list-group-item my-1">
        <div class="mb-4"><strong>
            @{{@php echo $field->slug; @endphp}}
          </strong>
          <div class="float-right">
            <a href="#" title="Delete item" class="btn btn-danger"
               data-id='{{$field->id}}'
               onclick="deleteField(this)"><i class="fas fa-trash-alt"></i></a>
            <a title="Edit item" class="btn btn-primary" data-toggle="collapse"
               href="#field_{{$field->id}}" role="button" aria-expanded="false"
               aria-controls="field_{{$field->id}}"><i class="fas fa-edit"></i></a>
          </div>
        </div>
        <div class="collapse my-2" id="field_{{$field->id}}">
          <div class="card card-body">
            <form id="updateElement_{{ $field['id'] }}" data-id="{{$field->id}}"
                  {{--onsubmit="updateField(this)"--}}
            >
              @csrf
              <input type="hidden" name="fieldId" value="{{$field->id}}">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="field-title-{{$field['id']}}">Title</label>
                    <input class="form-control" id="field-title-{{$field['id']}}" name="title" required type="text" value="{{ ($field['title']) ? $field['title'] : '' }}">
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="field-type-{{$field->id}}">Type</label>
                    <select class="form-control" id="field-type-{{$field->id}}" name="type" onchange="changeInputType(this)" required>
                      @foreach($fields_type as $field_type)
                        <option value="{{$field_type}}" {{ ($field->type == $field_type) ? "selected" : '' }}>{{$field_type}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group fieldValue">
                    <label for="field-value-{{$field->id}}">Value</label>
                    @if ($field->type == 'attachment')
                      <input class="form-control" id="field-value-{{$field->id}}" name="value" required type="file" value="{{ ($field['value']) ? $field['value'] : '' }}">
                    @else
                      <input class="form-control" id="field-value-{{$field->id}}" name="value" required type="text" value="{{ ($field['value']) ? $field['value'] : '' }}">
                    @endif
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary" onclick="checkUpdateField(this)" data-id="updateElement_{{ $field['id'] }}">Update</button>
                  </div>
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
