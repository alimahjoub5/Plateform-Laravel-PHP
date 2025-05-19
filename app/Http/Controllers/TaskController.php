<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Task::with(['project', 'assignedDeveloper']);

        // Appliquer les filtres
        if ($request->has('status') && $request->status !== '') {
            $query->where('Status', $request->status);
        }

        if ($request->has('priority') && $request->priority !== '') {
            $query->where('Priority', $request->priority);
        }

        if ($request->has('developer') && $request->developer !== '') {
            $query->where('AssignedTo', $request->developer);
        }

        $tasks = $query->paginate(10);
        $developers = User::where('Role', 'freelancer')->get();
        
        return view('tasks.index', compact('tasks', 'developers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = Project::where('Status', 'In Progress')->get();
        $developers = User::where('Role', 'freelancer')->get();
        return view('tasks.create', compact('projects', 'developers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'Title' => 'required|string|max:255',
            'Description' => 'required|string',
            'ProjectID' => 'required|exists:projects,ProjectID',
            'DueDate' => 'required|date',
            'Priority' => 'required|in:Low,Medium,High',
        ]);

        $task = Task::create([
            'Title' => $request->Title,
            'Description' => $request->Description,
            'ProjectID' => $request->ProjectID,
            'AssignedTo' => Auth::id(),
            'CreatedBy' => Auth::id(),
            'Status' => 'Pending',
            'Priority' => $request->Priority,
            'DueDate' => $request->DueDate,
        ]);

        return redirect()->route('tasks.index')
            ->with('success', 'Tâche créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $task = Task::with(['project', 'creator', 'assignee'])
            ->where('AssignedTo', Auth::id())
            ->findOrFail($id);

        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $task = Task::where('AssignedTo', Auth::id())
            ->findOrFail($id);
        $projects = Project::where('Status', 'In Progress')
            ->where('DeveloperID', Auth::id())
            ->get();

        return view('tasks.edit', compact('task', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $task = Task::where('AssignedTo', Auth::id())
            ->findOrFail($id);

        $request->validate([
            'Title' => 'required|string|max:255',
            'Description' => 'required|string',
            'ProjectID' => 'required|exists:projects,ProjectID',
            'DueDate' => 'required|date',
            'Priority' => 'required|in:Low,Medium,High',
            'Status' => 'required|in:Pending,In Progress,Completed',
        ]);

        $task->update([
            'Title' => $request->Title,
            'Description' => $request->Description,
            'ProjectID' => $request->ProjectID,
            'Status' => $request->Status,
            'Priority' => $request->Priority,
            'DueDate' => $request->DueDate,
        ]);

        return redirect()->route('tasks.index')
            ->with('success', 'Tâche mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'Tâche supprimée avec succès.');
    }

    public function assignTask(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        
        $validatedData = $request->validate([
            'AssignedTo' => 'required|exists:users,UserID',
        ]);

        $task->update($validatedData);

        return redirect()->route('tasks.show', $task->TaskID)
            ->with('success', 'Tâche réassignée avec succès.');
    }

    public function updateStatus(Request $request, $id)
    {
        $task = Task::where('AssignedTo', Auth::id())
            ->findOrFail($id);

        $request->validate([
            'Status' => 'required|in:Pending,In Progress,Completed',
        ]);

        $task->update([
            'Status' => $request->Status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Statut de la tâche mis à jour avec succès.'
        ]);
    }

    public function developerTasks()
    {
        $userId = auth()->id();
        $tasks = Task::with(['project'])
            ->where('AssignedTo', $userId)
            ->orderBy('DueDate', 'asc')
            ->paginate(10);

        return view('tasks.developer-tasks', compact('tasks'));
    }
}
