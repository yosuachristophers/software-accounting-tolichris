<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\Factory;

class Expense extends Model
{
    use HasFactory;

    public function excat()
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id', 'id');
    }

    public function exacc()
    {
        return $this->belongsTo(\App\Models\Account::class, 'expense_account_id');
    }

    // GUARDING IMPORTANT
    protected $guarded = ['id'];
}
