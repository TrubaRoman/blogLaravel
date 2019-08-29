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
        $sub->save();
        return $sub;
    }

    /**
     * token generate
     */
    public function generationsToken()
    {
        $this->token = Str::random(100);
        $this->save();
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
