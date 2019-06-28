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
        'name', 'email',
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
     * (Зв'язок з коментарями  даного юзера, з моделлю Comment)
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * add data users & save password hash
     * (Добавляє користувача, дані fillable (email,name,password) і хешує пароль)
     * @param $fields
     * @return User
     */
    public static function add($fields)
    {
        $user = new static;
        $user->fill($fields);
        $user->save();
        return $user;
    }

    /**
     * update data users & update password hash
     * (Обновляє користувача, дані fillable (email,name,password) і обновляє хеш паролю)
     * @param $fields
     */
    public function edit($fields)
    {
        $this->fill($fields);
        $this->save();
    }


    public function generatePasswordHash($password)
    {
        if($password !==null){
            $this->password = bcrypt($password);
            $this->save();
        }
    }

    /**
     * Delete user data and user ava
     * (Видаляє дані юзера і картинку)
     * @throws \Exception
     */

    public function remove()
    {
        Storage::delete('uploads/' . $this->image);
        $this->delete();
    }

    /**
     *add user avatar end update
     * if isset last image, delete last image
     * end save db
     * (Завантажує або обновлює аву)
     * @param $image
     */

    public function uploadAvatar($image)
    {
        if ($image == null) return;
        Storage::delete('uploads/' . $this->avatar);//storage видаляє картинку в папці, якшо вона існує
        $filename = Str::random(10) . '.' . $image->extension();//потім створюється імя нової картинки
        $image->storeAs('uploads', $filename);//зберігаємо файл в папку
        $this->avatar = $filename;// завантажуємо імя нового файла в поле image
        $this->save();// зберігаємо імя картинки в базу
    }

    /**
     * get image path|path no_image
     * (Виводить зображення, або заглушку )
     * @return string
     */
    public function getAvatar()
    {
        if ($this->avatar == null) {
            return '/img/no-user-image.png';
        }
        return '/uploads/' . $this->avatar;
    }

    /**
     * add status admin current user
     */

    public function thisAdmin()
    {
        $this->is_admin = User::IS_ADMIN;
        $this->save();
    }

    /**
     * remove status admin current user
     */
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

    /**
     * ban user
     */
    public function ban()
    {
         $this->status = User::IS_BANED;
         $this->save();
    }

    /**
     * unban user
     */

    public function unban()
    {
         $this->status = User::IS_ACTIVE;
         $this->save();
    }

    /**
     * @param $value
     * toggle ban|unban current user
     */
    public function toggleBan($value)
    {
        return ($value == null)?$this->unban():$this->ban();
    }

}
