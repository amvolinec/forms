<div class="row form-builder" style="border-bottom: 1px solid #d6d6d6; padding: 8px;">
    <input id="field-id" type="hidden" name="ids[]" class="form-control" value="{{ $field->id }}">

    <div class="form-group col-md-2">
        <label for="field-name">{{ __("Field name") }}</label>
        <input id="field-name" type="text" name="names[]" class="form-control" value="{{ $field->name }}">
    </div>

    <div class="form-group col-md-2">
        <label for="field-title">{{ __("Field title") }}</label>
        <input id="field-title" type="text" name="titles[]" class="form-control" value="{{ $field->title }}">
    </div>

    <div class="form-group col-md-2">
        <label for="field-type">{{ __("Fild type") }}</label>
        <select id="field-type" type="text" name="types[]" class="form-control">
            @foreach($types as $type)
                <option value="{{ $type->id }}"
                        @if($field->type_id === $type->id) selected @endif>{{ $type->name }}
                    | {{ $type->class }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-md-3">
        <label for="field-defaults">{{ __("Field default value") }}</label>
        <input id="field-defaults" type="text" name="defaults[]" class="form-control" value="{{ $field->default }}">
    </div>

    <div class="form-group col-md-3">
        <label for="field-settings">{{ __("Settings") }}</label>
        <textarea id="field-settings" type="text" name="settings[]"
                  class="form-control">{{ $field->settings }}</textarea>
    </div>

    <div class="form-check col-md-3 ml-3">
        <input type="checkbox" class="form-check-input" name="nullable[]" value="1"
               @if (isset($field->nullable)) @if($field->nullable === 1) checked @endif @else checked @endif>
        <label class="form-check-label" for="nullableCheck">{{ __('Nullable') }}</label>
    </div>
    <div class="form-check col-md-3 mb-3">
        <input type="checkbox" class="form-check-input" name="fillable[]" value="1"
               @if (isset($field->fillable)) @if($field->fillable === 1) checked @endif @else checked @endif>
        <label class="form-check-label" for="fillableCheck">{{ __('Fillable') }}</label>
    </div>
    <div class="form-check col-md-3 mb-3">
        <input type="checkbox" class="form-check-input" name="inlist[]" value="1"
               @if (isset($field->inlist)) @if($field->inlist === 1) checked @endif @else checked @endif>
        <label class="form-check-label" for="inlistCheck">{{ __('In list') }}</label>
    </div>
    <div class="col-md-12">
        <small style="color: #046666; text-align: right; width: 100%;">{{ $field->migration_line }}</small>
        <small style="color: #046666; text-align: right; width: 100%;">{{ $field->foreign }}</small>
    </div>
</div>
