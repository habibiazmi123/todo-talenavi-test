<?php

namespace App\Exports;

use App\Models\Todo;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TodoExport implements FromView
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function view(): View
    {
        $query = Todo::query();

        if (!empty($this->filters['title'])) {
            $query->where('title', 'like', '%' . $this->filters['title'] . '%');
        }

        if (!empty($this->filters['assignee'])) {
            $assignees = $this->filters['assignee'];
            $query->where(function ($q) use ($assignees) {
                foreach ($assignees as $assignee) {
                    $q->orWhere('assignee', 'like', '%' . $assignee . '%');
                }
            });
        }

        if (!empty($this->filters['start']) && !empty($this->filters['end'])) {
            $query->whereBetween('due_date', [$this->filters['start'], $this->filters['end']]);
        }

        if (!empty($this->filters['min']) && !empty($this->filters['max'])) {
            $query->whereBetween('time_tracked', [$this->filters['min'], $this->filters['max']]);
        }

        if (!empty($this->filters['status'])) {
            $statuses = $this->filters['status'];
            $query->whereIn('status', $statuses);
        }

        if (!empty($this->filters['priority'])) {
            $priorities = $this->filters['priority'];
            $query->whereIn('priority', $priorities);
        }

        $todos = $query->get();
        $totalTodos = $todos->count();
        $totalTimeTracked = $todos->sum('time_tracked');

        return view('exports.todos', [
            'todos' => $todos,
            'totalTodos' => $totalTodos,
            'totalTimeTracked' => $totalTimeTracked,
        ]);
    }
}
