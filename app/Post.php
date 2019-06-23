<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Post extends Model
{
    use Sluggable;


    /**
     * Звязок з таблицею category
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function category()
    {
        return $this->hasOne(Category::class);
    }

    /**
     * Звязок з таблицею User
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */

    public function author()
    {
        return $this->hasOne(User::class);
    }

    /**
     * Звязок з тегами через звязну таблицю
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany( //belongsToMany() звязок Багатьох до Багатьох
            Tag::class,//Модель тегів
            'post_tags',//Звязна таблиці
            'post_id',// id цієї моделі
            'tag_id'// id моделі Tag
        );
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

}
