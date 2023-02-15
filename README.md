# Project`s setup

After cloning the project, open project folder in your terminal and run next command:
```bash
  docker-compose up -d --build
```
Then go to the `authenticationapp-php-1` container, use this command:
```bash
  docker exec -it authenticationapp-php-1 bash
```
To make sure everything works correctly - run the command: 
```bash
  composer install
```
then, create DB from your `.env` configuration running the command:
```bash
  bin/console doctrine:database:create
```
and next migrate your migrations to DB:
```bash
  bin/console doctrine:migrations:migrate
```
Now you need to generate SSL JWT keys:
```bash
  bin/console lexik:jwt:generate-keypair
```

# How to use the Authentication app?
I use Postman Desktop for testing, so I'll explain how it works in this app.
In this case we'll test registration. Go to the Postman. In request field (url field) enter: `http://127.0.0.1:8080/api/register`,
select `Body`->`raw` and select JSON format. In body input put next json:

`{
"email": "example@mail.com",
"password": "11234AAAa!",
"username": "test"
}`

as a result you`ll get success message with OK response.

Now test app's behavior using incorrect json data:

`{
"email": "example",
"password": "11234AAAa!",
"username": "te"
}`

as a result you`ll get exception with BadRequest, with error description.

Now we can test login method. In request field (url field) enter: (POST method) `http://127.0.0.1:8080/api/login-check`
with correct body input:

`{
"email": "example@mail.com",
"password": "11234AAAa!"
}`

as a result we'll get `token` and `refresh token`

if we put incorrect data:

`{
"email": "example@mail.com1",
"password": "11234AAAa!"
}`

we'll get error message: `Invalid credentials` with status code: 401

Now we can test our homepage. In request field `http://127.0.0.1:8080/api/home`
select `Authorization`->`Bearer Token`, and put token (which you got in previous operation) to token input.

# Project equipments and packages
1) For clean and standardized code I've used Easy Code Style with config which you can find in `app/ecs.php`
2) Serializer was used because PHP is OOP, so we should base our work at an objects.
3) Validator is a perfect approach to validate an object data after/during the creating.
4) I`ve used DTO because IMO, it is much more correct to validate and modify data BEFORE creating final object and writing it to DB.


