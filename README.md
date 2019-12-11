# BasicPhpAccounts
Framework agnostic basic php class to manage users accounts, register, login, update, password encryption  etc...  
###Security
password_hash() and password_verify() function are used to encrypt and check the user password.
##Table structure

```
CREATE TABLE users
  id_user int(11) NOT NULL,
  firstname varchar(100) NOT NULL,
  lastname varchar(100) NOT NULL,
  email varchar(255) NOT NULL,
  password varchar(255) NOT NULL,
  create_time timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  update_time timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```
See table.sql for the complete structure including indexes

##Usage
###Instantiate the class 
You must pass a PDO connection as a parameter when you instantiate the class
```
$user = new ModelUsers($pdoLink);
```

###Check login/password 
```
$user = new ModelUsers($pdoLink);

if($user->login('login', 'password')){
    echo 'Login and password correct';
    print_r($user->profile);
}
else{
    echo 'Wrong login or password';
}
```
###Get infos about a user
   ```
   $user->get(5);
   print_r($user->profile);
   ```
###Get infos about a user by his e-mail
```
$user->getByMail('hello@kidnoize.be');
print_r($user->profile);
```

###Get users list
```
$user->getList(0,0, 'name', 'ASC');
print_r($user->list);
```

###Add a user
```
$user->profile['firstname'] = 'Kid';
$user->profile['lastname'] = 'Noize';
$user->profile['email'] = 'hello@kidnoize.be';
$user->profile['password'] = 'houbahouba';

$user->add();
```

###Update a user
```
$user->profile['firstname'] = 'Kid';
$user->profile['lastname'] = 'Noize';
$user->profile['email'] = 'hello@kidnoize.be';
$user->profile['id'] = 5;

$user->update();
```

###Update password
```
$user->profile['password'] = 'houbahoubazitoko';
$user->profile['id'] = 5;

$user->updatePassword();
```

###Delete a user
```
$user->del(5);
```
