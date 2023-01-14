## Usage
### How to login

post request on `/user_login.php` with the following data : 
```
user=username
password=password
```

a token will be return 

```json
{
  "token": "<api-token>"
}
```

### How to request api

Send a request on an endpoint with the `Authorization` header, with the previously generated token