<?php

namespace App\Services;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class FileService
{
    const FORMAT = 'jpg';
    const QUALITY = 80;
    const CUSTOM_FIELD = 'image';
    const UPLOAD_PATH = '/upload';
    const UPLOAD_WIDTH = 480;

    protected string $field;
    protected array $widths;

    /**
     *  FileService construct
     */
    public function __construct()
    {
        $this->field = self::CUSTOM_FIELD;
        $this->widths = [];
    }

    /**
     * @param array $widths
     * @return FileService
     */
    public function setWidths(array $widths): FileService
    {
        $this->widths = $widths;

        return $this;
    }

    /**
     * @param string $field
     * @return FileService
     */
    public function setField(string $field): FileService
    {
        $this->field = $field;

        return $this;
    }

    /**
     * @param mixed $images
     * @param Model $entity
     * @return void
     */
    public function storeEntityImage(mixed $images, Model $entity): void
    {
        if(!is_array($images)) {
            $images = [$images];
        }
        foreach ($images as $image) {
            $storage = $this->getStorage();
            $fileName = $this->getFileName($image);
            $filePath = $this->getEntityFilePath($entity);
            $storage->put($filePath . "/$fileName", file_get_contents($image), 'public');

            if (count($this->widths)) {
                $this->attachmentThumb($image, $filePath, $fileName);
            }
            $entity->{$this->field} = "/$fileName";
            $entity->save();
        }
    }

    /**
     * @param mixed $images
     * @param Model $entity
     * @param string $relationship
     * @param string $imageModelClass
     * @return void
     */
    public function storeMultipleImages(mixed $images, Model $entity, string $relationship, string $imageModelClass): void
    {
        if(!is_array($images)) {
            $images = [$images];
        }
        foreach ($images as $image) {
            $storage = $this->getStorage();
            $fileName = $this->getFileName($image);
            $filePath = $this->getEntityFilePath($entity);
            $storage->put($filePath . "/$fileName", file_get_contents($image), 'public');

            $imageModel = new $imageModelClass([
                $relationship . '_id' => $entity->id,
                'image' => "/$fileName",
            ]);

            $imageModel->save();

            if (count($this->widths)) {
                $this->attachmentThumb($image, $filePath, $fileName);
            }
        }
    }

    /**
     * @param UploadedFile $image
     * @param string $filePath
     * @param string $fileName
     */
    public function attachmentThumb(UploadedFile $image, string $filePath, string $fileName): void
    {
        foreach ($this->widths as $width) {
            self::attachment($image, $filePath, $width, $fileName);
        }
    }

    /**
     * @param UploadedFile $image
     * @param string $filePath
     * @param int $width
     * @param string $fileName
     */
    public function attachment(UploadedFile $image, string $filePath, int $width, string $fileName): void
    {
        $storage = $this->getStorage();

        $manager = new ImageManager(new Driver());
        $img = $manager
            ->read($image->getPathname())
            ->scale(width: $width)
            ->toJpeg(quality: self::QUALITY)
            ->toString();

        $fullPath = "$filePath/thumb/$width/$fileName";

        $storage->put($fullPath, $img, 'public');
    }

    /**
     * @param Model $entity
     * @return void
     */
    public function removeEntityImages(Model $entity): void
    {
        $storage = $this->getStorage();
        $storage->deleteDirectory($this->getEntityFilePath($entity));
    }

    /**
     * @return Filesystem
     */
    private function getStorage(): Filesystem
    {
        return Storage::disk(config('filesystems.default'));
    }

    /**
     * @param Model $entity
     * @return string
     */
    private function getEntityFilePath(Model $entity): string
    {
        return '/' . $entity->getTable() . '/' . $entity->id;
    }

    /**
     * @param UploadedFile $image
     * @return string
     */
    private function getFileName(UploadedFile $image): string
    {
        return uniqid() . Str::slug($image->getClientOriginalName(), '.');
    }

    /**
     * @param UploadedFile $image
     * @return array
     */
    public function upload(UploadedFile $image): array
    {
        $fileName = $this->getFileName($image);
        $storage = $this->getStorage();
        $manager = new ImageManager(new Driver());
        $img = $manager
            ->read($image->getPathname())
            ->scale(width: self::UPLOAD_WIDTH)
            ->toJpeg(quality: self::QUALITY)
            ->toString();
        $storage->put(self::UPLOAD_PATH . "/$fileName", $img, 'public');
        $url = Storage::url(self::UPLOAD_PATH . "/$fileName");

        return ['fileName' => $fileName, 'uploaded'=> 1, 'url' => $url];
    }
}
