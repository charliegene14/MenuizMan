<?php

require './vendor/autoload.php';
require './src/Includes/functions.php';

use App\Services\Authentication;
use App\Exception\SearchException;
use App\Exception\ManagerException;
use App\Exception\NotFoundException;
use App\Controller\Router\UserRouter;
use App\Controller\Router\AdminRouter;
use App\Controller\Authentication\AuthenticationController;

try {

    session_start();

    /**
     * Default Home Page
     */
    $page = isset($_GET["p"]) ? $_GET["p"] : "home";

    /**
     * Get authentication
     */
    $user = Authentication::getUser();
    $userRole = $user ? $user->getRole()->getId() : null;

    /**
     * Router
     */

    if(isset($_GET["p"]) && ($_GET["p"]==="martoni")){
        require_once "./views/martoni.php";
        exit();
    }
     
    switch ($userRole) {

        case "ADM":
            AdminRouter::main();
            break;

        case "MNG":
        case "HLT":
        case "AST":
            UserRouter::main();
            break;

        default:
            AuthenticationController::main();
    }

/**
 *  Exceptions
 */
} catch (ManagerException $e) {
    
    $exception = $e->getMessage();
    require_once "views/exception.php";

} catch (PDOException $e) {

    $exception = $e->getMessage();
    require_once "views/exception.php";

} catch (SearchException $e) {

    $exception = $e->getMessage();
    require_once "views/exception.php";

} catch (NotFoundException $e) {

    include "views/404.php";
    
} catch (Exception $e) {

    $exception = $e->getMessage();
    require_once "views/exception.php";
}
