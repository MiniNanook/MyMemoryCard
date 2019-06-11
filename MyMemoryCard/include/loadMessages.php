<?php

    $user = Usuario::buscaUsuarioId($_SESSION['user']->id());
    $messages = $user->cargaMensajes();

?>