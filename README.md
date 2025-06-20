# TODO TALENAVI TEST

Link Demo: https://www.loom.com/share/6c7aa9735dc8440aa817d71dfc892307?sid=a568af61-daad-4116-90a9-59eee50327df

## Installation

First clone this repository, install the dependencies, and setup your .env file.

```
git clone git@github.com:habibiazmi123/todo-tanevavi-test.git
composer install
cp .env.example .env
```

And run the initial migrations and seeders.

```
php artisan migrate
php artisan db:seed --class=TodoSeeder 
```

## Features

This Laravel-based API provides the following features for managing and visualizing a todo list:

1. Create Todo List
Method: POST `/api/todos/create`
Allows users to submit new todo items to the system. Each todo item can include relevant details such as title, description, due date, and priority.


3. Generate Excel Export
Method: GET `/api/todos/export?title=Non sed aut quo.&assignee=Aiden, Habibi&start=2025-06-01&end=2025-06-30&min=1000&max=2000&status=open,pending&priority=low,high`
Exports the existing todo list into an Excel (.xlsx) file for easy reporting or backup purposes.


4. Get Todo List to Provide Chart
Method: GET `/api/chart?type={status or priority or assignee}`
Retrieves a structured dataset of todo items, formatted to support chart visualizations (e.g., for task completion rates, category distribution, or trends over time).

You can view the API documentation in the `API Todo Telenavi.postman_collection.json` using postman
