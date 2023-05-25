<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Activity;
use App\Models\Category;
use App\Models\User;
use App\Models\Expense;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    

    public function index()
{
    $user = auth()->user();

    if (request()->segment(3)) {
        // Filtre par catégorie
        $category = Category::findOrFail(request()->segment(3));
        $activities = Activity::whereHas('category', function ($query) use ($category) {
                $query->where('id', $category->id);
            })
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhereHas('participants', function ($query) use ($user) {
                        $query->where('users.id', $user->id);
                    });
            })
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->get();
    } else {
        // Toutes les activités
        $activities = Activity::where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhereHas('participants', function ($query) use ($user) {
                        $query->where('users.id', $user->id);
                    });
            })
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    $categories = Category::all();

    return view('activities.index', compact('activities', 'categories'));
}




    public function create()
    {
        $categories = Category::all();
        $users = User::all();
        
        return view('activities.create', compact('categories', 'users'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);
        
        $activity = new Activity();
        $activity->title = $request->input('title');
        $activity->description = $request->input('description');
        $activity->category_id = $request->input('category_id');
        $activity->user_id = Auth::id(); // Utilise l'ID de l'utilisateur actuellement connecté
        $activity->save();
        
        // Récupération des utilisateurs sélectionnés
        $selectedUsers = $request->input('users');
        
        // Association des utilisateurs à l'activité
        $activity->users()->sync($selectedUsers);
        
        return redirect()->route('dashboard')->with('success', 'L\'activité a été créée avec succès.');
        
    }

    public function show($id, Activity $activitiy)
    {
        $activity = Activity::findOrFail($id);
        $user = User::findOrFail($activity->user_id);
        $expenses = Expense::where('activity_id', $activity->id)->get();

        return view('activities.show', compact('activity', 'user', 'expenses'));
    }


    public function filterByCategory(Category $category)
    {
        $activities = Activity::where('category_id', $category->id)->get();
        $categories = Category::all();

        return view('activities.index', compact('activities', 'categories'));
    }

   

    public function edit($id)
    {
        $activity = Activity::findOrFail($id);
        $categories = Category::all();
        
        return view('activities.edit', compact('activity', 'categories'));
    }
    
    public function update(Request $request, Activity $activity)
    {
        $activity->update($request->all());

        return redirect()->route('activities.show', $activity->id)
                        ->with('success', 'L\'activité a été mise à jour avec succès.');
    }

    public function destroy(Activity $activity)
    {
        // Dissocier tous les participants de l'activité
        $activity->users()->detach();

        // Supprimer l'activité
        $activity->delete();

        return redirect()->route('activities.index')
                        ->with('success', 'L\'activité a été supprimée avec succès.');
    }

    
    public function createExpense($activity)
    {
        $activity = Activity::findOrFail($activity);
        $categories = Category::all();
        $users = User::all();

        return view('expenses.create', compact('activity', 'categories', 'users'));
    }

    public function storeExpense(Request $request, $activity)
    {
        $request->validate([
            'name' => 'required',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'category' => 'required',
            'description' => 'required',
            'users' => 'required|array',
        ]);

        $expense = new Expense();
        $expense->name = $request->input('name');
        $expense->amount = $request->input('amount');
        $expense->date = $request->input('date');
        $expense->category = $request->input('category');
        $expense->description = $request->input('description'); // Add the description field
        $expense->activity_id = $activity;
        $expense->save();

        // Récupération des utilisateurs sélectionnés
        $selectedUsers = $request->input('users');

        // Association des utilisateurs à la dépense
        $expense->users()->sync($selectedUsers);

        return redirect()->route('activities.show', $activity)->with('success', 'Expense added successfully.');
    }


    public function updateExpense(Request $request, $activity, $expense)
    {
        $request->validate([
            'name' => 'required',
            'amount' => 'required|numeric',
        ]);

        $expense = Expense::findOrFail($expense);
        $expense->name = $request->input('name');
        $expense->amount = $request->input('amount');
        $expense->save();

        return redirect()->back()->with('success', 'La dépense a été mise à jour avec succès.');
    }

    public function destroyExpense($activity, $expense)
    {
        $expense = Expense::findOrFail($expense);
        $expense->delete();

        return redirect()->back()->with('success', 'La dépense a été supprimée avec succès.');
    }

}

