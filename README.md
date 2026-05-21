<p align="center">
  <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9a/Laravel.svg/1200px-Laravel.svg.png" width="80" alt="Laravel Logo">
</p>

<h1 align="center">FlashQuest ⚡</h1>

<p align="center">
  <strong>Sistema de Repetição Espaçada Gamificado de Alta Performance</strong>
</p>

<p align="center">
  <a href="#-sobre-o-projeto">Sobre</a> •
  <a href="#-funcionalidades">Funcionalidades</a> •
  <a href="#-tecnologias">Tecnologias</a> •
  <a href="#-instalação">Instalação</a>
</p>

---

## 📖 Sobre o Projeto

**FlashQuest** é uma plataforma moderna de estudos baseada em *Flashcards* (Cartões de Memória). Inspirado no poder de retenção do Anki, o sistema utiliza o consagrado **algoritmo SM-2** para calcular a curva de esquecimento do seu cérebro, entregando revisões no exato momento em que você está prestes a esquecer uma informação.

Mas fomos além: o estudo não precisa ser monótono. O FlashQuest integra um ecossistema completo de **Gamificação**, transformando suas sessões de estudo em missões operacionais onde você ganha XP, sobe de Nível, mantém Ofensivas Diárias (Streaks) e desbloqueia Conquistas.

---

## ✨ Funcionalidades

- 🧠 **Algoritmo de Repetição Espaçada (SM-2):** O algoritmo calibra automaticamente o intervalo de dias de cada carta baseado na sua dificuldade percebida (Errei, Difícil, Bom, Fácil).
- 🎮 **Gamificação Integrada:** 
  - Ganhe **XP** a cada cartão respondido corretamente.
  - Suba de **Nível** e acompanhe seu progresso na barra de evolução.
  - Mantenha **Streaks (Dias de Ofensiva)** ativos ao estudar todos os dias.
  - Desbloqueie **Conquistas/Méritos** automáticos (ex: "Criou 10 Decks", "Ofensiva de 30 Dias").
- 📊 **Estatísticas Avançadas (Anki-Like):** Gráficos modernos gerados via ApexCharts que mostram:
  - Previsão de Revisões (Forecast) dos próximos 30 dias.
  - Distribuição das avaliações (Errei vs Bom vs Fácil).
  - Estado atual das suas cartas (Noviças, Aprendendo e Maduras).
- 🎨 **Interface Premium:** Design limpo, focado e totalmente em *Dark Mode*, garantindo conforto visual para longas jornadas de estudo.
- 📂 **Organização por Decks:** Crie seus próprios baralhos, adicione as cartas e decida se quer mantê-los privados ou públicos no seu Perfil.

---

## 🛠️ Tecnologias

A aplicação foi construída visando velocidade, segurança e código limpo, utilizando o que há de melhor no ecossistema PHP moderno:

- **Back-end:** Laravel 11.x (PHP 8.2+)
- **Front-end:** Blade Templates + Tailwind CSS
- **Interatividade:** jQuery e requisições AJAX assíncronas para flip cards ultra-rápidos.
- **Gráficos:** ApexCharts
- **Banco de Dados:** SQLite (Fácil configuração, pronto para migração para MySQL/PostgreSQL).

---

## 🚀 Instalação

Siga os passos abaixo para rodar o projeto localmente na sua máquina:

### 1. Pré-requisitos
- PHP >= 8.2
- Composer
- Node.js e NPM

### 2. Clonando o Repositório
```bash
git clone https://github.com/Skowronski-33/Anki-2.0.git
cd flashquest
```

### 3. Instalando as Dependências
Instale as dependências do Back-end (PHP) e do Front-end (Assets):
```bash
composer install
npm install
```

### 4. Configurando o Ambiente (.env)
Copie o arquivo de exemplo e gere a chave única de segurança da aplicação:
```bash
cp .env.example .env
php artisan key:generate
```

### 5. Configurando o Banco de Dados
O sistema está pré-configurado para usar SQLite de forma nativa. Basta rodar as migrações:
```bash
php artisan migrate
```

*(Opcional: Se desejar testar a Gamificação com conquistas pré-prontas, você pode criar uma Database Seeder de Conquistas se já estiver disponível).*

### 6. Compilando os Assets
```bash
npm run build
# ou para manter assistindo a mudanças durante o desenvolvimento:
# npm run dev
```

### 7. Iniciando o Servidor
```bash
php artisan serve
```

Acesse no seu navegador: `http://localhost:8000`

---

> **Desenvolvido com foco e disciplina para estudantes de alta performance.** 🚀
