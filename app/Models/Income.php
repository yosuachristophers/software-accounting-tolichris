<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\Factory;


class Income extends Model
{
    use HasFactory;

    public function incat()
    {
        return $this->belongsTo(\App\Models\IncomeCategory::class);
    }

    // GUARDING IMPORTANT
    protected $guarded = ['id'];
}
