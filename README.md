# Steam Keys Store - PHP MVC (POO)

Estrutura básica de uma loja de keys (exemplo educacional).

## Como usar
1. Crie um banco MySQL e importe `sql/schema.sql`, ou rode o arquivo SQL diretamente (`mysql -u root < sql/schema.sql`).
2. Ajuste `config/database.php` com suas credenciais do banco.
3. Coloque a pasta em um servidor PHP (ex: XAMPP, Laragon) e acesse `index.php`.
4. O sistema é um exemplo educacional — **não** use em produção sem revisar segurança adicional.

## Avisos
- As chaves Steam aqui são armazenadas em texto. Para produção, criptografe/mascare conforme necessário.
- Proteja rotas administrativas, valide inputs, sanitize e aplique CSRF tokens em produção.
