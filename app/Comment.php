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
        return $this->belongsTo(Post::class);
    }

    /**
     * Звязок коментаря з його автором
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */

    public function author()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    /**
     * add status allow (одобрити коментар)
     */
    public function allow()
    {
        $this->status = Comment::ALLOW;
        $this->save();
    }

    /**
     * add status desallo (не одобрити коментар)
     */
    public function disallow()
    {
        $this->status = Comment::DISALLOW;
        $this->save();
    }

    /**
     * allow|disallow toggle comments (перемикач ' одобрити чи не одобрити коментарій)
     */
    public function toggleStatus()
    {
        return ($this->status == Comment::DISALLOW)?$this->allow():$this->disallow();
    }

    /**
     * @throws \Exception
     * delete comments
     * (Видалити коментарій з бази)
     */
    public function remove()
    {
        $this->delete();
    }

    public function countComment()
    {
        return $this->count();
    }

}
