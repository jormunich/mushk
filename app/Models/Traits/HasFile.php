<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Storage;

trait HasFile
{
    /**
     * @param string $field
     * @return string|null
     */
    public function getFilePath(string $field = 'image'): string|null
    {
        if ($this->$field) {
            return Storage::url('/' . $this->getTable() . '/' . $this->id . $this->$field);
        }

        return asset('/dashboard/img/default.webp');
    }

    /**
     * @param string $field
     * @return string|null
     */
    public function getThumbPath(string $field = 'image'): string|null
    {
        $thisClass = new \ReflectionClass($this);

        if ($this->$field) {
            return Storage::url('/' . $this->getTable() . '/' . $this->id . '/thumb/' . $thisClass->getConstant(strtoupper($field) . '_WIDTH') . $this->$field);
        }

        return asset('/dashboard/img/default.webp');
    }
}
