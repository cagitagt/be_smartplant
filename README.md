# Smart Plant API

Be Smart Plant is a web application built using the Laravel framework. This project aims to provide an intuitive platform for managing and monitoring plant growth efficiently.

## Features

-   User-friendly interface for plant management.
-   Real-time monitoring of plant health and growth.
-   Integration with IoT devices for automated data collection.
-   Comprehensive analytics and reporting.

## Installation

Follow these steps to set up the project on your local machine:

### Prerequisites

-   PHP >= 8.0
-   Composer
-   MySQL or any other supported database
-   Node.js and npm

### Steps

1. **Clone the Repository**:

```bash
git clone https://github.com/cagitagt/be_smartplant.git
cd be_smartplant
```

2. **Install Dependencies**:

```bash
composer install
npm install
```

3. **Set Up Environment Variables**:
   Copy the `.env.example` file to `.env` and configure the database and other environment variables:

```bash
cp .env.example .env
```

4. **Generate Application Key**:

```bash
php artisan key:generate
```

5. **Run Migrations**:

```bash
php artisan migrate
```

6. **Seed the Database (Optional)**:

```bash
php artisan db:seed
```

7. **Build Frontend Assets**:

```bash
npm run dev
```

## Running the Application

1. **Start the Development Server**:

```bash
php artisan serve
```

2. **Access the Application**:
   Open your browser and navigate to `http://localhost:8000/api`.

3. **Run the Scheduler**:

```bash
php artisan schedule:work
```

This command ensures that scheduled tasks defined in your application are executed as expected.

## API Documentation

You can view the API documentation and reference at the following link:

[Smart Plant API Documentation](https://smart-plant.apidocumentation.com/reference)

## Contributing

Contributions are welcome! Please follow the [contribution guide](https://laravel.com/docs/contributions) to get started.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
