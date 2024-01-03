<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class loginModel extends Model
{
    use HasFactory;
    public $table = 'login';

    public $primaryKey = 'id';
    protected $fillable = [
        'email',
        'password',
    ];
}
