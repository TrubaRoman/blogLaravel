<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Subscription extends Model
{
    /**
     * (Добавити підпиздщика )
     * @param $email
     * @return Subscription
     */
    public static function add($email)
    {
        $sub = new static;
        $sub->email = $email;
        $sub->token = Str::random(100);
        $sub->save();
        return $sub;
    }

    /**
     * (Видалити підписку)
     * delete subscription
     * @throws \Exception
     */

    public function remove()
    {
        $this->delete();
    }
}
