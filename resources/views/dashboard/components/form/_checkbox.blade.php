<div class="form-group">
    <input type="checkbox" id="{{ $name }}" name="{{ $name }}" @checked(old($name) || $model->$name ?? false) value="{{ $value ?? 'on'}}" style="'transform: scale(1.3)" >
    <label for="{{ $name }}" class="form-label ms-2">{{ __(m_key_to_label($lable ?? $name)) }}</label>
    @error($name)
    <small class="form-text error-text">{{ $message }}</small>
    @enderror
</div>
