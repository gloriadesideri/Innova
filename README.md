# Innova run

1. Create a db connection and a database 
2. Edit the env file with your database informations
3. Setup a mailtrap account and edit the env file with your mailtrap informations
4. Install dependencies

    ```php
    composer install
    npm install
    npm run dev
    ```

5. Run migrations 

    ```php
    php artisa migrate:fresh
    ```

6. Setup an algolia account and create a new project
7. Setup algolia in your project

    ```php
    php artisan vendor:publish --provider="Laravel\Scout\ScoutServiceProvider"
    ```

8. in your env file set

    ```php
    SCOUT_QUEUE = true
    ALGOLIA_APP_ID = Enter your Application ID
    ALGOLIA_SECRET = Enter your Admin API Key

    //make sure to copy your admin app id in algolia
    ```

9. Import the serachables

    ```php
    php artisan scout:import "App\Thread"
    ```

10. go to your algolia project and set the serchable fields just to title and body in the settings of the threads index
11. Register reacter

    ```php
    php artisan love:register-reacters --model="App\User"
    ```

12. Register reactions

    ```php
    php artisan love:reaction-type-add --default
    ```

13. Register reactants

    ```php
    php artisan love:register-reactants --model="App\Comment"
    php artisan love:register-reactants --model="App\Post"
    php artisan love:register-reactants --model="App\Reply"
    ```

14. Run seeder to create a super admin and base channel 

    ```php
    php artisan db:seed
    ```

15. link your storage

    ```php
    php artisan storage:link
    ```

You're good to go. Innova is in your hands: create channels and sections for users to enjoy and make the admins if they want.

## further improovements
1. Add markdown support for threads
2. better ui


**Admin base credentials:**

- name:root
- last name:admin
- email:admin@innova.com
- password:toor

**Online as**
Login with admin credentials
https://innova-social.herokuapp.com/
