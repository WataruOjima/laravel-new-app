<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * 投稿データを所有するユーザを取得
     */
    public function user()
    {
     return $this->belongsTo('App\User');
    }
    
     // 割り当て許可
     protected $fillable = [
        'name',
        'subject',
        'message', 
        'user_id',
        #'category_id'
    ];

    /**
     * 
     */
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    /**
     * 
     */
    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    /**
     * 「名前・本文」検索スコープ
     */
    public function scopeFuzzyNameMessage($query, $searchword)
    {
        if (empty($searchword)) {
            return;
        }
        return $query->where(function ($query) use($searchword) {
            $query->orWhere('name', 'like', "%{$searchword}%")
                  ->orWhere('message', 'like', "%{$searchword}%");
        });
    }

    /**
     * 投稿データを登録する
     */
    public function postSave($params)
    {
        $isSave = $this->fill($params)->save();
        return $isSave;
    }

    
}