<?php

namespace App\Models;

use App\Providers\UploadServiceProvider;
use App\Traits\TahaModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\UploadedFile as UploadedFileIlluminate;

class UploadedFile extends Model
{
    use TahaModelTrait, SoftDeletes;

    public static $meta_fields = [
        'image_width',
        'image_height',
        'resolution', // for images and videos
        'title',
        'description',
        'related_files',
    ];
    protected $guarded = ['id'];
    protected $casts = [
        'published_at'   => 'datetime',
        'meta'           => "array",
        'relative_files' => "relative_files",
    ];
    private static $statusesNames = [
        1 => 'temp',
        2 => 'used',
    ];

    /*
    |--------------------------------------------------------------------------
    | Storing
    |--------------------------------------------------------------------------
    */

    /**]
     *
     * Saves an uploaded file in DB
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param array                         $data
     */
    public static function saveFile($file, $data = [])
    {
        if ($file instanceof UploadedFileIlluminate) {
            $data = array_normalize_keep_originals($data, [
                'original_name' => $file->getClientOriginalName(),
                'physical_name' => UploadServiceProvider::generateFileName() .
                    '.'
                    . $file->getClientOriginalExtension(),
                'directory'     => UploadServiceProvider::getSectionRule('default', 'uploadDir'),
                'mime_type'     => $file->getClientMimeType(),
                'extension'     => $file->getClientOriginalExtension(),
                'size'          => $file->getSize(),
                'status'        => self::getStatusValue('temp'),
            ]);

            return self::store($data);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Static Data
    |--------------------------------------------------------------------------
    */

    public static function getStatusValue($statusName)
    {
        return array_search($statusName, self::$statusesNames);
    }


    /*
    |--------------------------------------------------------------------------
    | Modification
    |--------------------------------------------------------------------------
    */

    /** Sets the status of file with status name
     *
     * @param string $statusName
     *
     * @return self
     */
    public function setStatus($statusName)
    {
        $this->status = self::getStatusValue($statusName);
        return $this;
    }

    /** Compares the status of file with value of given status name
     *
     * @param string $statusName
     *
     * @return bool
     */
    public function hasStatus($statusName)
    {
        return ($this->status == self::getStatusValue($statusName)) ? true : false;
    }


    /*
    |--------------------------------------------------------------------------
    | Assessors
    |--------------------------------------------------------------------------
    */

    /**
     * Returns Pathname (Concatenation of "directory" and "physical_name")
     *
     * @return string
     */
    public function getPathnameAttribute()
    {
        return implode(DIRECTORY_SEPARATOR, [
            $this->directory,
            $this->physical_name,
        ]);
    }

    /**
     * Returns names of related files
     *
     * @return array|null
     */
    public function getRelatedFilesAttribute()
    {
        return $this->meta('related_files');
    }

    /**
     * Returns pathname of related files
     *
     * @return array|mixed
     */
    public function getRelatedFilesPathnameAttribute()
    {
        $relatedFiles = $this->related_files;
        if ($relatedFiles and is_array($relatedFiles)) {
            foreach ($relatedFiles as $key => $relatedFile) {
                $relatedFiles[$key] = $this->directory . DIRECTORY_SEPARATOR . $relatedFile;
            }
        }

        return $relatedFiles;
    }

}

