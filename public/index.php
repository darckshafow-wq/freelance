<?php
session_start(); // ✅ démarrer la session une seule fois ici

// Chargement des controllers
require_once __DIR__ . '/../app/controllers/UserController.php';
require_once __DIR__ . '/../app/controllers/WelcomeController.php';
require_once __DIR__ . '/../app/controllers/AdminController.php';
require_once __DIR__ . '/../app/controllers/TaskController.php';
require_once __DIR__ . '/../app/controllers/ApplicationController.php'; // ✅ Ajout manquant
require_once __DIR__ . '/../app/controllers/ReviewController.php';
require_once __DIR__ . '/../app/controllers/MessageController.php';
require_once __DIR__ . '/../app/controllers/NotificationController.php';

// Connexion à la base
require_once __DIR__ . '/../app/core/database.php';
$pdo = (new Database())->getConnection();

// Récupération de la page demandée
$page = $_GET['page'] ?? 'welcome';

// Sécurisation des paramètres GET (id par exemple)
$id = isset($_GET['id']) ? intval($_GET['id']) : null;

switch ($page) {
    case 'dashboard':
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?page=login');
            exit;
        }
        $role = $_SESSION['user']['role'];
        if ($role === 'admin') header('Location: index.php?page=admin');
        elseif ($role === 'client') header('Location: index.php?page=client_dashboard');
        else header('Location: index.php?page=freelance_dashboard');
        exit;
        break;

    // --- Tâches ---
    case 'tasks_fiche':
        include __DIR__ . '/../public/tasks_page/tasks_fiche.php';
        break;

    case 'create_task':
        (new TaskController($pdo))->create();
        break;

    case 'tasks':
        (new TaskController($pdo))->listPublished();
        break;

    case 'task_detail':
        if ($id) {
            $task = (new TaskController($pdo))->getTaskById($id);
            include __DIR__ . '/../public/tasks_page/tasks_detail.php';
        } else {
            include __DIR__ . '/../public/errors/404.php';
        }
        break;

    // --- Admin ---
    case 'admin':
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: index.php?page=login');
            exit;
        }
        (new AdminController($pdo))->dashboard();
        break;

    case 'ad_user':
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: index.php?page=login');
            exit;
        }
        (new AdminController($pdo))->ad_user();
        break;

    case 'ad_aprobation':
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: index.php?page=login');
            exit;
        }
        $adminController = new AdminController($pdo);
        $tasks = $adminController->getPendingTasks();
        $stats = [
            'tasks'     => $adminController->countTasks(),
            'pending'   => $adminController->countPendingTasks(),
            'published' => $adminController->countPublishedTasks(),
            'validated' => $adminController->countValidatedTasks(),
            'active'    => 0,
            'revenue'   => 0
        ];
        include __DIR__ . '/../public/dashboard_page/admin/ad_aprobation.php';
        break;

    case 'ad_tasks':
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: index.php?page=login');
            exit;
        }
        $adminController = new AdminController($pdo);
        $tasks = $adminController->getPublishedTasks();
        $stats = [
            'tasks'     => $adminController->countTasks(),
            'published' => $adminController->countPublishedTasks(),
            'pending'   => $adminController->countPendingTasks(),
            'validated' => $adminController->countValidatedTasks(),
            'active'    => 0,
            'revenue'   => 0
        ];
        include __DIR__ . '/../public/dashboard_page/admin/ad_tasks.php';
        break;

    case 'logs':
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: index.php?page=login');
            exit;
        }
        include __DIR__ . '/../public/dashboard_page/admin/logs.php';
        break;

    case 'settings':
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?page=login');
            exit;
        }
        $role = $_SESSION['user']['role'];
        if ($role === 'admin') include __DIR__ . '/../public/dashboard_page/admin/settings.php';
        elseif ($role === 'client') include __DIR__ . '/../public/dashboard_page/client/client_profile.php'; // Simplified mapping
        else include __DIR__ . '/../public/dashboard_page/freelance/freelance_profile.php'; // Placeholders
        break;

    case 'messages':
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?page=login');
            exit;
        }
        $messageController = new MessageController($pdo);
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'send') {
            $messageController->send();
        }
        include __DIR__ . '/../public/dashboard_page/shared/messages.php';
        break;

    case 'notifications':
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?page=login');
            exit;
        }
        $notifController = new NotificationController($pdo);
        if (isset($_GET['action']) && $_GET['action'] === 'mark_read' && isset($_GET['id'])) {
            $notifController->markRead($_GET['id']);
        }
        $notifications = $notifController->index();
        include __DIR__ . '/../public/dashboard_page/shared/notifications.php';
        break;

    case 'add_review':
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?page=login');
            exit;
        }
        (new ReviewController($pdo))->add();
        break;

    case 'support':
        include __DIR__ . '/../public/dashboard_page/shared/support.php';
        break;

    // --- Authentification ---
    case 'login':
        (new UserController())->login();
        break;

    case 'logout':
        (new UserController())->logout();
        break;

    // --- Pages publiques ---
    case 'accueil':
        (new WelcomeController($pdo))->welcome();
        break;

    case 'register':
        (new UserController())->register();
        break;


    case 'validate_task':
    if ($id) {
        (new AdminController($pdo))->validateTask($id);
    } else {
        include __DIR__ . '/../public/errors/404.php';
    }
    break;

