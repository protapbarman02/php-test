# Setup procedure

This repository contains a PHP application that was given as a Assesment from KSYTCH that runs inside a Docker container. Follow the instructions below to set up and run the application on your local machine.

## Prerequisites

- [Docker](https://www.docker.com/products/docker)
- [Git](https://git-scm.com/downloads)

## Getting Started

### Case 1: Cloning the Repository

1. Clone the repository to your local machine:

    ```bash
    git clone https://github.com/your-username/your-php-app.git
    cd your-php-app
    ```

2. Build and start the Docker containers:

    ```bash
    docker-compose up --build
    ```

### Case 2: Using the ZIP File

1. Download the ZIP file of the project and extract it to your local machine.

2. Navigate to the project directory:

    ```bash
    cd path/to/extracted-folder
    ```

3. Build and start the Docker containers:

    ```bash
    docker-compose up --build
    ```

## Accessing the API

Once the containers are up and running, you can access the APIs using the following endpoints.

### API Documentation

#### List Recipes

- **URL:** `/recipes`
- **Method:** `GET`
- **Description:** Retrieve a list of recipes.
- **Protected:** No
- **Request:**

    ```http
    GET /recipes HTTP/1.1
    Host: localhost
    ```

- **Response:**

    ```json

    ```

#### Create Recipe

- **URL:** `/recipes`
- **Method:** `POST`
- **Description:** Create a new recipe.
- **Protected:** Yes
- **Request:**

    ```http
    POST /recipes HTTP/1.1
    Host: localhost
    Content-Type: application/json
    ```

- **Response:**

    ```json

    ```

#### Get Recipe

- **URL:** `/recipes/{id}`
- **Method:** `GET`
- **Description:** Retrieve a specific recipe by ID.
- **Protected:** No
- **Request:**

    ```http
    GET /recipes/{id} HTTP/1.1
    Host: localhost
    ```

- **Response:**

    ```json

    ```

#### Update Recipe

- **URL:** `/recipes/{id}`
- **Method:** `PUT` or `PATCH`
- **Description:** Update an existing recipe by ID.
- **Protected:** Yes
- **Request:**

    ```http
    PUT /recipes/{id} HTTP/1.1
    Host: localhost
    Content-Type: application/json
    ```

- **Response:**

    ```json

    ```

#### Delete Recipe

- **URL:** `/recipes/{id}`
- **Method:** `DELETE`
- **Description:** Delete a recipe by ID.
- **Protected:** Yes
- **Request:**

    ```http
    DELETE /recipes/{id} HTTP/1.1
    Host: localhost
    ```

- **Response:**

    ```json

    ```

#### Rate Recipe

- **URL:** `/recipes/{id}/rating`
- **Method:** `POST`
- **Description:** Rate a specific recipe.
- **Protected:** No
- **Request:**

    ```http
    POST /recipes/{id}/rating HTTP/1.1
    Host: localhost
    Content-Type: application/json
    ```

- **Response:**

    ```json
    
    ```
