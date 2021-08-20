<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    public function role()
    {
        return $this->belongsTo('App\Model\Role', 'role_id');
    }

    public function leads()
    {
        return $this->hasMany('App\Model\Lead', 'assignee_id');
    }

    public function saleOrders()
    {
        return $this->hasMany('App\Model\SaleOrder', 'user_id');
    }

    public function purcahseOrders()
    {
        return $this->hasMany('App\Model\PurchaseOrder', 'user_id');
    }

    public function tickets()
    {
        return $this->hasMany('App\Model\Ticket', 'user_id');
    }

    public function ticketReplies()
    {
        return $this->hasMany('App\Model\TicketReply', 'user_id');
    }

    public function avatarFile() 
    {
        return $this->hasOne('App\Model\File', 'object_id')->where('object_type', 'USER');
    }

    public function projects() 
    {
        return $this->hasOne('App\Model\File', 'uploaded_by')->where('object_type', 'PROJECT');
    }

    public function activity() 
    {
        return $this->hasOne('App\Model\Activity', 'user_id');
    }

    protected $guard = 'web';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'full_name', 'email', 'role_id', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = ['deleted_at'];

    public static $login_validation_rule = [
        'email' => 'required|email|exists:users',
        'password' => 'required'
    ];
}
