# Deploy to production

* Clone the project
* Run ```make init-prod```
* Perform all actions from the [video](https://www.youtube.com/watch?v=d8NiAbqb6aI)

If you use seeds in which a user with the developer role is located
then you need to change his data

Log in to tinker - php artisan tinker and write your data

```php
$password = 'Your_password';
$user = User::findOrFail(1);
$user->fill([
'password' => Hash::make($password),
'email' => 'your_mail@gmail.com',
])->save();
```
Create a files folder in /storage/app/public - this folder is used by default to save files

Update cred for monitoring [Dozzle](https://dozzle.dev/guide/authentication)

Regenerate creds:
```bash
docker run -it --rm amir20/dozzle generate --name Admin --email me@email.net --password secret admin
```

Or expand using [Ansible](ansible.md)
