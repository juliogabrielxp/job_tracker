

## 🚀 O que ele faz

O Job Tracker serve para acompanhar as vagas de emprego que você se candidatou. Com ele você consegue:

- Cadastrar uma vaga com empresa, cargo, link e anotações
- Acompanhar o progresso de cada vaga por etapas
- Atualizar o status conforme o processo avança
- Deletar vagas que não fazem mais sentido acompanhar

As vagas ficam salvas em um banco de dados online, então os dados não somem quando você fecha a página.

---

## 🛠️ Tecnologias usadas

- **PHP** + **Laravel** — back-end e regras de negócio
- **Bootstrap 5** — interface
- **PostgreSQL** via **Neon** — banco de dados online
---

## ⚙️ Como rodar o projeto

### Pré-requisitos

- PHP 8.1+
- Composer
- Uma conta no [Neon](https://neon.tech) para o banco de dados

### Passo a passo

**1. Clone o repositório:**
```bash
git clone https://github.com/seu-usuario/job_tracker.git
cd job_tracker
```

**2. Instale as dependências:**
```bash
composer install
```

**3. Copie o arquivo de configuração:**
```bash
cp .env.example .env
```

**4. Configure o banco de dados no `.env`:**
```env
DB_CONNECTION=pgsql
DB_HOST=seu-host.neon.tech
DB_PORT=5432
DB_DATABASE=neondb
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

> Crie um projeto no [Neon](https://neon.tech), copie a connection string e preencha os campos acima.

**5. Gere a chave da aplicação:**
```bash
php artisan key:generate
```

**6. Rode a migration para criar a tabela:**
```bash
php artisan migrate
```

**7. Inicie o servidor:**
```bash
php artisan serve
```

Acesse em: [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## 📸 Prints

![Home](/.github/images/home.png)
![Vagas em andamento](/.github/images/home_2.png)
![Cadastro](/.github/images/cadastrar_vaga.png)
![Atualizar vaga](/.github/images/atualizar_vaga.png)

## 📌 Regra de etapas

As vagas seguem uma ordem de progresso:

```
Aplicado → Em andamento → Entrevista → Aprovado
                                     ↘ Reprovado (pode vir de qualquer etapa)
```

Não é possível voltar para uma etapa anterior nem pular etapas.

---

Feito com dedicação em 3 dias. 🚀
