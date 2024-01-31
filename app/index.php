    <?php

    require_once 'controllers/HomeAdminController.php';
    require_once 'controllers/RegisterController.php';
    require_once 'controllers/LoginController.php';

    require_once __DIR__ . '/vendor/autoload.php';


    use Twig\Environment;
    use Twig\Loader\FilesystemLoader;
    include_once "connection.php";
    $loader = new FilesystemLoader(__DIR__ . '/views');
    $twig = new Environment($loader);
    $twig->addExtension(new \Twig\Extension\DebugExtension());


    $registerController = new RegisterController($conn);
    $loginController = new LoginController($conn);

    $homeController = new HomeController();
    session_start();
    $page = $_GET['page'] ?? '';

    switch ($page) {
        case 'login':
            $loginController->loginUser();
            break;
        case 'register':
            $registerController->handleFormSubmission();       
            break;
        case 'admin':
            $homeController->showAdminPage();
            break;
        case 'delete_user':
            $homeController->deleteUser();
            break;
        case 'edit_user':
            $homeController->editUser();
            break;
        case 'promote_user':
            $homeController->promoteUser();
            break;
        case 'manager':
            $homeController->showManagerPage();
            break;
        case 'add_language':
            $homeController->addLanguage();
            break;
        case 'add_study_format':
            $homeController->addStudyFormat();
            break;
        case 'userPage':
            // da se ne prikazu obe poruke pri submitovanju user choica ili suggestije
            if (isset($_POST['form-type'])) {
                $formType = $_POST['form-type'];
                if ($formType === 'user-choice-form') {
                    // ako korisnik bira koj ce jezik da uci
                    $homeController->handleUserChoiceForm();
                } elseif ($formType === 'user-suggestion-form') {
                    // ako korisnik pise sugestiju
                    $homeController->handleUserSuggestion();
                } elseif($formType === 'user-table-form'){
                    //ovo je za kada korisnik pritisene i want to join this group
                    $homeController->handleUserChoiceForm();
                }
            }
            $homeController->userPage();
            break;
        case 'logout':
            $homeController->logout();
            break;
        default:
            $homeController->index();
            break;
    }
