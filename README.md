# WampServer Local Privilege Escalation via Apache Service Misconfiguration

## Aviso

Este conteúdo é fornecido exclusivamente para fins educacionais, auditoria de segurança e testes autorizados. O uso indevido destas informações pode violar leis locais. O autor não se responsabiliza por qualquer uso inadequado.

---

## Resumo

Este repositório documenta uma vulnerabilidade de escalonamento de privilégios local (Local Privilege Escalation - LPE) em ambientes que utilizam o WampServer no Windows, quando o serviço Apache (`wampapache`) é executado com privilégios de `LocalSystem`.

Nessa configuração, qualquer script PHP executado pelo servidor web herda privilégios de nível SYSTEM, permitindo execução arbitrária de comandos no sistema operacional com o mais alto nível de privilégio disponível.

---

## Causa Raiz

A vulnerabilidade não decorre de um bug de software, mas de uma combinação de fatores:

- Execução do serviço Apache como `LocalSystem`
- Permissão para execução de comandos do sistema via funções PHP (`exec`, `system`, etc.)
- Permissões inadequadas no diretório web (`www`), frequentemente gravável por usuários não privilegiados

Essa combinação permite que código controlado por um usuário seja executado com privilégios elevados.

---

## Pré-requisitos

Para que a exploração seja possível, é necessário:

- WampServer instalado e em execução
- Serviço Apache rodando como `LocalSystem`
- Acesso ao diretório `www` com permissão de escrita
- Capacidade de acessar o servidor via navegador (localhost ou rede)

O acesso inicial pode ocorrer por:

- Acesso físico à máquina
- Acesso remoto via RDP ou sessão de usuário comum
- Upload de arquivos em aplicação web vulnerável
- Comprometimento prévio de baixa privilégio

---

## Passo a Passo da Exploração

### 1. Identificação do diretório web

Local padrão:
