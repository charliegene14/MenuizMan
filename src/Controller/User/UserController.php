<?php

namespace App\Controller\User;

use Exception;
use App\Entity\User;
use App\Entity\UserAction;
use App\Exception\ManagerException;
use App\Manager\RoleManager;
use App\Manager\UserManager;
use App\Exception\NotFoundException;
use App\Manager\UserActionManager;

class UserController {

    /**
     * Main controller for user CRUD
     *
     * @return void
     */
    public static function main() {
        
        $action = isset($_GET["action"]) ? $_GET["action"] : null;

        switch($action) {

            case "create":
                self::create();
                break;

            case "update":
                self::update();
                break;

            case "delete":
              
                self::delete();
                
                break;
        }
    }

    /**
     * Controller on creating a user
     *
     * @return void
     */
    private static function create() {

        global $user;

        $roles = RoleManager::getAll();

        if (isset($_GET["create"])) {

            self::inputsControls($_POST);

            $newUser = new User(
                $_POST["firstName"],
                $_POST["lastName"],
                RoleManager::getOneBy([
                    "roleID" => $_POST["roleID"]
                ]),
                $_POST["login"],
                password_hash($_POST["password"], PASSWORD_DEFAULT)
            );
                
            $exec = UserManager::insert($newUser);

            if ($exec) {
                header("Location: ./?p=user&action=create&success=true");
                exit();
            }

            throw new ManagerException("Impossible d'ajouter l'utilisateur en BDD.");
        }

        include "views/admin/create_user.php";
    }
    
    /**
     * Controller on updating a user
     *
     * @return void
     */
    private static function update() {

        global $user;

        $id = isset($_GET["id"]) ? intval($_GET["id"]) : null;

        /**
         * @var User
         */
        $updateUser = UserManager::getOneBy(["userID" => $id]);
        if (!$updateUser) throw new NotFoundException();

        $roles = RoleManager::getAll();

        if (isset($_GET["update"])) {

            if ($_POST["password"] === "") {
                $_POST["password"] = $updateUser->getPassword();
            } else {
                $_POST["password"] = password_hash($_POST["password"], PASSWORD_DEFAULT);
            }

            self::inputsControls($_POST);

            $updateUser->setFirstName($_POST["firstName"]);
            $updateUser->setLastName($_POST["lastName"]);
            $updateUser->setLogin($_POST["login"]);
            $updateUser->setPassword($_POST["password"]);
            $updateUser->setRole(RoleManager::getOneBy(["roleID" => $_POST["roleID"]]));

            $exec = UserManager::update($updateUser);

            if ($exec) {
                header("Location: ./?p=user&action=update&id=" .$id. "&success=true");
                exit();
            }

            throw new ManagerException("Impossible d'ajouter l'utilisateur en BDD.");
        }
        

        include "views/admin/update_user.php";

    }

    /**
     * Controller on deleting a user
     *
     * @return void
     */
    private static function delete() {

        global $user;

          
        $id = isset($_GET["id"]) ? intval($_GET["id"]) : null;
        $selectedUser = UserManager::getOneBy(["userID" => $id]);
        if (!$selectedUser) throw new NotFoundException();

        if($selectedUser->getId() === $user->getId()){
            header("location:./?p=martoni"); 
            exit();
        }

        if (count(UserActionManager::getBy(["doonticket.userID" => $selectedUser->getId()])) > 0) {
            throw new Exception("L'utilisateur est présent dans l'historique des tickets.");
        }

        $exec = UserManager::deleteBy(["userID"=>$selectedUser->getId()]);

        if($exec) {
            header("location:/");
        } else {
            throw new ManagerException ("Impossible de mettre à jour la BDD");
        }

    }

    /**
     * User form controls
     *
     * @param array $inputs
     * @return void
     */
    private static function inputsControls(array $inputs) {

        $aRoles = ["ADM", "MNG", "AST", "HLT"];
            
        if ($_GET["action"] === "create" && UserManager::getOneBy(["login" => $inputs["login"]]))
            throw new Exception("Ce login existe déjà. <a href='./?p=user&action=create'>Retour</a>");

        if (!isset($inputs["lastName"]) || strlen($inputs["lastName"]) > 20 || strlen($inputs["lastName"]) < 1)
            throw new Exception("Le nom ne doit pas dépasser 20 caractères. <a href='./?p=user&action=create'>Retour</a>");

        if (!isset($inputs["firstName"]) || strlen($inputs["firstName"]) > 20 || strlen($inputs["firstName"]) < 1)
            throw new Exception("Le prénom ne doit pas dépasser 20 caractères. <a href='./?p=user&action=create'>Retour</a>");

        if (!isset($inputs["login"]) || strlen($inputs["login"]) > 16 || strlen($inputs["login"]) < 1)
            throw new Exception("Le login ne doit pas dépasser 16 caractères. <a href='./?p=user&action=create'>Retour</a>");

        if (!isset($inputs["password"]) || strlen($inputs["password"]) < 1)
            throw new Exception("Le mot de passe doit contenir au moins un caractère. <a href='./?p=user&action=create'>Retour</a>");

        if (!isset($inputs["roleID"]) || !in_array($inputs["roleID"], $aRoles)) {
            header("location: ./?p=martoni");
            exit();
        }
    }
}