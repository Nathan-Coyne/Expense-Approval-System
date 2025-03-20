Run the migration
php artisan migrate
Then run the seeders
php artisan db:seed --class=StatusSeeder
php artisan db:seed --class=CategorySeeder
php artisan db:seed --class=ExpensePermissionSeeder

The last one will create you two users;
test@example.com,test_admin@example.com
They both use the same password its password