case 'publish_task':
    if ($id) {
        (new AdminController($pdo))->publishTask($id);
    } else {
        include __DIR__ . '/../public/errors/404.php';
    }
    break;

case 'delete_task':
    if ($id) {
        (new AdminController($pdo))->deleteTask($id);
    } else {
        include __DIR__ . '/../public/errors/404.php';
    }
    break;

    // --- Client Dashboard ---
    case 'client_dashboard':
        include __DIR__ . '/../public/dashboard_page/client/dashboard_client.php';
        break;

    case 'my_tasks':
        include __DIR__ . '/../public/dashboard_page/client/my_tasks.php';
        break;
        
    case 'client_profile':
        include __DIR__ . '/../public/dashboard_page/client/client_profile.php';
        break;

    case 'client_applications':
        (new ApplicationController($pdo))->clientApplications();
        break;

    case 'update_application_status':
        (new ApplicationController($pdo))->updateApplicationStatus();
        break;

    // --- Freelance Dashboard ---
    case 'freelance_dashboard':
        include __DIR__ . '/../public/dashboard_page/freelance/dashboard_freelance.php';
        break;
    
    case 'tasks_list':
        (new TaskController($pdo))->listPublished();
        break;

    case 'task_detail':
        $id = $_GET['id'] ?? 0;
        (new TaskController($pdo))->getTaskById($id); // This returns data but doesn't include view? 
        // Wait, getTaskById in controller just returns data.
        // We need to fetch data and include view here.
        // Or add a show() method to controller.
        // For now, let's stick to the pattern, but access model properly?
        // TaskController properties are private.
        // Let's rely on a new method in TaskController or just use the model directly if possible? 
        // No, $pdo is available. 
        $task = (new TaskController($pdo))->getTaskById($id);
        include __DIR__ . '/../public/tasks_page/tasks_detail.php';
        break;

    case 'apply_task':
        (new ApplicationController($pdo))->apply();
        break;

    case 'my_applications':
         (new ApplicationController($pdo))->myApplications();
         break;

    case 'welcome':
        // Splash screen/Landing de présentation
        if (isset($_SESSION['user'])) {
            $role = $_SESSION['user']['role'];
            if ($role === 'admin') header('Location: index.php?page=admin');
            elseif ($role === 'client') header('Location: index.php?page=client_dashboard');
            else header('Location: index.php?page=freelance_dashboard');
            exit;
        }
        (new WelcomeController($pdo))->welcome();
        break;

    default:
        (new WelcomeController($pdo))->welcome();
        break;
}