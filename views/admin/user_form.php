<div class="form-group">

    <label for="lastName">Nom</label>
    <span style="display: none" class="messerror">Le nom ne doit pas dépasser 20 caractères</span>
    <input value="<?= isset($updateUser) ? $updateUser->getLastName() : null ?>" autocomplete="off" class="form-control" type="text" name="lastName" id="lastName" placeholder="Saisir le nom de l'utilisateur">

    <label for="firstName">Prénom</label>
    <span style="display: none" class="messerror">Le prénom ne doit pas dépasser 20 caractères</span>
    <input value="<?= isset($updateUser) ? $updateUser->getFirstName() : null ?>" autocomplete="off" class="form-control" type="text" name="firstName" id="firstName" placeholder="Saisir le prénom de l'utilisateur">

    <label for="login">Login</label>
    <span style="display: none" class="messerror">Le login ne doit pas dépasser 16 caractères</span>
    <input value="<?= isset($updateUser) ? $updateUser->getLogin() : null ?>" autocomplete="off" class="form-control" type="text" name="login" id="login" placeholder="Saisir le login de l'utilisateur">

    <label for="password">Mot de passe</label>
    <input autocomplete="new-password" class="form-control" type="password" name="password" id="password" placeholder="Saisir le mot de passe de l'utilisateur">

    <label for="roleID">Role</label>
    <br />
    <select class="form-control" name="roleID" id="roleID">
        <?php foreach($roles as $role): ?>
            <option value="<?=$role->getId()?>"
            <?php if (isset($updateUser) && $updateUser->getRole()->getId() === $role->getId()) echo "selected" ?>
            >
            
            <?= $role->getName() ?>
        
            </option>
        <?php endforeach; ?>
    </select>

</div>
<br />
<span id ="errglobal" style="display: none" class="messerror">Un champs est manquant.</span>

<input style="float: right" class="btn btn-primary" type="submit" value="Valider">