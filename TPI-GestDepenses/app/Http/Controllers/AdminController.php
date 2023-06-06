<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']); // Ajoute la vérification d'authentification et d'administrateur
    }

    public function listUsers(Request $request)
    {
        // Récupérer tous les utilisateurs
        $users = User::all();

        // Filtrer les utilisateurs approuvés ou non approuvés
        $approved = $request->input('approved');

        if ($approved === 'approved') {
            $users = $users->where('approved', true);
        } elseif ($approved === 'not_approved') {
            $users = $users->where('approved', false);
        }

        // Afficher la vue de la page d'administration avec la liste des utilisateurs
        return view('admin.userList', [
            'users' => $users,
            'selectedFilter' => $approved,
        ]);
    }

    public function approveUser(User $user)
    {
        $user->update(['approved' => true]);

        return redirect()->back()->with('success', 'Utilisateur approuvé avec succès.');
    }
}
