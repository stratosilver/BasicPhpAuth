# BasicPhpAccounts
Framework agnostic basic php class to manage users accounts, register, login, update etc...  

Here is the table structure

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

##Usage
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
###Get users list
```
$user->getList(0,0, 'name', 'ASC');
print_r($user->list);
```