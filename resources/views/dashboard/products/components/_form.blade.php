<div class="card-body">
    <div class="row">
        <div class="col-lg-6">
            @include('dashboard.components.form._text', ['name' => 'name', 'model' => $model ?? null])
            @include('dashboard.components.form._text', ['name' => 'price', 'type' => 'number', 'model' => $model ?? null])
            @include('dashboard.components.form._text', ['name' => 'old_price', 'type' => 'number', 'model' => $model ?? null])
            @include('dashboard.components.form._text', ['name' => 'review_count', 'type' => 'number', 'model' => $model ?? null])
            @include('dashboard.components.form._text', ['name' => 'review', 'type' => 'number', 'model' => $model ?? null])
            @include('dashboard.components.form._checkbox', ['name' => 'is_popular', 'type' => 'number', 'value' => 1, 'model' => $model ?? null])
            @include('dashboard.components.form._multiselect', ['name' => 'categories', 'label' => 'Categories', 'options' => $categories ?? [], 'model' => $model ?? null])
        </div>
        <div class="col-lg-6">
            @include('dashboard.components.form._file', ['name' => 'image', 'model' => $model ?? null])
        </div>
        <div class="col-lg-12">
            @include('dashboard.components.form._textarea', ['name' => 'description', 'model' => $model ?? null])
        </div>
    </div>
</div>
