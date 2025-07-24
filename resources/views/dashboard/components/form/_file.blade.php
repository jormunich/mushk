<div class="form-group">
    <label for="{{ $name }}">{{ __(m_key_to_label($lable ?? $name)) }}</label>
    <br>
    <input type="file" name="{{ $name }}" id="{{ $name }}">
    @error($name)
        <small class="form-text error-text">{{ $message }}</small>
    @enderror
    @if($model && $model->$name)
        <hr>
        <div class="image-preview">
            <img src="{{ $model->getThumbPath() }}" width="150px">
        </div>
    @endif
</div>
