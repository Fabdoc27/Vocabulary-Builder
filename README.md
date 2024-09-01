# Vocabulary Builder Application

A simple PHP-based application to help you build and manage your vocabulary.

## Getting Started

1. **Clone the repository:**

    ```shell
    git clone git@github.com:ashrafulbinharun/Vocabulary-Builder.git
    cd Vocabulary-Builder
    ```

2. **Configure the database:**

    Update `config.php` with your database credentials if necessary.

3. **Import the database:**

    Create a `vocabulary` database and `users` and `words` tables:

    ```sql
    CREATE DATABASE vocabulary;
    USE vocabulary;

    CREATE TABLE users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL
    );

    CREATE TABLE words (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        word VARCHAR(100) NOT NULL,
        meaning TEXT NOT NULL,
        FOREIGN KEY (user_id) REFERENCES users(id)
    );
    ```

4. **Run the project:**

    Start the PHP development server:

    ```shell
    php -S localhost:8080
    ```

Open your browser and navigate to [http://localhost:8080](http://localhost:8080).
