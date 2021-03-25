<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Auth;

class UserPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function view(User $user, User $model)
    {
        return $model->id == $user->id;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function update(User $user, User $model)
    {
        return $model->id == $user->id;
    }

    /**
     * 管理者には全ての行動を認可する。
     *
     * @param $user
     * @param $ability
     * @return mixed
     */
    public function before($user, $ability)
    {
        return $user->isAdmin() ? true : null;
    }
    
    /**
     * 編集と削除の認可を判断する。
     *
     * @param  \App\User $user  現在ログインしているユーザー
     * @param  \App\User $model 現在表示しているプロフィールページのユーザー
     * @return mixed
     */
    public function edit(User $user, User $model)
    {
        return $user->id == $model->id;
    }

}
