<table>
    <thead>
        <tr>
            <th>Title</th>
            <th>Assignee</th>
            <th>Due Date</th>
            <th>Time Tracked</th>
            <th>Status</th>
            <th>Priority</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($todos as $todo)
            <tr>
                <td>{{ $todo->title }}</td>
                <td>{{ $todo->assignee }}</td>
                <td>{{ $todo->due_date }}</td>
                <td>{{ $todo->time_tracked }}</td>
                <td>{{ $todo->status }}</td>
                <td>{{ $todo->priority }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="2"><strong>Total Todos: </strong> {{ $totalTodos }}</td>
            <td colspan="2"><strong>Total Time Tracked: </strong> {{ $totalTimeTracked }}</td>
            <td colspan="2"></td>
        </tr>
    </tbody>
</table>
