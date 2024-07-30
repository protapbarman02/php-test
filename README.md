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
    cd php-test
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


## Notes :

1. Database tables are auto created upon docker build

2. 2 users with different roles are auto inserted into users table upon docker build
to implement authentication and authorization

3. Search api is not created separately, rather implemented in the List api along with      Pagination for Recipes

4. No Freamework and Package is used. Though composer is set up.

5. Session based Authentication used.

6. Used Postman for Testing and Documentaion with Proper Description and Request-Response Sample.

7. Postman collection is included for Testing.


## API Documentation

    [Postman Api documentation, contains proper descriptions and Request-Response Sample](https://documenter.getpostman.com/view/33100685/2sA3kbexHG)


## Git History :



## Complettion of your Aspects (In your words):

- You **MUST** use packages, but you **MUST NOT** use a web-app framework or microframework. That is, you can use [symfony/dependency-injection](https://packagist.org/packages/symfony/dependency-injection) but not [symfony/symfony](https://packagist.org/packages/symfony/symfony).
- Your application **MUST** run within the containers. Please provide short setup instructions.
- The API **MUST** return valid JSON and **MUST** follow the endpoints set out above.
- You **SHOULD** pay attention to best security practices.
- You **SHOULD** follow SOLID principles where appropriate.
- You do **NOT** have to build a UI for this API.
- You **MUST** write testable code

## Incompletion of your Aspects (In your words):

- demonstrate unit testing it (for clarity,  PHPUnit is not considered a framework as per the first point above. We encourage you to use PHPUnit or any other kind of **testing** framework).


## Completion of Bonus Points (In your words):

- Setup with a one liner or a script
- Content negotiation
- Pagination
- Following the industry standard style guide for the language you choose to use - `PSR-2` etc.
- A git history (even if brief) with clear, concise commit messages.

## Incompletion of Bonus Points (In your words):

- Using any kind of Database Access Abstraction
- Other types of testing - e.g. integration tests




## What I did not do :

1. Testing 