<?php
namespace App\Models;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Enums\Gender;
use App\Enums\Employee\RolesEnum;
class Employee extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'username',
        'email',
        'gender',
        'roles',
        'date',
        'password',
    ];
    protected $hidden = [
        'password',
    ];
    protected $casts = [
        'gender' => Gender::class,
        'roles' => RolesEnum::class,
    ];
}
