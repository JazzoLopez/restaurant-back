# Restaurant Backend – Slim PHP
This is the backend system for a restaurant application developed using the Slim PHP microframework. It provides core API functionality such as user authentication, token handling, and reservation management.

#  Features
- User authentication with JWT (JSON Web Tokens)

- Token generation using the client's IP address

- Protected routes using middleware

## Reservation management

- Follows the MVC pattern, excluding the view layer

- Designed to be consumed by web and mobile applications via a REST API

## Requirements
- PHP 8.0 or higher

- Composer

- Web server or PHP built-in server

## Installation

Clone the repository:
  ```bash
git clone https://github.com/JazzoLopez/restaurant-back.git
cd restaurant-backend
  ```

Install dependencies using Composer:
  ```bash
composer install
  ```

Configure environment variables if needed (for example, using a .env file)

Run the project using PHP's built-in server:
  ```bash
php -S localhost:3000 -t public
  ```
Access the API at:
http://localhost:3000
--
## License
This project is licensed under the MIT License. See the LICENSE file for details.

