<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class LoginToken extends Model
{
    protected $fillable = [
      'user_id', 'token'
    ];

    /**
     * @param User $user
     * @return static
     */
    public  static function generateFor(User $user)
    {
        return static::create([
            'user_id' => $user->id,
            'token'  => str_random(50)
        ]);
    }

    public function getRouteKeyName()
    {
        return 'token';
    }

    public function send()
    {
        $url = url('/auth/token', $this->token);

        Mail::raw(
            "<a href='{$url}'>{$url}</a>",
            function($message) {
                $message->to($this->user->email)
                        ->subject('Login to our platform');
            }
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
