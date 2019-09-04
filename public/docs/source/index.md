---
title: API Reference

language_tabs:
- bash
- javascript

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->
# Info

Welcome to the generated API reference.
[Get Postman Collection](http://localhost/docs/collection.json)

<!-- END_INFO -->

#general


<!-- START_0c068b4037fb2e47e71bd44bd36e3e2a -->
## Authorize a client to access the user&#039;s account.

> Example request:

```bash
curl -X GET -G "http://localhost/oauth/authorize" 
```

```javascript
const url = new URL("http://localhost/oauth/authorize");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET oauth/authorize`


<!-- END_0c068b4037fb2e47e71bd44bd36e3e2a -->

<!-- START_e48cc6a0b45dd21b7076ab2c03908687 -->
## Approve the authorization request.

> Example request:

```bash
curl -X POST "http://localhost/oauth/authorize" 
```

```javascript
const url = new URL("http://localhost/oauth/authorize");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST oauth/authorize`


<!-- END_e48cc6a0b45dd21b7076ab2c03908687 -->

<!-- START_de5d7581ef1275fce2a229b6b6eaad9c -->
## Deny the authorization request.

> Example request:

```bash
curl -X DELETE "http://localhost/oauth/authorize" 
```

```javascript
const url = new URL("http://localhost/oauth/authorize");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE oauth/authorize`


<!-- END_de5d7581ef1275fce2a229b6b6eaad9c -->

<!-- START_a09d20357336aa979ecd8e3972ac9168 -->
## Authorize a client to access the user&#039;s account.

> Example request:

```bash
curl -X POST "http://localhost/oauth/token" 
```

```javascript
const url = new URL("http://localhost/oauth/token");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST oauth/token`


<!-- END_a09d20357336aa979ecd8e3972ac9168 -->

<!-- START_d6a56149547e03307199e39e03e12d1c -->
## Get all of the authorized tokens for the authenticated user.

> Example request:

```bash
curl -X GET -G "http://localhost/oauth/tokens" 
```

```javascript
const url = new URL("http://localhost/oauth/tokens");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET oauth/tokens`


<!-- END_d6a56149547e03307199e39e03e12d1c -->

<!-- START_a9a802c25737cca5324125e5f60b72a5 -->
## Delete the given token.

> Example request:

```bash
curl -X DELETE "http://localhost/oauth/tokens/1" 
```

```javascript
const url = new URL("http://localhost/oauth/tokens/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE oauth/tokens/{token_id}`


<!-- END_a9a802c25737cca5324125e5f60b72a5 -->

<!-- START_abe905e69f5d002aa7d26f433676d623 -->
## Get a fresh transient token cookie for the authenticated user.

> Example request:

```bash
curl -X POST "http://localhost/oauth/token/refresh" 
```

```javascript
const url = new URL("http://localhost/oauth/token/refresh");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST oauth/token/refresh`


<!-- END_abe905e69f5d002aa7d26f433676d623 -->

<!-- START_babcfe12d87b8708f5985e9d39ba8f2c -->
## Get all of the clients for the authenticated user.

> Example request:

```bash
curl -X GET -G "http://localhost/oauth/clients" 
```

```javascript
const url = new URL("http://localhost/oauth/clients");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET oauth/clients`


<!-- END_babcfe12d87b8708f5985e9d39ba8f2c -->

<!-- START_9eabf8d6e4ab449c24c503fcb42fba82 -->
## Store a new client.

> Example request:

```bash
curl -X POST "http://localhost/oauth/clients" 
```

```javascript
const url = new URL("http://localhost/oauth/clients");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST oauth/clients`


<!-- END_9eabf8d6e4ab449c24c503fcb42fba82 -->

<!-- START_784aec390a455073fc7464335c1defa1 -->
## Update the given client.

> Example request:

```bash
curl -X PUT "http://localhost/oauth/clients/1" 
```

```javascript
const url = new URL("http://localhost/oauth/clients/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT oauth/clients/{client_id}`


<!-- END_784aec390a455073fc7464335c1defa1 -->

<!-- START_1f65a511dd86ba0541d7ba13ca57e364 -->
## Delete the given client.

> Example request:

```bash
curl -X DELETE "http://localhost/oauth/clients/1" 
```

```javascript
const url = new URL("http://localhost/oauth/clients/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE oauth/clients/{client_id}`


<!-- END_1f65a511dd86ba0541d7ba13ca57e364 -->

<!-- START_9e281bd3a1eb1d9eb63190c8effb607c -->
## Get all of the available scopes for the application.

> Example request:

```bash
curl -X GET -G "http://localhost/oauth/scopes" 
```

```javascript
const url = new URL("http://localhost/oauth/scopes");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET oauth/scopes`


<!-- END_9e281bd3a1eb1d9eb63190c8effb607c -->

<!-- START_9b2a7699ce6214a79e0fd8107f8b1c9e -->
## Get all of the personal access tokens for the authenticated user.

> Example request:

```bash
curl -X GET -G "http://localhost/oauth/personal-access-tokens" 
```

```javascript
const url = new URL("http://localhost/oauth/personal-access-tokens");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET oauth/personal-access-tokens`


<!-- END_9b2a7699ce6214a79e0fd8107f8b1c9e -->

<!-- START_a8dd9c0a5583742e671711f9bb3ee406 -->
## Create a new personal access token for the user.

> Example request:

```bash
curl -X POST "http://localhost/oauth/personal-access-tokens" 
```

```javascript
const url = new URL("http://localhost/oauth/personal-access-tokens");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST oauth/personal-access-tokens`


<!-- END_a8dd9c0a5583742e671711f9bb3ee406 -->

<!-- START_bae65df80fd9d72a01439241a9ea20d0 -->
## Delete the given token.

> Example request:

```bash
curl -X DELETE "http://localhost/oauth/personal-access-tokens/1" 
```

```javascript
const url = new URL("http://localhost/oauth/personal-access-tokens/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE oauth/personal-access-tokens/{token_id}`


<!-- END_bae65df80fd9d72a01439241a9ea20d0 -->

<!-- START_be144776226f630c3f444c294d8a0395 -->
## api/ping
> Example request:

```bash
curl -X GET -G "http://localhost/api/ping" 
```

```javascript
const url = new URL("http://localhost/api/ping");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "message": "pong"
}
```

### HTTP Request
`GET api/ping`


<!-- END_be144776226f630c3f444c294d8a0395 -->

<!-- START_f0654d3f2fc63c11f5723f233cc53c83 -->
## Store a newly created user in storage.

> Example request:

```bash
curl -X POST "http://localhost/api/user" 
```

```javascript
const url = new URL("http://localhost/api/user");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/user`


<!-- END_f0654d3f2fc63c11f5723f233cc53c83 -->

<!-- START_ebdde946750e85f481c20691132d68d6 -->
## Store a newly created user in storage.

> Example request:

```bash
curl -X POST "http://localhost/api/user/member" 
```

```javascript
const url = new URL("http://localhost/api/user/member");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/user/member`


<!-- END_ebdde946750e85f481c20691132d68d6 -->

<!-- START_2b6e5a4b188cb183c7e59558cce36cb6 -->
## Display a listing of the users.

> Example request:

```bash
curl -X GET -G "http://localhost/api/user" 
```

```javascript
const url = new URL("http://localhost/api/user");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/user`


<!-- END_2b6e5a4b188cb183c7e59558cce36cb6 -->

<!-- START_1187e1a438e4009335df7a7c5a6050f6 -->
## Display the specified user by auth token.

> Example request:

```bash
curl -X GET -G "http://localhost/api/user/self" 
```

```javascript
const url = new URL("http://localhost/api/user/self");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/user/self`


<!-- END_1187e1a438e4009335df7a7c5a6050f6 -->

<!-- START_70df7a96931e7e5dad58e44039fb04ff -->
## Display a listing of the users.

> Example request:

```bash
curl -X GET -G "http://localhost/api/user/self/permissions" 
```

```javascript
const url = new URL("http://localhost/api/user/self/permissions");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/user/self/permissions`


<!-- END_70df7a96931e7e5dad58e44039fb04ff -->

<!-- START_03a16f7129590d539099cbf5acd95b1d -->
## Update the specified user in storage.

> Example request:

```bash
curl -X POST "http://localhost/api/user/role/1" 
```

```javascript
const url = new URL("http://localhost/api/user/role/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/user/role/{user}`


<!-- END_03a16f7129590d539099cbf5acd95b1d -->

<!-- START_ceec0e0b1d13d731ad96603d26bccc2f -->
## Display the specified user.

> Example request:

```bash
curl -X GET -G "http://localhost/api/user/1" 
```

```javascript
const url = new URL("http://localhost/api/user/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/user/{user}`


<!-- END_ceec0e0b1d13d731ad96603d26bccc2f -->

<!-- START_e75f2f63a5a2351c4f4d83bc65cefcf8 -->
## Update the specified user in storage.

> Example request:

```bash
curl -X PATCH "http://localhost/api/user" 
```

```javascript
const url = new URL("http://localhost/api/user");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "PATCH",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PATCH api/user`


<!-- END_e75f2f63a5a2351c4f4d83bc65cefcf8 -->

<!-- START_43e8ba205ffd3cbca826e9ab0a6f5af1 -->
## Remove the specified user from storage.

> Example request:

```bash
curl -X DELETE "http://localhost/api/user" 
```

```javascript
const url = new URL("http://localhost/api/user");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE api/user`


<!-- END_43e8ba205ffd3cbca826e9ab0a6f5af1 -->

<!-- START_8564dc3bb676bcd45e6a90fb8e1ce0e6 -->
## Display the specified gallery.

> Example request:

```bash
curl -X GET -G "http://localhost/api/gallery" 
```

```javascript
const url = new URL("http://localhost/api/gallery");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/gallery`


<!-- END_8564dc3bb676bcd45e6a90fb8e1ce0e6 -->

<!-- START_32483809d5af0f4ae088a82a2cc0a3d1 -->
## Update the specified gallery in storage.

> Example request:

```bash
curl -X PATCH "http://localhost/api/gallery" 
```

```javascript
const url = new URL("http://localhost/api/gallery");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "PATCH",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PATCH api/gallery`


<!-- END_32483809d5af0f4ae088a82a2cc0a3d1 -->

<!-- START_1007fbfa6fefe87af5890126e654d537 -->
## Remove the specified gallery from storage.

> Example request:

```bash
curl -X DELETE "http://localhost/api/gallery" 
```

```javascript
const url = new URL("http://localhost/api/gallery");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE api/gallery`


<!-- END_1007fbfa6fefe87af5890126e654d537 -->

<!-- START_926a9c75704d42dfa09ee30fa4ecc012 -->
## Store a newly created user in storage.

> Example request:

```bash
curl -X POST "http://localhost/api/artist" 
```

```javascript
const url = new URL("http://localhost/api/artist");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/artist`


<!-- END_926a9c75704d42dfa09ee30fa4ecc012 -->

<!-- START_91d8c6ab8a2e4490748fab50bafc02b6 -->
## Display a listing of the users.

> Example request:

```bash
curl -X GET -G "http://localhost/api/artist" 
```

```javascript
const url = new URL("http://localhost/api/artist");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/artist`


<!-- END_91d8c6ab8a2e4490748fab50bafc02b6 -->

<!-- START_744deecffbee5147e1911092f23f3d24 -->
## Display the specified user.

> Example request:

```bash
curl -X GET -G "http://localhost/api/artist/1" 
```

```javascript
const url = new URL("http://localhost/api/artist/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/artist/{artist}`


<!-- END_744deecffbee5147e1911092f23f3d24 -->

<!-- START_8a61fc80a9563b2c57c49e0788812bbb -->
## Update the specified user in storage.

> Example request:

```bash
curl -X PATCH "http://localhost/api/artist/1" 
```

```javascript
const url = new URL("http://localhost/api/artist/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "PATCH",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PATCH api/artist/{artist}`


<!-- END_8a61fc80a9563b2c57c49e0788812bbb -->

<!-- START_87acac5169d4fb6fcc93fed3b9763adc -->
## Remove the specified user from storage.

> Example request:

```bash
curl -X DELETE "http://localhost/api/artist/1" 
```

```javascript
const url = new URL("http://localhost/api/artist/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE api/artist/{artist}`


<!-- END_87acac5169d4fb6fcc93fed3b9763adc -->

<!-- START_db113b5d97752f1fd361aab679155796 -->
## Store a newly created customer in storage.

> Example request:

```bash
curl -X POST "http://localhost/api/customer" 
```

```javascript
const url = new URL("http://localhost/api/customer");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/customer`


<!-- END_db113b5d97752f1fd361aab679155796 -->

<!-- START_557e9e3130c6c860f72e537486feeff0 -->
## Display a listing of the customers.

> Example request:

```bash
curl -X GET -G "http://localhost/api/customer" 
```

```javascript
const url = new URL("http://localhost/api/customer");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/customer`


<!-- END_557e9e3130c6c860f72e537486feeff0 -->

<!-- START_15d4b17958c5fedae33e98f37b6c9456 -->
## Display the specified user.

> Example request:

```bash
curl -X GET -G "http://localhost/api/customer/1" 
```

```javascript
const url = new URL("http://localhost/api/customer/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/customer/{customer}`


<!-- END_15d4b17958c5fedae33e98f37b6c9456 -->

<!-- START_bef36af19a19b69319b1e6a98f349bfe -->
## Update the specified customer in storage.

> Example request:

```bash
curl -X PATCH "http://localhost/api/customer/1" 
```

```javascript
const url = new URL("http://localhost/api/customer/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "PATCH",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PATCH api/customer/{customer}`


<!-- END_bef36af19a19b69319b1e6a98f349bfe -->

<!-- START_3cbd86245dc8d01d781b200322e14482 -->
## Remove the specified customer from storage.

> Example request:

```bash
curl -X DELETE "http://localhost/api/customer/1" 
```

```javascript
const url = new URL("http://localhost/api/customer/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE api/customer/{customer}`


<!-- END_3cbd86245dc8d01d781b200322e14482 -->

<!-- START_cd95d3e90339c282e0b608349e80a381 -->
## api/order
> Example request:

```bash
curl -X POST "http://localhost/api/order" 
```

```javascript
const url = new URL("http://localhost/api/order");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/order`


<!-- END_cd95d3e90339c282e0b608349e80a381 -->

<!-- START_d2e080af51835880674d3e2496ed6e62 -->
## api/order
> Example request:

```bash
curl -X GET -G "http://localhost/api/order" 
```

```javascript
const url = new URL("http://localhost/api/order");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/order`


<!-- END_d2e080af51835880674d3e2496ed6e62 -->

<!-- START_9c4ec790d3f07a332b085b8efc187b58 -->
## api/order/{order}
> Example request:

```bash
curl -X GET -G "http://localhost/api/order/1" 
```

```javascript
const url = new URL("http://localhost/api/order/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/order/{order}`


<!-- END_9c4ec790d3f07a332b085b8efc187b58 -->

<!-- START_13abedc865b3acba6db70061a19ecb09 -->
## api/order/{order}
> Example request:

```bash
curl -X DELETE "http://localhost/api/order/1" 
```

```javascript
const url = new URL("http://localhost/api/order/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE api/order/{order}`


<!-- END_13abedc865b3acba6db70061a19ecb09 -->

<!-- START_6e9d803d951e487ca391060404593aab -->
## Store a newly created resource in storage.

> Example request:

```bash
curl -X POST "http://localhost/api/artwork" 
```

```javascript
const url = new URL("http://localhost/api/artwork");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/artwork`


<!-- END_6e9d803d951e487ca391060404593aab -->

<!-- START_242e8605577db7d981471d9968ead741 -->
## Display a listing of the resource.

> Example request:

```bash
curl -X GET -G "http://localhost/api/artwork" 
```

```javascript
const url = new URL("http://localhost/api/artwork");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/artwork`


<!-- END_242e8605577db7d981471d9968ead741 -->

<!-- START_2b9615fc97d2a1b5dedacb214243efb5 -->
## Display the specified resource.

> Example request:

```bash
curl -X GET -G "http://localhost/api/artwork/1" 
```

```javascript
const url = new URL("http://localhost/api/artwork/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/artwork/{artwork}`


<!-- END_2b9615fc97d2a1b5dedacb214243efb5 -->

<!-- START_ce1bdce463dc1dcef41695718f8aa596 -->
## Update the specified resource in storage.

> Example request:

```bash
curl -X PATCH "http://localhost/api/artwork/1" 
```

```javascript
const url = new URL("http://localhost/api/artwork/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "PATCH",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PATCH api/artwork/{artwork}`


<!-- END_ce1bdce463dc1dcef41695718f8aa596 -->

<!-- START_9c0bde2c7a869c05c2279d404d01eb20 -->
## Remove the specified resource from storage.

> Example request:

```bash
curl -X DELETE "http://localhost/api/artwork/1" 
```

```javascript
const url = new URL("http://localhost/api/artwork/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE api/artwork/{artwork}`


<!-- END_9c0bde2c7a869c05c2279d404d01eb20 -->

<!-- START_9acbc0437496eb2c9d2231fd9bb453be -->
## Store an image in storage.

> Example request:

```bash
curl -X POST "http://localhost/api/artwork/1/image" 
```

```javascript
const url = new URL("http://localhost/api/artwork/1/image");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/artwork/{artwork}/image`


<!-- END_9acbc0437496eb2c9d2231fd9bb453be -->

<!-- START_707d422388c76ee48af3ce53ce33718c -->
## Store a compressed image in storage.

> Example request:

```bash
curl -X POST "http://localhost/api/artwork/1/cimage" 
```

```javascript
const url = new URL("http://localhost/api/artwork/1/cimage");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/artwork/{artwork}/cimage`


<!-- END_707d422388c76ee48af3ce53ce33718c -->

<!-- START_3254c90bcf423b1f78d4b5f94a6fd80f -->
## api/artwork/{artwork}/image/{media}
> Example request:

```bash
curl -X DELETE "http://localhost/api/artwork/1/image/1" 
```

```javascript
const url = new URL("http://localhost/api/artwork/1/image/1");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE api/artwork/{artwork}/image/{media}`


<!-- END_3254c90bcf423b1f78d4b5f94a6fd80f -->

<!-- START_8e9e2f7b6568d14b197402543cdaa874 -->
## Create token password reset

> Example request:

```bash
curl -X POST "http://localhost/api/password/create" 
```

```javascript
const url = new URL("http://localhost/api/password/create");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/password/create`


<!-- END_8e9e2f7b6568d14b197402543cdaa874 -->

<!-- START_c5a2ae4a8a8cbeb1fa7c1b2e52ded22a -->
## api/stat
> Example request:

```bash
curl -X GET -G "http://localhost/api/stat" 
```

```javascript
const url = new URL("http://localhost/api/stat");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/stat`


<!-- END_c5a2ae4a8a8cbeb1fa7c1b2e52ded22a -->


