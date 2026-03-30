<?php
$username = 'mrrobot';
exec("powershell.exe -Command \"Add-LocalGroupMember -Group 'Administradores' -Member '$username'\"", $output, $returnCode);

if ($returnCode === 0) {
    echo "Permissões de administrador concedidas com sucesso!";
} else {
    echo "Erro ao conceder permissões de administrador: " . implode("\n", $output);
}
?>