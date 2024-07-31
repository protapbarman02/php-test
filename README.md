# Setup procedure

This repository contains a PHP application that was given as a Assesment from KSYTCH that runs inside a Docker container. Follow the instructions below to set up and run the application on your local machine.

## Prerequisites

- [Docker](https://www.docker.com/products/docker)
- [Git](https://git-scm.com/downloads)

## Getting Started

### Case 1: Cloning the Repository

1. Clone the repository to your local machine:

    ```bash
    git clone https://github.com/protapbarman02/php-test.git
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

3. Search api is not created separately, rather implemented in the List api along with Pagination for Recipes

4. No Freamework and Package is used. Though composer is set up.

5. Session based Authentication used.

6. Used Postman for Testing and Documentaion with Proper Description and Request-Response Sample.

7. Postman collection is included for Testing.


## API Documentation

    [Postman Api documentation, contains proper descriptions and Request-Response Sample](https://documenter.getpostman.com/view/33100685/2sA3kbexHG)


## Git History :

1. **Updated Documentation**
   - *Author*: protapbarman02
   - *Committed*: 3 minutes ago

2. **Pagination on list recipes**
   - *Author*: protapbarman02
   - *Committed*: 12 hours ago

3. **Authentication, authorization, authenticated routes**
   - *Author*: protapbarman02
   - *Committed*: 13 hours ago

4. **Commits on Jul 29, 2024**
   - **Solved seeding error. Combined rating data with recipe get APIs.**
     - *Author*: protapbarman02
     - *Committed*: 18 hours ago

5. **Code standard update**
   - *Author*: protapbarman02
   - *Committed*: 2 days ago

6. **Rating APIs, search recipe**
   - *Author*: protapbarman02
   - *Committed*: 2 days ago

7. **Commits on Jul 28, 2024**
   - **Create/update/getById/delete**
     - *Author*: protapbarman02
     - *Committed*: 2 days ago

8. **List users and recipe API. Modification in ratings table**
   - *Author*: protapbarman02
   - *Committed*: 2 days ago

9. **Automated tables creation and insertion in user table for authentication**
   - *Author*: protapbarman02
   - *Committed*: 2 days ago

10. **DB-connection**
    - *Author*: protapbarman02
    - *Committed*: 2 days ago

11. **Updated documentation**
    - *Author*: protapbarman02
    - *Committed*: 2 days ago

12. **Initial**
    - *Author*: protapbarman02
    - *Committed*: 2 days ago



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
