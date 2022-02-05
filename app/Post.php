<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;

class Post extends Model
{
    use Sluggable;

    protected $fillable = ['title', 'description', 'content', 'category_id', 'thumbnail'];

    /**
     * The tags that belong to the Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        /**
         * public function withTimestamps($createdAt = null, $updatedAt = null)
         *
         * Specify that the pivot table has creation and update timestamps.
         *
         * @param  mixed  $createdAt
         * @param  mixed  $updatedAt
         * @return $this (BelongsToMany)
         */
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }


    /**
     * Get the category that owns the Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public static function uploadImage(Request $request, string $image = null)
    {
        /**
         * vendor\laravel\framework\src\Illuminate\Http\Concerns\InteractsWithInput.php
         *
         * public function hasFile($key)
         *
         * Determine if the uploaded data contains a file.
         *
         * @param  string  $key
         * @return bool
         */
        if ($request->hasFile('thumbnail')) {
            if ($image) {
                // https: //laravel.com/docs/7.x/filesystem#deleting-files
                Storage::delete($image);
            }

            $folder = date('Y-m-d');

            /**
             * vendor\laravel\framework\src\Illuminate\Http\UploadedFile.php
             * public function file($key = null, $default = null)
             *
             * Retrieve a file from the request.
             *
             * @param  string|null  $key
             * @param  mixed  $default
             * @return \Illuminate\Http\UploadedFile|\Illuminate\Http\UploadedFile[]|array|null
             */

            /**
             * vendor\laravel\framework\src\Illuminate\Http\UploadedFile.php
             *
             * public function store($path, $options = [])
             *
             * Store the uploaded file on a filesystem disk.
             * The store method accepts the path where the file should be stored relative to the filesystem's configured root directory.
             * This path should not contain a file name, since a unique ID will automatically be generated to serve as the file name
             *
             * @param  string  $path
             * @param  array|string  $options
             * @return string|false
             */
            $path = $request->file('thumbnail')->store("images/{$folder}");
            return $path;
        // } elseif ($request->hasFile('thumbnail') === false && $image !== null) {
        //     return $image;
        }
        // https: //laravel.com/docs/7.x/filesystem#deleting-files
        // Storage::delete($image);
        return null;
    }

    public function getImage()
    {
        if ($this->thumbnail) {
            return asset("uploads/{$this->thumbnail}");
        }
        return asset('no-image.jpg');
    }

    public function getPostDate(){
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('d F, Y');    }
}
