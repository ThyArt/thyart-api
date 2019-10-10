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

#Artists


<!-- START_926a9c75704d42dfa09ee30fa4ecc012 -->
## Store a newly created user in storage.

> Example request:

```bash
curl -X POST "http://localhost/api/artist" \
    -H "Content-Type: application/json" \
    -d '{"first_name":"dolor","last_name":"et","email":"illum","phone":"nisi","address":"vel","city":"rerum","country":"incidunt"}'

```

```javascript
const url = new URL("http://localhost/api/artist");

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "first_name": "dolor",
    "last_name": "et",
    "email": "illum",
    "phone": "nisi",
    "address": "vel",
    "city": "rerum",
    "country": "incidunt"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/artist`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    first_name | string |  optional  | the artist's first name
    last_name | string |  optional  | the artist's last name
    email | string |  optional  | the artist's email
    phone | string |  optional  | the artist's phone number
    address | string |  optional  | the artist's address
    city | string |  optional  | the artist's city of residence
    country | string |  optional  | the artist's country of residence

<!-- END_926a9c75704d42dfa09ee30fa4ecc012 -->

<!-- START_91d8c6ab8a2e4490748fab50bafc02b6 -->
## Display a listing of the users.

> Example request:

```bash
curl -X GET -G "http://localhost/api/artist" \
    -H "Content-Type: application/json" \
    -d '{"first_name":"ipsum","last_name":"et","email":"culpa","phone":"quos","address":"et","city":"eum","country":"doloribus","per_page":7}'

```

```javascript
const url = new URL("http://localhost/api/artist");

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "first_name": "ipsum",
    "last_name": "et",
    "email": "culpa",
    "phone": "quos",
    "address": "et",
    "city": "eum",
    "country": "doloribus",
    "per_page": 7
}

fetch(url, {
    method: "GET",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (500):

```json
{
    "message": "Server Error"
}
```

### HTTP Request
`GET api/artist`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    first_name | string |  optional  | the artist's first name
    last_name | string |  optional  | the artist's last name
    email | string |  optional  | the artist's email
    phone | string |  optional  | the artist's phone number
    address | string |  optional  | the artist's address
    city | string |  optional  | the artist's city of residence
    country | string |  optional  | the artist's country of residence
    per_page | integer |  optional  | the number of artists to be displayed per page

<!-- END_91d8c6ab8a2e4490748fab50bafc02b6 -->

<!-- START_8a61fc80a9563b2c57c49e0788812bbb -->
## Update the specified user in storage.

> Example request:

```bash
curl -X PATCH "http://localhost/api/artist/1?artist=consequatur" \
    -H "Content-Type: application/json" \
    -d '{"first_name":"quia","last_name":"aspernatur","email":"sequi","phone":"ut","address":"distinctio","city":"assumenda","country":"quibusdam","per_page":17}'

```

```javascript
const url = new URL("http://localhost/api/artist/1");

    let params = {
            "artist": "consequatur",
        };
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "first_name": "quia",
    "last_name": "aspernatur",
    "email": "sequi",
    "phone": "ut",
    "address": "distinctio",
    "city": "assumenda",
    "country": "quibusdam",
    "per_page": 17
}

