<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    const  ALLOW = '1';
    const  DISALLOW = '0';
    /**
     * Звязок коментарія з постом
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function post()
    {
        return $this->hasOne(Post::class);
    }

    /**
     * Звязок коментаря з його автором
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */

    public function author()
    {
        return $this->hasOne(User::class);
    }

    public function allow()
    {
        $this->status = Comment::ALLOW;
        $this->save();
    }

    public function disallow()
    {
        $this->status = Comment::DISALLOW;
        $this->save();
    }

    public function toggleStatus()
    {
        return ($this->status == Comment::DISALLOW)?$this->allow():$this->disallow();
    }

    public function remove()
    {
        $this->delete();
    }

}
