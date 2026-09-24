# 📝 Task Manager

Usa ka **simple pero limpyo** nga Task Management System nga gama sa **PHP + MySQL**. Naa nay kompletong CRUD (Create, Read, Update, Delete) nga features ug moderno nga glassmorphism design.

![PHP](https://img.shields.io/badge/PHP-8.x-777BB4?logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?logo=mysql&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green)

---

##  Features

-  **Add Task** – Mag-dugang ug bag-ong task nga naay name, description, ug due date
- **View Tasks** – Tan-awa tanan tasks sa usa ka limpyo nga table
-  **Edit Task** – I-update ang task name, description, status, ug due date
-  **Delete Task** – Tangtanga ang task (naa nay confirmation prompt)
-  **Update Status** – Toggle sa **Pending** ↔ **Completed** nga usa ka click
-  **Glassmorphism UI** – Modern glass-effect design nga naay blur
-  **Random Background** – Mo-usab ang background image sa matag page refresh
-  **Secure** – Prepared statements (anti SQL injection) ug XSS protection

---

## 🛠️ Tech Stack

| Technology | Purpose |
| --- | --- |
| **PHP 8.x** | Backend logic (procedural + PDO) |
| **MySQL** | Relational database |
| **PDO** | Secure database queries (prepared statements) |
| **HTML5 / CSS3** | Frontend structure ug glassmorphism styling |
| **Lorem Picsum API** | Random background images |

> **Note:** Adunay **Laravel version** sa project nga gi-develop (MVC pattern) — kaning plain PHP version mao ang lightweight/core version. Ang Laravel version naggamit og Eloquent ORM, Blade templates, ug migrations.

---

## 🚀 Installation

### Kinahanglan

- [XAMPP](https://www.apachefriends.org/) (o bisan unsang local server nga naay PHP + MySQL)
- Web browser (Chrome, Firefox, Edge)
- Internet connection (para sa random background images)

### Steps

1. **I-clone o i-copy** ang project folder ngadto sa imong XAMPP `htdocs` directory:

```javascript
   C:\xampp\htdocs\task_manager\
```

2. **I-import ang database** — open ang `http://localhost/phpmyadmin` sa browser:

- Click **Import** tab
- Pili ang `database.sql` file
- Click **Go**

(O i-run manuale ang SQL file sa MySQL command line)

3. **I-adjust ang database connection** — open ang `db.php`:

```php
   $username = "root";   // imong MySQL username
   $password = "";       // imong MySQL password
```

4. **I-start ang Apache ug MySQL** sa XAMPP Control Panel.
5. **Open sa browser:**

```javascript
   http://localhost/task_manager/
```

---

## 📁 File Structure

```javascript
task_manager/
│
├──  index.php           # Main page - view all tasks + add task form
├──  add_task.php        # Handles adding new tasks
├──  edit_task.php       # Edit/update task information
├──  delete_task.php     # Deletes a task
├──  update_status.php   # Toggles Pending ↔ Completed
├──  db.php              # Database connection (PDO)
├──  style.css           # Glassmorphism styles
└──  database.sql        # Database + table creation script
```

---

## 🗄️ Database Schema

| Column | Type | Description |
| --- | --- | --- |
| `id` | `INT (AUTO_INCREMENT)` | Task ID (Primary Key) |
| `task_name` | `VARCHAR(150)` | Name of the task |
| `description` | `TEXT` | Task details |
| `status` | `ENUM('Pending', 'Completed')` | Task status |
| `due_date` | `DATE` | Task deadline |
| `created_at` | `TIMESTAMP` | Creation timestamp |

---

##  Usage

1. **Add Task** – Fill up the form sa ibabaw, then click **+ Add Task**
2. **Mark as Done** – Click **✔ Mark Done** sa task list
3. **Undo** – Click **↺ Undo** kung na-done na pero balikon
4. **Edit** – Click **✏ Edit** para ma-update ang details
5. **Delete** – Click **🗑 Delete** (mo-confirm sa una)

---

##  Security Features

-  **Prepared Statements** – protektado sa SQL injection
- **Input Validation** – required fields naa nay server-side check
-  **XSS Protection** – `htmlspecialchars()` sa tanan output
-  **Confirmation Dialog** – delete action dali ra ma-preventan

---

## 🔮 Laravel Version

Ang project naa pud kay **Laravel version** nga naggamit og MVC architecture! Ni ang mga components:

| Component | Description |
| --- | --- |
| **Laravel 10+** | PHP framework nga naggamit og MVC pattern |
| **Routes** | `routes/web.php` — resource routes + status toggle |
| **Controller** | `TaskController` — CRUD logic ug validation |
| **Model** | `Task` model nga naggamit og Eloquent ORM |
| **Blade Views** | Layout + task pages nga naa'y glassmorphism design |
| **Database** | Migration para sa `tasks` table + TaskSeeder |

### 📁 Laravel File Structure

```javascript
task-manager-laravel/
│
├── 🗄 database/
│   ├── migrations/
│   │   └── xxxx_create_tasks_table.php   # Tasks table schema
│   └── seeders/
│       └── TaskSeeder.php                # Sample task data
│
├──  app/
│   ├── Models/
│   │   └── Task.php                      # Eloquent model ($fillable, scopes)
│   └── Http/Controllers/
│       └── TaskController.php            # index, create, store, edit,
│                                         # update, destroy, updateStatus
│
├──  resources/views/
│   ├── layouts/
│   │   └── app.blade.php                 # Master layout (glassmorphism)
│   └── tasks/
│       ├── index.blade.php               # Task list table
│       ├── create.blade.php              # Add task form
│       └── edit.blade.php                # Edit task form
│
├──  routes/
│   └── web.php                           # All application routes
│
└──  public/css/
    └── style.css                         # Glassmorphism styles
```

###  Routes (`routes/web.php`)

```php
Route::get('/', [TaskController::class, 'index'])->name('home');

// Resource route para sa CRUD
// (index, create, store, edit, update, destroy)
Route::resource('tasks', TaskController::class);

// Status toggle route (Pending <-> Completed)
Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])
      ->name('tasks.status');
```

### 🧠 Model (`app/Models/Task.php`)

```php
class Task extends Model
{
    protected $fillable = [
        'task_name',
        'description',
        'status',
        'due_date',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    public function scopePending($query)   { return $query->where('status', 'Pending'); }
    public function scopeCompleted($query) { return $query->where('status', 'Completed'); }
}
```

### 🎮 Controller (`app/Http/Controllers/TaskController.php`)

```php
class TaskController extends Controller
{
    // View all tasks
    public function index()
    {
        $tasks = Task::orderByRaw('due_date IS NULL, due_date ASC')->latest()->get();
        return view('tasks.index', compact('tasks'));
    }

    // Store new task (with validation)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'task_name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
        ]);

        Task::create([...$validated, 'status' => 'Pending']);

        return redirect()->route('tasks.index')->with('success', 'Task added! 🎉');
    }

    // Toggle status (Pending <-> Completed)
    public function updateStatus(Task $task)
    {
        $task->update([
            'status' => $task->status === 'Pending' ? 'Completed' : 'Pending',
        ]);

        return redirect()->route('tasks.index');
    }
}
```

###  Blade Views (`resources/views/`)

| View | Purpose |
| --- | --- |
| `layouts/app.blade.php` | Master layout — header, glassmorphism design, alert messages |
| `tasks/index.blade.php` | Task table nga naay status badges ug action buttons |
| `tasks/create.blade.php` | Add task form nga naay `@csrf` protection |
| `tasks/edit.blade.php` | Edit form nga naay `old()` input preservation |

**Sample Blade syntax:**

```blade
@extends('layouts.app')

@section('content')
    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf
        <input type="text" name="task_name" required>
        <button type="submit">Save Task</button>
    </form>
@endsection
```

### 🗄️Database (Migration + Seeder)

```php
// Migration: create_tasks_table.php
Schema::create('tasks', function (Blueprint $table) {
    $table->id();
    $table->string('task_name', 150);
    $table->text('description')->nullable();
    $table->enum('status', ['Pending', 'Completed'])->default('Pending');
    $table->date('due_date')->nullable();
    $table->timestamps();
});
```

###  Laravel Installation & Database Connection

#### 1. I-install ang Laravel project

```bash
composer create-project laravel/laravel task-manager-laravel
cd task-manager-laravel
```

#### 2. I-configure ang `.env` file

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_manager_db
DB_USERNAME=root
DB_PASSWORD=
```

#### 3. I-run ang migration ug seeder

```bash
php artisan migrate
php artisan db:seed --class=TaskSeeder
```

#### 4. I-serve ang app

```bash
php artisan serve
```

Open ang `http://127.0.0.1:8000/` — naa nay sample data gikan sa seeder! 🎉

---

##  License

MIT License – Feel free to use, modify, and distribute bai! 😄

---

<p align="center">Gihimo with 💚 ug daghang ☕</p>