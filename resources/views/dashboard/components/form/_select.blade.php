<div class="form-group">
    <label for="{{ $name }}">{{ __(m_key_to_label($lable ?? $name)) }}</label>
    <select class="form-control" id="{{ $name }}" name="{{ $name }}">
        @foreach($options?? [] as $key => $value)
            <option value="{{ $key }}" @selected((isset($selected) && $selected == $key) || old($name) == $key || (isset($model) && $model->$name == $key) )>{{ $value }}</option>
        @endforeach
    </select>
    @error($name)
        <small class="form-text error-text">{{ $message }}</small>
    @enderror
</div>
