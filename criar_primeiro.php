<?php
$username = 'mrrobot';
$password = '12345678';
exec("powershell.exe -Command \"New-LocalUser -Name '$username' -Password (ConvertTo-SecureString '$password' -AsPlainText -Force)\"", $output, $returnCode);

if ($returnCode === 0) {
    echo "Usuário criado com sucesso!";
} else {
    echo "Erro ao criar o usuário: " . implode("\n", $output);
}
?>