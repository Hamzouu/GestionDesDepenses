<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'amount', 'created_at','activity_id', 'user_id'];

    public function participants()
    {
        return $this->belongsToMany(User::class, 'expense_participants', 'expense_id', 'user_id');
    }

    public function expense_categories()
    {
        return $this->belongsTo(ExpenseCategory::class, 'category_id');
    }

    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class, 'category_id');
    }

    public function authorize(User $user)
    {
        // Vérifie si l'utilisateur courant est le superUtilisateur de l'activité
        if ($user->isSuperUser($this->activity_id)) {
            return true; // Autorisation accordée pour le superUtilisateur
        }

        // Vérifie si l'utilisateur courant est l'auteur de la dépense
        return $user->id === $this->user_id;
    }

}