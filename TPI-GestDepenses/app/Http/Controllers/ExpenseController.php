<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Activity;
use App\Models\Category;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::with('category', 'participants')->get();
        return view('activities.show', compact('expenses'));
    }


    public function create($activity)
    {
        $activity = Activity::findOrFail($activity);
        $categories = ExpenseCategory::all();
        $users = $activity->users; // Récupérer les utilisateurs associés à l'activité

        return view('expenses.create', compact('activity', 'categories', 'users'));
    }

    public function store(Request $request, $activity)
    {
        $request->validate([
            'title' => 'required',
            'amount' => 'required|numeric',
            'description' => 'required',
            'created_at' => 'required|date',
            'category' => 'required|exists:expense_categories,id',
        ]);

        // Créez la dépense
        $expense = new Expense();
        $expense->title = $request->input('title');
        $expense->amount = $request->input('amount');
        $expense->created_at = $request->input('created_at');
        $expense->description = $request->input('description');
        $expense->activity_id = $activity;
        $expense->user_id = $request->user()->id; // Utilisateur courant
        $expense->save();

        // Associez la catégorie à la dépense
        $category = ExpenseCategory::findOrFail($request->input('category'));
        $expense->expense_categories()->associate($category);
        $expense->save();

        return redirect()->route('activities.show', $activity)->with('success', 'Expense added successfully.');
    }


    public function edit($activity, $expense)
    {
        $activity = Activity::find($activity);
        $expense = Expense::find($expense);
        $categories = ExpenseCategory::all();
        $users = $activity->users; // Récupérer les utilisateurs associés à l'activité

        return view('expenses.edit', compact('activity', 'expense', 'categories', 'users'));
    }


    public function update(Request $request, $activity, $expense)
    {
        $request->validate([
            'title' => 'required',
            'amount' => 'required|numeric',
            'description' => 'required',
            'category' => 'required|exists:expense_categories,id',
        ]);

        $expense = Expense::findOrFail($expense);

        

        $expense->title = $request->input('title');
        $expense->amount = $request->input('amount');
        $expense->description = $request->input('description');
        $expense->category_id = $request->input('category');
        $expense->save();

        // Ajouter les participants sélectionnés
        $participants = $request->input('participants', []);
        $existingParticipants = $expense->participants->pluck('id')->toArray();

        // Ajouter les nouveaux participants à la liste existante
        $participantsToAdd = array_diff($participants, $existingParticipants);
        $expense->participants()->attach($participantsToAdd);

        

        $activity = Activity::findOrFail($activity);

        return redirect()->route('activities.show', $activity)->with('success', 'Expense updated successfully.');
    }


    public function destroy($activity, $expense)
    {
        try {
            $expense = Expense::findOrFail($expense);
    
            // Detach related expense participants
            $expense->participants()->detach();
    
            // Get the user associated with the expense
            $user = $expense->user;
    
            $expense->delete();
    
            // Delete the user if there are no more related expense participants
            if ($user && $user->expenses()->count() === 0) {
                $user->delete();
            }
    
            return redirect()->back()->with('success', 'La dépense a été supprimée avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Une erreur s\'est produite lors de la suppression de la dépense.');
        }
    }

    public function summary($activity)
    {
        $activity = Activity::findOrFail($activity);

        // Récupérer les dépenses de l'activité avec les utilisateurs associés
        $expenses = Expense::where('activity_id', $activity->id)
            ->with('participants')
            ->get();

        // Tableau pour stocker les montants dus par chaque utilisateur
        $balances = [];

        // Calculer les montants dus par chaque utilisateur
        foreach ($expenses as $expense) {
            $totalParticipants = $expense->participants->count();

            // Montant divisé par le nombre total de participants
            $amountPerParticipant = $expense->amount / $totalParticipants;

            // Montant dû à l'utilisateur ayant créé la dépense
            $amountDueToUser = $amountPerParticipant * ($totalParticipants - 1);

            foreach ($expense->participants as $participant) {
                if ($participant->id != $expense->user_id) {
                    $balanceKey = $participant->name . ' doit ' . $amountDueToUser . ' à ' . $expense->user->name;
                    $balances[$balanceKey] = $amountDueToUser;

                    // Ajouter le montant dû à l'utilisateur créant la dépense dans le total de l'utilisateur
                    if (isset($balances[$participant->name])) {
                        $balances[$participant->name] += $amountDueToUser;
                    } else {
                        $balances[$participant->name] = $amountDueToUser;
                    }
                }
            }
        }

        return view('expenses.summary', compact('activity', 'balances'));
    }


}