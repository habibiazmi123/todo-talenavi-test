<?php

namespace App\Http\Controllers\Api;

use App\Exports\TodoExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExportTodoRequest;
use App\Http\Requests\GetChartTodoRequest;
use App\Http\Requests\StoreTodoRequest;
use App\Models\Todo;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TodoApiController extends Controller
{
    public function store(StoreTodoRequest $request)
    {
        $validatedData = $request->only([
            'title',
            'assignee',
            'due_date',
            'time_tracked',
            'status',
            'priority'
        ]);

        $todo = new Todo($validatedData);
        $todo->save();

        return response()->json(['message' => 'Todo created successfully', 'todo' => $todo->fresh()], 201);
    }

    public function export(ExportTodoRequest $request)
    {
        $filters = $request->only([
            'title',
            'assignee',
            'start',
            'end',
            'min',
            'max',
            'status',
            'priority'
        ]);

        return Excel::download(new TodoExport($filters), 'todos.xlsx');
    }

    public function getChartData(GetChartTodoRequest $request)
    {
        return match ($request->type) {
            'status' => $this->statusSummary(),
            'priority' => $this->prioritySummary(),
            'assignee' => $this->assigneeSummary(),
            default => response()->json(['error' => 'Invalid chart type'], 422),
        };
    }

    private function statusSummary()
    {
        $data = Todo::select('status')
            ->selectRaw('count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return response()->json([
            'status_summary' => $data
        ]);
    }

    private function prioritySummary()
    {
        $data = Todo::select('priority')
            ->selectRaw('count(*) as total')
            ->groupBy('priority')
            ->pluck('total', 'priority');

        return response()->json([
            'priority_summary' => $data
        ]);
    }

    private function assigneeSummary()
    {
        $data = Todo::select('assignee')
            ->whereNotNull('assignee')
            ->groupBy('assignee')
            ->get()
            ->mapWithKeys(function ($todo) {
                $assignee = $todo->assignee;

                return [
                    $assignee => [
                        'total_todos' => Todo::where('assignee', $assignee)->count(),
                        'total_pending_todos' => Todo::where('assignee', $assignee)->where('status', 'pending')->count(),
                        'total_timetracked_completed_todos' => (int) Todo::where('assignee', $assignee)
                            ->where('status', 'completed')
                            ->sum('time_tracked'),
                    ]
                ];
            });

        return response()->json([
            'assignee_summary' => $data,
        ]);
    }
}
