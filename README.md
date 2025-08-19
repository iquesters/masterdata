# Laravel Master Data Package

A reusable **Master Data Management** package for Laravel.
It provides models, migrations, controllers, routes, and seeders for handling key–value based master data with meta support.

---

## 🚀 Installation

1. Clone the `masterdata` folder from Iquesters GitHub.
2. After creating your Laravel project, open the terminal and go to the project directory. Then create a folder for the package:

   ```bash
   mkdir -p packages/iquesters
   ```
3. Paste the previously cloned `masterdata` package into `packages/iquesters/`.
4. Open your project’s `composer.json` and add the following JSON **before** the `require` section:

   ```json
   "repositories": [
       {
           "type": "path",
           "url": "packages/iquesters/masterdata",
           "options": {
               "symlink": true
           }
       }
   ]
   ```
5. Run the command:

   ```bash
   composer require iquesters/masterdata:@dev
   ```
5. Now add masterdata related table to your database, so run the command:

    ```bash
    php artisan migrate
    ```