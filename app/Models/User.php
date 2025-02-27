<?php

namespace App\Models;
/**
 * in this model there is two specific method called createUserWithNotify and generateInvitationToken
 * so here idea is we have a api to create a new user so when user user created just sena a mail with unique token
 * token is use for identify the user and using this token we created one link like https://acpltest.com/invite/86b8e23e786310849ec9b337b065f302
 * after clicking on the link user are able to setup the password
 */

use App\Jobs\CachePractices;
use App\Models\Traits\HasProfilePhoto;
use App\Notifications\UserCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;


/**
 * Laravel Specific model
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, TwoFactorAuthenticatable, HasProfilePhoto;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'superadmin',
        'invitation_token',
    ];
    /**
     * define table name
     * @var string
     */
    protected $table = 'acp_users';

    /**
     * auto delete data from userAuth when user is deleted
     */
    protected static function boot()
    {
        parent::boot();
        static::deleted(function (User $user) {
            $user->userAuths()->delete();
        });
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
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
     * define many relationship for authorization
     * can define more then one practice to a single user with role and status code
     * user_auth
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userAuths()
    {
        return $this->hasMany(UserAuth::class, 'user_id');
    }

    /**
     * Get all of the practices assign to user in UserAuth.
     */
    public function practices()
    {
        return $this->hasManyThrough(Practice::class, UserAuth::class, 'user_id', 'ID', 'id', 'practice_id');
    }

    /**
     * generate the invitation token and send it when new user created
     * @param $email
     * @return false|string
     */
    static function generateInvitationToken($email)
    {
        return substr(md5(rand(0, 9) . $email . time()), 0, 32);
    }

    /**
     * chec the user is superAdmin or not
     * @return bool
     */
    public function isSuperAdmin()
    {
        return $this->superadmin == 1;
    }

    /**
     * create a new user and sent notification with invitation code
     * @param $name user name
     * @param $email user email address
     * @return array
     */
    public static function createUserWithNotify($name, $email)
    {
        $user = User::create(['name' => $name, 'email' => $email, 'invitation_token' => User::generateInvitationToken($email)]);
        if ($user) {
            try {
                $user->notify(new UserCreated());
            } catch (\Exception $e) {
                return json_encode($e->getMessage());
                return ['type' => 'info', 'message' => __('generic.success.added_success', ['name' => 'user']) . ',' . __('generic.failure.email_error'), 'data' => $user];
            }
            return ['type' => 'success', 'message' => __('generic.success.added_success', ['name' => 'user']), 'data' => $user];
        }
        return ['type' => 'error', 'message' => __('generic.failure.error')];
    }

    /**
     * assign new practice to user with role and status
     * @param $userId
     * @param $practiceId
     * @param string $role
     * @param int $status
     * @return array
     */
    public static function assignPracticeToUser($userId, $practiceId, $role = 'owner', $status = 1)
    {
        $user = User::findOrFail($userId);
        $practice = Practice::findOrFail($practiceId);
        if (UserAuth::where(['user_id' => $user->id, 'practice_id' => $practice->ID])->exists()) {
            return [
                'type' => 'info',
                'message' => __('generic.failure.info.already_assigned', ['name' => 'practice ' . $practice->Name, 'second_name' => $user->name])
            ];
        }
        try {
            $userAuth = new UserAuth();
            $userAuth->role = $role;
            $userAuth->status = $status;
            $userAuth->user_id = $user->id;
            $userAuth->practice_id = $practice->ID;
            if ($userAuth->save()) {
                // cache practice data after assign to user
                new CachePractices($practice->ID);
                return [
                    'type' => 'success',
                    'message' => __('generic.success.assign_success', ['name' => 'practice ' . $practice->Name, 'second_name' => $user->name])
                ];
            }
        } catch (\Exception $e) {
            return ['type' => 'error', 'message' => __('generic.failure.error')];
        }
    }

    function scopeSuperAdmin($query)
    {
        $query->where('superadmin', 1);
    }
}
