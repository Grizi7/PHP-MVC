<!-- filepath: c:\wamp64\www\PHP-MVC\README.md -->
# 🚀 PHP-MVC Framework

A lightweight, modern MVC framework for PHP applications with built-in authentication, database abstraction, form validation, and more.

## 🔍 Overview

This PHP-MVC framework provides a structured architecture for building web applications following the Model-View-Controller pattern. It includes essential features like routing, database interactions, form handling, authentication, and session management.

## ✨ Features

- **MVC Architecture**: Clean separation of concerns with Models, Views, and Controllers
- **Routing System**: Simple and flexible URL routing
- **Database Abstraction**: PDO-based database interactions with migration support
- **Form Handling**: Built-in form validation and rendering
- **Authentication**: User registration, login, and access control
- **Session Management**: Secure session handling with flash messages
- **Middleware Support**: Filter requests before they reach controllers
- **Validation Rules**: Extensive validation for form inputs
- **Layouts System**: Reusable view layouts and components

## 📋 Requirements

- PHP 8.0+
- PDO PHP Extension
- MySQL/MariaDB

## 💾 Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/Grizi7/PHP-MVC.git
   ```

2. Install dependencies via Composer:
   ```bash
   composer install
   ```

3. Create a `.env` file (use `.env.example` as template):
   ```
   DB_DSN = mysql:host=localhost;port=3306;dbname=your_database
   DB_USER = root
   DB_PASSWORD = your_password
   ```

4. Run database migrations:
   ```bash
   php migrations.php
   ```

5. Configure your web server to point to the `public` directory.

## 📁 Project Structure

```
PHP-MVC/
├── controllers/          # Application controllers
├── core/                 # Framework core components
│   ├── form/             # Form handling classes
│   ├── middlewares/      # Middleware components
│   └── exceptions/       # Custom exceptions
├── migrations/           # Database migrations
├── models/               # Application models
├── public/               # Web-accessible files
├── requests/             # Form request validation
├── runtime/              # Runtime data and logs
├── views/                # View templates
│   └── layouts/          # Layout templates
├── .env.example          # Environment config template
├── composer.json         # Composer dependencies
├── migrations.php        # Migration runner
└── README.md             # Project documentation
```

## 🔰 Basic Usage

### 🛣️ Creating a Route

Define routes in `public/index.php`:

```php
$app->router->get('/users', [UserController::class, 'index']);
$app->router->post('/users/create', [UserController::class, 'create']);
```

### 🎮 Creating a Controller

```php
namespace app\controllers;

use app\core\Controller;
use app\core\Request;

class UserController extends Controller
{
    public function index(): string
    {
        return $this->render('users/index', [
            'users' => User::findAll()
        ]);
    }
    
    public function create(Request $request): string
    {
        // Handle form submission...
    }
}
```

### 📊 Creating a Model

```php
namespace app\models;

use app\core\DBModel;

class User extends DBModel
{
    public static string $tableName = 'users';
    
    public function attributes(): array
    {
        return ['name', 'email', 'password'];
    }
    
    public function rules(): array
    {
        return [
            'name' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE, 'class' => self::class]]
        ];
    }
}
```

### 👁️ Creating a View

Views are PHP files in the `views` directory:

```php
<!-- views/users/index.php -->
<h1>Users</h1>
<div class="user-list">
    <?php foreach ($users as $user): ?>
        <div class="user-item">
            <?= htmlspecialchars($user->name) ?>
        </div>
    <?php endforeach; ?>
</div>
```

## 📝 Form Handling

The framework provides a simple way to create and validate forms:

```php
<?php $form::begin('register', 'post') ?>
    <div class="row">
        <div class="col">
            <?= $form->field($model, 'first_name') ?>
        </div>
        <div class="col">
            <?= $form->field($model, 'last_name') ?>
        </div>
    </div>
    <?= $form->field($model, 'email', 'email') ?>
    <?= $form->field($model, 'password', 'password') ?>
<?php $form::end() ?>
```

## 🔒 Authentication

The framework includes built-in authentication with registration, login, and profile management:

```php
// Login a user
$user = new User();
$user->email = $email;
$user->password = $password;
$user->login();

// Check authentication
if (isGuest()) {
    // Handle unauthenticated user
}
```

## 🧩 Middleware

Middleware can be used to filter HTTP requests:

```php
// Register middleware in a controller
public function __construct()
{
    $this->registerMiddleware(new AuthMiddleware(['profile']));
}
```

## 🛠️ Helper Functions

The framework includes useful helper functions:

```php
// Redirect to a different URL
redirect('/home');

// Set flash message
sessionFlashSet('success', 'Operation completed successfully');

// Get authenticated user
$currentUser = user();
```

## 🗃️ Database Migrations

Create a new migration:

1. Create a file in the `migrations` directory (e.g., `m_004_create_posts.php`):

```php
<?php
use app\core\Application;

class m_004_create_posts
{
    public function up()
    {
        $db = Application::$app->db;
        $SQL = "CREATE TABLE posts (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            content TEXT NOT NULL,
            user_id INT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id)
        ) ENGINE=INNODB;";
        $db->pdo->exec($SQL);
    }

    public function down()
    {
        $db = Application::$app->db;
        $SQL = "DROP TABLE IF EXISTS posts;";
        $db->pdo->exec($SQL);
    }
}
```

2. Run the migrations:
```bash
php migrations.php
```

## 📜 License

MIT License

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## 👩‍💻 Author

**Grizi7**
[Portfolio](https://grizi7.com)
