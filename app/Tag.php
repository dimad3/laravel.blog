<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * The posts that belong to the Tag
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function posts(): BelongsToMany
    {
        // The `class` keyword is also used for class name resolution.
        // To obtain the fully qualified name of a class ClassName use ClassName::class
        // https://www.php.net/manual/en/language.oop5.basic.php#language.oop5.basic.class.class
        return $this->belongsToMany(Post::class);
    }
}
