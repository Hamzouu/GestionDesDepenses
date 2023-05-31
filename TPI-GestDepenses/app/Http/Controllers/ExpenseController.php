<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Activity;
use App\Models\Category;
use App\Models\Expense;
use App\Models\ExpenseCategory;

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

        return view('expenses.edit', compact('activity', 'expense', 'categories'));
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

        // Vérifie si l'utilisateur courant est autorisé à modifier la dépense
        $this->authorize('update', $expense);

        $expense->title = $request->input('title');
        $expense->amount = $request->input('amount');
        $expense->description = $request->input('description');
        $expense->category_id = $request->input('category');
        $expense->save();

        $activity = Activity::findOrFail($activity);

        return redirect()->route('activities.show', $activity)->with('success', 'Expense updated successfully.');
    }

    public function destroy($activity, $expense)
    {
        $expense = Expense::findOrFail($expense);
        
        // Delete related expense participants
        $expense->participants()->delete();
        
        $expense->delete();
        
        return redirect()->back()->with('success', 'La dépense a été supprimée avec succès.');

    }
}