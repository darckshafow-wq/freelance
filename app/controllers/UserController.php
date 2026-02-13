<?php
require_once __DIR__ . '/../models/User.php';

class UserController {

    /**
     * Page d'inscription (register)
     */
    public function register() {
        if (isset($_SESSION['user'])) {
            $role = $_SESSION['user']['role'];
            if ($role === 'admin') $this->redirect('admin');
            elseif ($role === 'client') $this->redirect('client_dashboard');
            else $this->redirect('freelance_dashboard');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $role = $_POST['role'] ?? 'client';

            // Validation basique
            if (empty($name) || empty($email) || empty($password)) {
                $_SESSION['error'] = "Tous les champs sont obligatoires.";
                $this->redirect('register');
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = "Adresse email invalide.";
                $this->redirect('register');
            }

            if (strlen($password) < 8) {
                $_SESSION['error'] = "Le mot de passe doit contenir au moins 8 caractères.";
                $this->redirect('register');
            }

            // Hashage du mot de passe
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $user = new User();

            try {
                $userId = $user->create($name, $email, $hashedPassword, $role);
                
                // Auto-login after registration
                $_SESSION['user'] = [
                    'id' => $userId,
                    'name' => $name,
                    'email' => $email,
                    'role' => $role
                ];
                
                $_SESSION['success'] = "Bienvenue $name, votre compte a été créé avec succès !";
                
                // Redirection spécifique au rôle
                if ($role === 'admin') $this->redirect('admin');
                elseif ($role === 'client') $this->redirect('client_dashboard');
                else $this->redirect('freelance_dashboard');
            } catch (Exception $e) {
                $_SESSION['error'] = $e->getMessage();
                $this->redirect('register');
            }
        } else {
            include __DIR__ . '/../../public/auth_page/register.php';
        }
    }

    /**
     * Page de connexion
     */
    public function login() {
        if (isset($_SESSION['user'])) {
            $role = $_SESSION['user']['role'];
            if ($role === 'admin') $this->redirect('admin');
            elseif ($role === 'client') $this->redirect('client_dashboard');
            else $this->redirect('freelance_dashboard');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                $_SESSION['error'] = "Veuillez remplir tous les champs.";
                $this->redirect('login');
            }

            $user = new User();
            $result = $user->login($email, $password);

            if ($result) {
                $_SESSION['user'] = $result;
                $_SESSION['success'] = "Bienvenue " . htmlspecialchars($result['name']) . " !";

                // Redirection spécifique au rôle
                $role = $result['role'];
                if ($role === 'admin') $this->redirect('admin');
                elseif ($role === 'client') $this->redirect('client_dashboard');
                else $this->redirect('freelance_dashboard');
            } else {
                $_SESSION['error'] = "Email ou mot de passe incorrect.";
                $this->redirect('login');
            }
        } else {
            include __DIR__ . '/../../public/auth_page/login.php';
        }
    }

    /**
     * Déconnexion
     */
    public function logout() {
        $_SESSION = [];
        session_destroy();
        $this->redirect('welcome');
    }

    /**
     * Redirection centralisée
     */
    private function redirect($page) {
        header("Location: index.php?page=$page");
        exit;
    }
}