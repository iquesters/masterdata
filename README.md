<p align="center">
  <img src="https://avatars.githubusercontent.com/u/7593318?s=200&v=4" alt="Iquesters Logo" width="200"/>
</p>

# Laravel Master Data Package – Iquesters

A reusable **Master Data Management** package for Laravel.  
It provides models, migrations, controllers, routes, and seeders for handling key–value based master data with meta support.

---

## 🚀 Installation

1. Require the package via Composer:

   ```bash
   composer require iquesters/masterdata
   ```

2. Run the migrations to add the master data related tables to your database:

   ```bash
   php artisan migrate
   ```

---

## 🔐 Authentication & Permissions

This package is built to work with **[Spatie Laravel Permission](https://spatie.be/docs/laravel-permission/)** for role and permission management.  
To use it, your Laravel project **must** have authentication and Spatie Role Permissions set up.

- The user must have the role: **`super-admin`**  
- The user must also have the following permissions:

  - `manage-meta`
  - `create-master_data`
  - `edit-master_data`
  - `view-master_data`
  - `delete-master_data`

Without these roles and permissions, access to the Master Data module will be restricted.

---

## 📖 Features

- Key–value based master data handling  
- Meta support for additional attributes  
- Pre-built models, controllers, routes, and seeders  
- Simple integration with any Laravel project  
- Permission-based access control  

---

## 🤝 Contributing

Pull requests are welcome. For major changes, please open an issue first  
to discuss what you would like to change.

---

## 📜 License

[MIT](LICENSE)