fetch(url, {
    method: "PATCH",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PATCH api/artist/{artist}`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    first_name | string |  optional  | the artist's first name
    last_name | string |  optional  | the artist's last name
    email | string |  optional  | the artist's email
    phone | string |  optional  | the artist's phone number
    address | string |  optional  | the artist's address
    city | string |  optional  | the artist's city of residence
    country | string |  optional  | the artist's country of residence
    per_page | integer |  optional  | the number of artists to be displayed per page
#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    artist |  optional  | Artist the artist to be modified

<!-- END_8a61fc80a9563b2c57c49e0788812bbb -->

<!-- START_87acac5169d4fb6fcc93fed3b9763adc -->
## Remove the specified user from storage.

> Example request:

```bash
curl -X DELETE "http://localhost/api/artist/1?artist=maxime" 
```

```javascript
const url = new URL("http://localhost/api/artist/1");

    let params = {
            "artist": "maxime",
        };
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

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

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    artist |  optional  | Artist the artist to be deleted

<!-- END_87acac5169d4fb6fcc93fed3b9763adc -->

#Artworks


<!-- START_6e9d803d951e487ca391060404593aab -->
## Store a newly created resource in storage.

> Example request:

```bash
curl -X POST "http://localhost/api/artwork" \
    -H "Content-Type: application/json" \
    -d '{"name":"porro","price":2,"state":"ducimus"}'

```

```javascript
const url = new URL("http://localhost/api/artwork");

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "name": "porro",
    "price": 2,
    "state": "ducimus"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/artwork`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    name | string |  optional  | the name of the artwork
    price | integer |  optional  | the price of the artwork
    state | string |  optional  | the current state of the artwork

<!-- END_6e9d803d951e487ca391060404593aab -->

<!-- START_242e8605577db7d981471d9968ead741 -->
## Display a listing of the resource.

> Example request:

```bash
curl -X GET -G "http://localhost/api/artwork" \
    -H "Content-Type: application/json" \
    -d '{"price_min":8,"price_max":17,"state":"quaerat","ref":"unde","per_page":7}'

```

```javascript
const url = new URL("http://localhost/api/artwork");

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "price_min": 8,
    "price_max": 17,
    "state": "quaerat",
    "ref": "unde",
    "per_page": 7
}

fetch(url, {
    method: "GET",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (500):

```json
{
    "message": "Server Error"
}
```

### HTTP Request
`GET api/artwork`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    price_min | integer |  optional  | minimum price range
    price_max | integer |  optional  | maximum price range
    state | string |  optional  | the artwork's current state
    ref | string |  optional  | the artwork reference value
    per_page | integer |  optional  | the number of desired artworks per page

<!-- END_242e8605577db7d981471d9968ead741 -->

<!-- START_2b9615fc97d2a1b5dedacb214243efb5 -->
## Display the specified resource.

> Example request:

```bash
curl -X GET -G "http://localhost/api/artwork/1?artwork=eaque" 
```

```javascript
const url = new URL("http://localhost/api/artwork/1");

    let params = {
            "artwork": "eaque",
        };
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

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


> Example response (500):

```json
{
    "message": "Server Error"
}
```

### HTTP Request
`GET api/artwork/{artwork}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    artwork |  optional  | ArtworkResource the artwork to show

<!-- END_2b9615fc97d2a1b5dedacb214243efb5 -->

<!-- START_ce1bdce463dc1dcef41695718f8aa596 -->
## Update the specified resource in storage.

> Example request:

```bash
curl -X PATCH "http://localhost/api/artwork/1?artwork=dolore" \
    -H "Content-Type: application/json" \
    -d '{"name":"at","price":5,"state":"qui"}'

```

```javascript
const url = new URL("http://localhost/api/artwork/1");

    let params = {
            "artwork": "dolore",
        };
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "name": "at",
    "price": 5,
    "state": "qui"
}

fetch(url, {
    method: "PATCH",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PATCH api/artwork/{artwork}`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    name | string |  optional  | the name of the artwork
    price | integer |  optional  | the price of the artwork
    state | string |  optional  | the current state of the artwork
#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    artwork |  optional  | ArtworkResource the artwork to mofidy

<!-- END_ce1bdce463dc1dcef41695718f8aa596 -->

<!-- START_9c0bde2c7a869c05c2279d404d01eb20 -->
## Remove the specified resource from storage.

> Example request:

```bash
curl -X DELETE "http://localhost/api/artwork/1?artwork=nihil" 
```

```javascript
const url = new URL("http://localhost/api/artwork/1");

    let params = {
            "artwork": "nihil",
        };
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

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

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    artwork |  optional  | ArtworkResource the artwork to delete

<!-- END_9c0bde2c7a869c05c2279d404d01eb20 -->

<!-- START_9acbc0437496eb2c9d2231fd9bb453be -->
## Store an image in storage.

> Example request:

```bash
curl -X POST "http://localhost/api/artwork/1/image?artwork=voluptatem" \
    -H "Content-Type: application/json" \
    -d '{"image":"voluptate"}'

```

```javascript
const url = new URL("http://localhost/api/artwork/1/image");

    let params = {
            "artwork": "voluptatem",
        };
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "image": "voluptate"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/artwork/{artwork}/image`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    image | string |  optional  | the serialized image to store
#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    artwork |  optional  | ArtworkRessource the artwork in which to store the image

<!-- END_9acbc0437496eb2c9d2231fd9bb453be -->

<!-- START_3254c90bcf423b1f78d4b5f94a6fd80f -->
## Delete an image from an artwork

> Example request:

```bash
curl -X DELETE "http://localhost/api/artwork/1/image/1?artwork=est&media=modi" 
```

```javascript
const url = new URL("http://localhost/api/artwork/1/image/1");

    let params = {
            "artwork": "est",
            "media": "modi",
        };
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

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

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    artwork |  optional  | ArtworkResource the artwork containing the media to be deleted
    media |  optional  | MediaResource the media resource to delete

<!-- END_3254c90bcf423b1f78d4b5f94a6fd80f -->

#Customers


<!-- START_db113b5d97752f1fd361aab679155796 -->
## Store a newly created customer in storage.

> Example request:

```bash
curl -X POST "http://localhost/api/customer" \
    -H "Content-Type: application/json" \
    -d '{"email":"quaerat","phone":"earum","first_name":"beatae","last_name":"laboriosam","country":"nihil","city":"rerum","address":"sit"}'

```

```javascript
const url = new URL("http://localhost/api/customer");

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "email": "quaerat",
    "phone": "earum",
    "first_name": "beatae",
    "last_name": "laboriosam",
    "country": "nihil",
    "city": "rerum",
    "address": "sit"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/customer`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    email | string |  optional  | the customer's email address
    phone | string |  optional  | the customer's phone number
    first_name | string |  optional  | the customer's first name
    last_name | string |  optional  | the customer's last name
    country | string |  optional  | the customer's country of residence
    city | string |  optional  | the customer's city of residence
    address | string |  optional  | the customer's address

<!-- END_db113b5d97752f1fd361aab679155796 -->

<!-- START_557e9e3130c6c860f72e537486feeff0 -->
## Display a listing of the customers.

> Example request:

```bash
curl -X GET -G "http://localhost/api/customer" \
    -H "Content-Type: application/json" \
    -d '{"email":"molestiae","phone":"quaerat","first_name":"adipisci","last_name":"et","per_page_name":20,"country":"dolorum","city":"quis","address":"quaerat"}'

```

```javascript
const url = new URL("http://localhost/api/customer");

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "email": "molestiae",
    "phone": "quaerat",
    "first_name": "adipisci",
    "last_name": "et",
    "per_page_name": 20,
    "country": "dolorum",
    "city": "quis",
    "address": "quaerat"
}

fetch(url, {
    method: "GET",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (500):

```json
{
    "message": "Server Error"
}
```

### HTTP Request
`GET api/customer`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    email | string |  optional  | the customer's email address
    phone | string |  optional  | the customer's phone number
    first_name | string |  optional  | the customer's first name
    last_name | string |  optional  | the customer's last name
    per_page_name | integer |  optional  | the number of customer's to be displayed per page
    country | string |  optional  | the customer's country of residence
    city | string |  optional  | the customer's city of residence
    address | string |  optional  | the customer's address

<!-- END_557e9e3130c6c860f72e537486feeff0 -->

<!-- START_15d4b17958c5fedae33e98f37b6c9456 -->
## Display the specified user.

> Example request:

```bash
curl -X GET -G "http://localhost/api/customer/1?customer=laudantium" 
```

```javascript
const url = new URL("http://localhost/api/customer/1");

    let params = {
            "customer": "laudantium",
        };
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

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


> Example response (500):

```json
{
    "message": "Server Error"
}
```

### HTTP Request
`GET api/customer/{customer}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    customer |  optional  | Customer the customer to be displayed

<!-- END_15d4b17958c5fedae33e98f37b6c9456 -->

<!-- START_bef36af19a19b69319b1e6a98f349bfe -->
## Update the specified customer in storage.

> Example request:

```bash
curl -X PATCH "http://localhost/api/customer/1?customer=autem" \
    -H "Content-Type: application/json" \
    -d '{"email":"at","phone":"omnis","first_name":"maiores","last_name":"est","per_page_name":10,"country":"culpa","city":"blanditiis","address":"corporis"}'

```

```javascript
const url = new URL("http://localhost/api/customer/1");

    let params = {
            "customer": "autem",
        };
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "email": "at",
    "phone": "omnis",
    "first_name": "maiores",
    "last_name": "est",
    "per_page_name": 10,
    "country": "culpa",
    "city": "blanditiis",
    "address": "corporis"
}

fetch(url, {
    method: "PATCH",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PATCH api/customer/{customer}`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    email | string |  optional  | the customer's email address
    phone | string |  optional  | the customer's phone number
    first_name | string |  optional  | the customer's first name
    last_name | string |  optional  | the customer's last name
    per_page_name | integer |  optional  | the number of customer's to be displayed per page
    country | string |  optional  | the customer's country of residence
    city | string |  optional  | the customer's city of residence
    address | string |  optional  | the customer's address
#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    customer |  optional  | Customer the customer to be modified

<!-- END_bef36af19a19b69319b1e6a98f349bfe -->

<!-- START_3cbd86245dc8d01d781b200322e14482 -->
## Remove the specified customer from storage.

> Example request:

```bash
curl -X DELETE "http://localhost/api/customer/1?customer=dicta" 
```

```javascript
const url = new URL("http://localhost/api/customer/1");

    let params = {
            "customer": "dicta",
        };
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

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

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    customer |  optional  | Customer the customer to be deleted

<!-- END_3cbd86245dc8d01d781b200322e14482 -->

#Exhibitions


<!-- START_b643338cc2a226dc9d70ec7c36ee3cff -->
## Store a newly created exhibition in storage.

> Example request:

```bash
curl -X POST "http://localhost/api/exhibition" \
    -H "Content-Type: application/json" \
    -d '{"name":"corporis","begin":"commodi","end":"quas"}'

```

```javascript
const url = new URL("http://localhost/api/exhibition");

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "name": "corporis",
    "begin": "commodi",
    "end": "quas"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/exhibition`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    name | string |  optional  | the exhibition name
    begin | date |  optional  | the date for the start of the exhibition
    end | date |  optional  | the date for the end of the exhibition

<!-- END_b643338cc2a226dc9d70ec7c36ee3cff -->

<!-- START_25a27b691b69f18a01d7f8e9d0583337 -->
## Display a listing of the exhibitions.

> Example request:

```bash
curl -X GET -G "http://localhost/api/exhibition" \
    -H "Content-Type: application/json" \
    -d '{"name":"aut","begin":"accusamus","end":"aut","per_page":14}'

```

```javascript
const url = new URL("http://localhost/api/exhibition");

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "name": "aut",
    "begin": "accusamus",
    "end": "aut",
    "per_page": 14
}

fetch(url, {
    method: "GET",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (500):

```json
{
    "message": "Server Error"
}
```

### HTTP Request
`GET api/exhibition`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    name | string |  optional  | the exhibition name
    begin | date |  optional  | the date for the start of the exhibition
    end | date |  optional  | the date for the end of the exhibition
    per_page | integer |  optional  | the number of exhibition desired per page

<!-- END_25a27b691b69f18a01d7f8e9d0583337 -->

<!-- START_0858b30738c470fe9711a7b395ea372a -->
## Display the specified user.

> Example request:

```bash
curl -X GET -G "http://localhost/api/exhibition/1?exhibition=delectus" 
```

```javascript
const url = new URL("http://localhost/api/exhibition/1");

    let params = {
            "exhibition": "delectus",
        };
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

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


> Example response (500):

```json
{
    "message": "Server Error"
}
```

### HTTP Request
`GET api/exhibition/{exhibition}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    exhibition |  optional  | Exhibition the exhibition to be displayed

<!-- END_0858b30738c470fe9711a7b395ea372a -->

<!-- START_360950422ffc8ad91ad475cbfe399ced -->
## Update the specified exhibition in storage.

> Example request:

```bash
curl -X PATCH "http://localhost/api/exhibition/1?exhibition=ab" \
    -H "Content-Type: application/json" \
    -d '{"name":"quisquam","begin":"ex","end":"sunt"}'

```

```javascript
const url = new URL("http://localhost/api/exhibition/1");

    let params = {
            "exhibition": "ab",
        };
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "name": "quisquam",
    "begin": "ex",
    "end": "sunt"
}

fetch(url, {
    method: "PATCH",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PATCH api/exhibition/{exhibition}`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    name | string |  optional  | the exhibition name
    begin | date |  optional  | the date for the start of the exhibition
    end | date |  optional  | the date for the end of the exhibition
#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    exhibition |  optional  | Exhibition the exhibition to be modified

<!-- END_360950422ffc8ad91ad475cbfe399ced -->

<!-- START_048f0b62a7dae1ea53992fdcfa7adb9f -->
## Remove the specified exhibition from storage.

> Example request:

```bash
curl -X DELETE "http://localhost/api/exhibition/1?exhibition=beatae" 
```

```javascript
const url = new URL("http://localhost/api/exhibition/1");

    let params = {
            "exhibition": "beatae",
        };
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

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
`DELETE api/exhibition/{exhibition}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    exhibition |  optional  | Exhibition the exhibition to be deleted

<!-- END_048f0b62a7dae1ea53992fdcfa7adb9f -->

#Galleries


<!-- START_8564dc3bb676bcd45e6a90fb8e1ce0e6 -->
## Display the specified gallery.

> Example request:

```bash
curl -X GET -G "http://localhost/api/gallery?gallery=assumenda" 
```

```javascript
const url = new URL("http://localhost/api/gallery");

    let params = {
            "gallery": "assumenda",
        };
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

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


> Example response (500):

```json
{
    "message": "Server Error"
}
```

### HTTP Request
`GET api/gallery`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    gallery |  optional  | Gallery the gallery to be shown

<!-- END_8564dc3bb676bcd45e6a90fb8e1ce0e6 -->

<!-- START_32483809d5af0f4ae088a82a2cc0a3d1 -->
## Update the specified gallery in storage.

> Example request:

```bash
curl -X PATCH "http://localhost/api/gallery?gallery=dolores" \
    -H "Content-Type: application/json" \
    -d '{"name":"molestiae","address":"enim","phone":"animi"}'

```

```javascript
const url = new URL("http://localhost/api/gallery");

    let params = {
            "gallery": "dolores",
        };
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "name": "molestiae",
    "address": "enim",
    "phone": "animi"
}

fetch(url, {
    method: "PATCH",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PATCH api/gallery`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    name | string |  optional  | the name of the gallery
    address | string |  optional  | the address of the gallery
    phone | string |  optional  | the gallery's phone number
#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    gallery |  optional  | Gallery the gallery to be modified

<!-- END_32483809d5af0f4ae088a82a2cc0a3d1 -->

<!-- START_1007fbfa6fefe87af5890126e654d537 -->
## Remove the specified gallery from storage.

> Example request:

```bash
curl -X DELETE "http://localhost/api/gallery?gallery=itaque" 
```

```javascript
const url = new URL("http://localhost/api/gallery");

    let params = {
            "gallery": "itaque",
        };
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

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

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    gallery |  optional  | Gallery the gallery to be deleted

<!-- END_1007fbfa6fefe87af5890126e654d537 -->

#Newsletters


<!-- START_b47581cafffcea327ec9303595fd92d9 -->
## Store a newly created newsletter in storage.

> Example request:

```bash
curl -X POST "http://localhost/api/newsletter" \
    -H "Content-Type: application/json" \
    -d '{"subject":"praesentium","description":"expedita"}'

```

```javascript
const url = new URL("http://localhost/api/newsletter");

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "subject": "praesentium",
    "description": "expedita"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/newsletter`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    subject | string |  optional  | the subject of the newsletter
    description | string |  optional  | a description of the newsletter

<!-- END_b47581cafffcea327ec9303595fd92d9 -->

<!-- START_8dac32290ebe6ea88b7885eefc98af99 -->
## Display a listing of the newsletters.

> Example request:

```bash
curl -X GET -G "http://localhost/api/newsletter" \
    -H "Content-Type: application/json" \
    -d '{"subject":"quos","description":"ut"}'

```

```javascript
const url = new URL("http://localhost/api/newsletter");

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "subject": "quos",
    "description": "ut"
}

fetch(url, {
    method: "GET",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (500):

```json
{
    "message": "Server Error"
}
```

### HTTP Request
`GET api/newsletter`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    subject | string |  optional  | the subject of the newsletter
    description | string |  optional  | a description of the newsletter

<!-- END_8dac32290ebe6ea88b7885eefc98af99 -->

<!-- START_ec25f64ab707a44011752da8e7a4d70d -->
## Display the specified user.

> Example request:

```bash
curl -X GET -G "http://localhost/api/newsletter/1?newsletter=fuga" 
```

```javascript
const url = new URL("http://localhost/api/newsletter/1");

    let params = {
            "newsletter": "fuga",
        };
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

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


> Example response (500):

```json
{
    "message": "Server Error"
}
```

### HTTP Request
`GET api/newsletter/{newsletter}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    newsletter |  optional  | Newsletter the newsletter to be displayed

<!-- END_ec25f64ab707a44011752da8e7a4d70d -->

<!-- START_847114b6f407c929be2ebf11e092f83a -->
## Update the specified newsletter in storage.

> Example request:

```bash
curl -X PATCH "http://localhost/api/newsletter/1?newsletter=accusamus" \
    -H "Content-Type: application/json" \
    -d '{"subject":"autem","description":"eaque"}'

```

```javascript
const url = new URL("http://localhost/api/newsletter/1");

    let params = {
            "newsletter": "accusamus",
        };
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "subject": "autem",
    "description": "eaque"
}

fetch(url, {
    method: "PATCH",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PATCH api/newsletter/{newsletter}`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    subject | string |  optional  | the subject of the newsletter
    description | string |  optional  | a description of the newsletter
#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    newsletter |  optional  | Newsletter the newsletter to be modified

<!-- END_847114b6f407c929be2ebf11e092f83a -->

<!-- START_52b3704fc965f9ed203ea3f8ab0ab4cf -->
## Remove the specified newsletter from storage.

> Example request:

```bash
curl -X DELETE "http://localhost/api/newsletter/1?newsletter=ut" 
```

```javascript
const url = new URL("http://localhost/api/newsletter/1");

    let params = {
            "newsletter": "ut",
        };
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

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
`DELETE api/newsletter/{newsletter}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    newsletter |  optional  | Newsletter the newsletter to be deleted

<!-- END_52b3704fc965f9ed203ea3f8ab0ab4cf -->

<!-- START_ac3a357878a794971ab8d530fa6f80c9 -->
## Send the specified newsletter.

> Example request:

```bash
curl -X POST "http://localhost/api/newsletter/1?newsletter=molestiae" 
```

```javascript
const url = new URL("http://localhost/api/newsletter/1");

    let params = {
            "newsletter": "molestiae",
        };
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

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
`POST api/newsletter/{newsletter}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    newsletter |  optional  | Newsletter the newsletter to be sent

<!-- END_ac3a357878a794971ab8d530fa6f80c9 -->

#Orders


<!-- START_cd95d3e90339c282e0b608349e80a381 -->
## Store an order in the database

> Example request:

```bash
curl -X POST "http://localhost/api/order" \
    -H "Content-Type: application/json" \
    -d '{"email":"et","first_name":"dignissimos","last_name":"nobis","phone":"cumque","address":"dolore","country":"et","city":"ipsa","artwork_id":16,"date":"saepe"}'

```

```javascript
const url = new URL("http://localhost/api/order");

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "email": "et",
    "first_name": "dignissimos",
    "last_name": "nobis",
    "phone": "cumque",
    "address": "dolore",
    "country": "et",
    "city": "ipsa",
    "artwork_id": 16,
    "date": "saepe"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/order`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    email | string |  optional  | the customer's email
    first_name | string |  optional  | the customer's first name
    last_name | string |  optional  | the customer's last name
    phone | string |  optional  | the customer's phone number
    address | string |  optional  | the customer's address
    country | string |  optional  | the customer's country of residence
    city | string |  optional  | the customer's city of residence
    artwork_id | integer |  optional  | the sold artwork's ID
    date | date |  optional  | the date at which the artwork was sold

<!-- END_cd95d3e90339c282e0b608349e80a381 -->

<!-- START_d2e080af51835880674d3e2496ed6e62 -->
## Query an index of orders

> Example request:

```bash
curl -X GET -G "http://localhost/api/order" \
    -H "Content-Type: application/json" \
    -d '{"customer_id":16,"artwork_id":1,"date":"molestiae","per_page":"ipsa"}'

```

```javascript
const url = new URL("http://localhost/api/order");

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "customer_id": 16,
    "artwork_id": 1,
    "date": "molestiae",
    "per_page": "ipsa"
}

fetch(url, {
    method: "GET",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (500):

```json
{
    "message": "Server Error"
}
```

### HTTP Request
`GET api/order`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    customer_id | integer |  optional  | the customer's order ID
    artwork_id | integer |  optional  | the sold artwork's ID
    date | date |  optional  | the date at which the artwork was sold
    per_page | the |  optional  | number of desired orders per page

<!-- END_d2e080af51835880674d3e2496ed6e62 -->

<!-- START_9c4ec790d3f07a332b085b8efc187b58 -->
## api/order/{order}
> Example request:

```bash
curl -X GET -G "http://localhost/api/order/1?order=amet" 
```

```javascript
const url = new URL("http://localhost/api/order/1");

    let params = {
            "order": "amet",
        };
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

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


> Example response (500):

```json
{
    "message": "Server Error"
}
```

### HTTP Request
`GET api/order/{order}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    order |  optional  | OrderResource the order to show

<!-- END_9c4ec790d3f07a332b085b8efc187b58 -->

<!-- START_13abedc865b3acba6db70061a19ecb09 -->
## api/order/{order}
> Example request:

```bash
curl -X DELETE "http://localhost/api/order/1?order=dicta" 
```

```javascript
const url = new URL("http://localhost/api/order/1");

    let params = {
            "order": "dicta",
        };
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

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

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    order |  optional  | OrderResource the order to delete

<!-- END_13abedc865b3acba6db70061a19ecb09 -->

#Stats


<!-- START_c5a2ae4a8a8cbeb1fa7c1b2e52ded22a -->
## Processes the statistics of an owner

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


> Example response (500):

```json
{
    "message": "Server Error"
}
```

### HTTP Request
`GET api/stat`


<!-- END_c5a2ae4a8a8cbeb1fa7c1b2e52ded22a -->

#Users


<!-- START_f0654d3f2fc63c11f5723f233cc53c83 -->
## Store a newly created user in storage.

> Example request:

```bash
curl -X POST "http://localhost/api/user" \
    -H "Content-Type: application/json" \
    -d '{"firstname":"ut","last_name":"sunt","name":"porro","email":"ipsam","password":"aut"}'

```

```javascript
const url = new URL("http://localhost/api/user");

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "firstname": "ut",
    "last_name": "sunt",
    "name": "porro",
    "email": "ipsam",
    "password": "aut"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/user`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    firstname | string |  optional  | the user's first name
    last_name | string |  optional  | the user's last name
    name | string |  optional  | the user's nickname
    email | string |  optional  | the user's email
    password | string |  optional  | the user's encrypted password

<!-- END_f0654d3f2fc63c11f5723f233cc53c83 -->

<!-- START_ebdde946750e85f481c20691132d68d6 -->
## Store a newly created user in storage.

> Example request:

```bash
curl -X POST "http://localhost/api/user/member" \
    -H "Content-Type: application/json" \
    -d '{"firstname":"sequi","last_name":"rerum","name":"qui","email":"corrupti","password":"earum","role":"recusandae"}'

```

```javascript
const url = new URL("http://localhost/api/user/member");

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "firstname": "sequi",
    "last_name": "rerum",
    "name": "qui",
    "email": "corrupti",
    "password": "earum",
    "role": "recusandae"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/user/member`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    firstname | string |  optional  | the user's first name
    last_name | string |  optional  | the user's last name
    name | string |  optional  | the user's nickname
    email | string |  optional  | the user's email
    password | string |  optional  | the user's encrypted password
    role | string |  optional  | the user's role

<!-- END_ebdde946750e85f481c20691132d68d6 -->

<!-- START_2b6e5a4b188cb183c7e59558cce36cb6 -->
## Display a listing of the users.

> Example request:

```bash
curl -X GET -G "http://localhost/api/user" \
    -H "Content-Type: application/json" \
    -d '{"firstname":"omnis","last_name":"quia","name":"ut","email":"dolorem","role":"libero","per_page":2}'

```

```javascript
const url = new URL("http://localhost/api/user");

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "firstname": "omnis",
    "last_name": "quia",
    "name": "ut",
    "email": "dolorem",
    "role": "libero",
    "per_page": 2
}

fetch(url, {
    method: "GET",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (500):

```json
{
    "message": "Server Error"
}
```

### HTTP Request
`GET api/user`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    firstname | string |  optional  | the user's first name
    last_name | string |  optional  | the user's last name
    name | string |  optional  | the user's nickname
    email | string |  optional  | the user's email
    role | string |  optional  | the user's role
    per_page | integer |  optional  | the number of desired users per page

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


> Example response (500):

```json
{
    "message": "Server Error"
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


> Example response (500):

```json
{
    "message": "Server Error"
}
```

### HTTP Request
`GET api/user/self/permissions`


<!-- END_70df7a96931e7e5dad58e44039fb04ff -->

<!-- START_fa37e33f222a88f9f7970d74adea3935 -->
## api/user/{user}/permissions
> Example request:

```bash
curl -X GET -G "http://localhost/api/user/1/permissions" 
```

```javascript
const url = new URL("http://localhost/api/user/1/permissions");

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


> Example response (500):

```json
{
    "message": "Server Error"
}
```

### HTTP Request
`GET api/user/{user}/permissions`


<!-- END_fa37e33f222a88f9f7970d74adea3935 -->

<!-- START_03a16f7129590d539099cbf5acd95b1d -->
## Update the specified user in storage.

> Example request:

```bash
curl -X POST "http://localhost/api/user/role/1?user=omnis" \
    -H "Content-Type: application/json" \
    -d '{"role":"atque"}'

```

```javascript
const url = new URL("http://localhost/api/user/role/1");

    let params = {
            "user": "omnis",
        };
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "role": "atque"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/user/role/{user}`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    role | string |  optional  | the user's new role
#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    user |  optional  | User the user to be modified

<!-- END_03a16f7129590d539099cbf5acd95b1d -->

<!-- START_a48ebc3a0d6c354cf2542b4eca6aa7da -->
## api/user/permission/{user}/{permission}
> Example request:

```bash
curl -X POST "http://localhost/api/user/permission/1/1?user=quia&permission=enim" 
```

```javascript
const url = new URL("http://localhost/api/user/permission/1/1");

    let params = {
            "user": "quia",
            "permission": "enim",
        };
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

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
`POST api/user/permission/{user}/{permission}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    user |  optional  | User the user to be modified
    permission |  optional  | Permission the permissions to be applied

<!-- END_a48ebc3a0d6c354cf2542b4eca6aa7da -->

<!-- START_ceec0e0b1d13d731ad96603d26bccc2f -->
## Display the specified user.

> Example request:

```bash
curl -X GET -G "http://localhost/api/user/1?user=expedita" 
```

```javascript
const url = new URL("http://localhost/api/user/1");

    let params = {
            "user": "expedita",
        };
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

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


> Example response (500):

```json
{
    "message": "Server Error"
}
```

### HTTP Request
`GET api/user/{user}`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    user |  optional  | User the user to show

<!-- END_ceec0e0b1d13d731ad96603d26bccc2f -->

<!-- START_e75f2f63a5a2351c4f4d83bc65cefcf8 -->
## Update the specified user in storage.

> Example request:

```bash
curl -X PATCH "http://localhost/api/user" \
    -H "Content-Type: application/json" \
    -d '{"firstname":"enim","last_name":"aut","name":"ut","email":"repellendus","password":"et","role":"id"}'

```

```javascript
const url = new URL("http://localhost/api/user");

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "firstname": "enim",
    "last_name": "aut",
    "name": "ut",
    "email": "repellendus",
    "password": "et",
    "role": "id"
}

fetch(url, {
    method: "PATCH",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PATCH api/user`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    firstname | string |  optional  | the user's first name
    last_name | string |  optional  | the user's last name
    name | string |  optional  | the user's nickname
    email | string |  optional  | the user's email
    password | string |  optional  | the user's encrypted password
    role | string |  optional  | the user's role

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


> Example response (500):

```json
{
    "message": "Server Error"
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


> Example response:

```json
null
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


> Example response:

```json
null
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


> Example response:

```json
null
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


> Example response:

```json
null
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


> Example response (500):

```json
{
    "message": "Server Error"
}
```

### HTTP Request
`GET api/artist/{artist}`


<!-- END_744deecffbee5147e1911092f23f3d24 -->

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


