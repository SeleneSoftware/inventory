# SeleneInventory

SeleneInventory is as it sounds, an inventory management system.  The design goals for this project target small to medium retail and e-commerce applications with multiple locations for inventory.

## Installation

So far, this installs the same as a basic Symfony application with a MySQL database.  Just make sure change the ENV variables for the database and database credentials.

Once you have the repository cloned, you need to setup the ENV variables.  The easiest way is with a .env.local file, but you can set it in the environment variables as well.
```.env.local
DATABASE_URL="mysql://symfony:symfony@localhost:3306/inven?charset=utf8mb4"
```

Run a composer install to get all the PHP dependencies.

As this is also a TailwindCSS project, but it is installed from symfontcasts wonderful Tailwind Bundle, so you just need to run a Symfony command to run it.  The latest version that we know works with the app is coded into the config of the application.

This uses the Symfony Asset-mapper, so no NPM is required.  Yet.  Just run the asset map compile command to get any frontend dependencies.

```bash
composer install
php bin/console doctrine:migration:migrate
php bin/console tailwind:build
php bin/console asset-map:compile
```

## Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.  
If you would like to help, but not sure where to start, there are several issues and feature requests.  Or make a feature request.

Please make sure to update tests as appropriate.

## License

[MIT](https://choosealicense.com/licenses/mit/)
