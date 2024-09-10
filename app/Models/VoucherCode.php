<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherCode extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'user_id'];

    public static function generate(User $user) {
        $code = Str::random(5);

        return self::create(['code' => $code, 'user_id' => $user->id]);
    }
}
