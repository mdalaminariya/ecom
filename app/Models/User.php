<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = [''];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function orders(){
            return $this->hasMany(Order::class);
        }
    public function carts(){
    return $this->hasMany(Cart::class);
        }
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    // Messages sent by user
        public function sentMessages()
        {
            return $this->hasMany(Message::class, 'sender_id');
        }
        public function blogComments()
            {
                return $this->hasMany(BlogComment::class, 'user_id');
            }
        // Messages received by user
        public function receivedMessages()
        {
            return $this->hasMany(Message::class, 'receiver_id');
        }
}
