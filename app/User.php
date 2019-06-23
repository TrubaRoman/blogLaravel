<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    const IS_ADMIN = 1;
    const IS_NORMAL = 0;
    const IS_BANED = 1;
    const IS_ACTIVE = 0;

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Повертає статі даного юзера
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Коментарі даного юзера
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public static function add($fields)
    {
        $user = new static;
        $user->fill($fields);
        $user->password = bcrypt($fields['password']);
        $user->save();
        return $user;
    }

    public function edit($fields)
    {
        $this->fill($fields);
        $this->password = bcrypt($fields['password']);
        $this->save();
    }

    public function remove()
    {
        $this->delete();
    }

    public function uploadAvatar($image)
    {
        if ($image == null) return;
        Storage::delete('uploads/' . $this->image);//storage видаляє картинку в папці, якшо вона існує
        $filename = Str::random(10) . '.' . $image->extension();//потім створюється імя нової картинки
        $image->saveAs('uploads', $filename);//зберігаємо файл в папку
        $this->image = $filename;// завантажуємо імя нового файла в поле image
        $this->save();// зберігаємо імя картинки в базу
    }

    public function getAvatar()
    {
        if ($this->image == null) {
            return '/img/no-user-image.png';
        }
        return '/uploads/' . $this->image;
    }

    public function thisAdmin()
    {
        $this->is_admin = User::IS_ADMIN;
        $this->save();
    }

    public function thisNormal()
    {
        $this->is_admin = User::IS_NORMAL;
        $this->save();
    }

    public function toggleAdmin($value)
    {
        if ($value == null) return $this->thisNormal();
        else return  $this->thisAdmin();
    }

    public function ban()
    {
         $this->status = User::IS_BANED;
         $this->save();
    }

    public function unban()
    {
         $this->status = User::IS_ACTIVE;
         $this->save();
    }

    public function toggleBan($value)
    {
        return ($value == null)?$this->unban():$this->ban();
    }

}
