
### Предварительные требования

* PHP ^8.2
* Make
* Composer
* Node.js & NPM

### Запуск с разворачиванием в Docker-контейнере

1. Установить зависимости
    ```sh
    make install
    ```
   
2. Подготовить конфигурационный файл
     ```sh
    make prepare-env
    ```

3. Настроить параметры в .env для доступа к базе и отправки почты (если требуется)
    ```dotenv
    DB_PASSWORD=your_password
    DB_USERNAME=your_user
    DB_PASSWORD=your_pass
    ```

4. Настройка прав доступа
    ```sh
    make setup
    ```

5. Запуск контейнеров
    ```sh
    make up
    ```

6. Миграция и заполнение базы
    ```sh
    make mig
    make seed
    ```
