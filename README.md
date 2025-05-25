## 📂 Sobre o Projeto

O **FilesSystem** é uma aplicação desenvolvida em **Laravel** com o objetivo de gerenciar arquivos e pastas de forma eficiente. O projeto serve como aprendizado sobre o sistema de arquivos do Laravel, implementando funcionalidades como:

- ✅ Cadastro de arquivos
- 📁 Seleção de arquivos e pastas
- ✏️ Modificação de arquivos
- ❌ Exclusão de arquivos e pastas
- ⬇️ Download de arquivos

## 🚀 Funcionalidades

- **Cadastro de Arquivos**: Permite o upload de arquivos para o sistema de armazenamento configurado.
- **Seleção de Arquivos e Pastas**: Interface para navegar e selecionar arquivos ou pastas.
- **Modificação de Arquivos**: Capacidade de editar ou substituir arquivos existentes.
- **Exclusão de Arquivos e Pastas**: Opção para remover arquivos ou diretórios do sistema.
- **Download de Arquivos**: Permite o download de arquivos armazenados.

## ⚙️ Como Instalar

Para rodar o **FilesSystem** localmente, siga os passos abaixo:

1. Clone o repositório:

    ```bash
    git clone https://github.com/Matheus1415/FilesSystem
    ```

2. Acesse o diretório do projeto:

    ```bash
    cd FilesSystem
    ```

3. Instale as dependências do PHP:

    ```bash
    composer install
    ```

4. Instale as dependências do Node.js:

    ```bash
    npm install
    ```

5. Copie o arquivo de ambiente:

    ```bash
    cp .env.example .env
    ```

6. Gere a chave de aplicação:

    ```bash
    php artisan key:generate
    ```

7. Compile os assets da aplicação:

    ```bash
    npm run dev
    ```

8. Inicie o servidor de desenvolvimento do Laravel:

    ```bash
    php artisan serve
    ```

A aplicação estará disponível em `http://localhost:8000`.


## 🛠️ Tecnologias Utilizadas

- [Laravel](https://laravel.com/) – Framework PHP
- [Flysystem](https://flysystem.thephpleague.com/) – Sistema de arquivos para PHP
- [Blade](https://laravel.com/docs/10.x/blade) – Motor de templates do Laravel
- [Tailwind CSS](https://tailwindcss.com/) – Framework CSS utilitário
- [jQuery](https://jquery.com/) – Biblioteca JavaScript para manipulação do DOM
- [Lucide Icons](https://lucide.dev/) – Biblioteca de ícones de código aberto
