<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Post extends Model
{
    use Sluggable;

    const IS_PUBLIC = 1;
    const IS_DRAFT = 0;

    protected $fillable = ['title','content','date'];


    /**
     * Звязок з таблицею category
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Звязок з таблицею User
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */

    public function author()
    {
        return $this->belongsTo(User::class,'user_id');
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

    public static function add($fields)
    {
        $post = new static;
        $post->fill($fields);
        $post->user_id = 1;
        $post->save();
        return $post;
    }

    public function edit($fields)
    {
        $this->fill($fields);
        $this->save();
    }

    public function remove()
    {
       $this->removeImage();//storage видаляє картинку в папці, якшо вона існує
        $this->delete();
    }

    public function uploadImage($image)
    {
        if($image == null)return;
        $this->removeImage();//storage видаляє картинку в папці, якшо вона існує
        $filename = Str::random(10).'.'.$image->extension();//потім створюється імя нової картинки
        $image->storeAs('uploads',$filename);//зберігаємо файл в папку
        $this->image = $filename;// завантажуємо імя нового файла в поле image
        $this->save();// зберігаємо імя картинки в базу
    }

    public function removeImage()
    {
        if ($this->image !=null)
        {
            Storage::delete('uploads/'.$this->image);
        }
    }


    public function getImage()
    {
        if($this->image == null){
            return '/img/no-image.png';
        }
        return '/uploads/'.$this->image;
    }


    public function setCategory($id)
    {
        if($id == null)return;
        $this->category_id = $id;
        $this->save();
    }

    public function setTags($ids)
    {
        if($ids == null)return;
        $this->tags()->sync($ids);
    }

    public function setDraft()
    {
        $this->status = self::IS_DRAFT;
        $this->save();
    }

    public function setPublic()
    {
        $this->status = self::IS_PUBLIC;
        $this->save();
    }

    public function toggleStatus($value)
    {
        return ($value != null)?$this->setPublic():$this->setDraft();
    }

    public function setFeatured()
    {
        $this->is_featured = self::IS_PUBLIC;
        $this->save();
    }

    public function setStandart()
    {
        $this->is_featured = self::IS_DRAFT;
        $this->save();
    }

    public function toggleFeatured($value)
    {
        return ($value == null)?$this->setStandart():$this->setFeatured();
    }

    public function setDateAttribute($value)
    {
        $date = Carbon::createFromFormat('d/m/y',$value)->format('Y-m-d');
        $this->attributes['date'] = $date;
    }

    public function getDateAttribute($value)
    {
        $date = Carbon::createFromFormat('Y-m-d',$value)->format('d/m/y');
        return $date;
    }

    public function getCategoryTitle()
    {
        return ($this->category != null)?$this->category->title: 'Category does not exist';
    }

    public function getTagsTitles()
    {
        return (!$this->tags->isEmpty())?implode(', ',$this->tags->pluck('title')->all()):'Tags does not exist';
    }



}
