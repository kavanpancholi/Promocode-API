# API Documentation

---

- [List Promocodes](/{{route}}/{{version}}/apidoc#listPromocodes)
- [List Active Promocodes](/{{route}}/{{version}}/apidoc#listActivePromocodes)
- [Create Promocode](/{{route}}/{{version}}/apidoc#createPromocode)
- [Apply Promocode](/{{route}}/{{version}}/apidoc#applyPromocode)
- [Update Promocode](/{{route}}/{{version}}/apidoc#updatePromocode)
- [Activate Promocode](/{{route}}/{{version}}/apidoc#activatePromocode)
- [Deactivate Promocode](/{{route}}/{{version}}/apidoc#deactivatePromocode)
- [Delete Promocode](/{{route}}/{{version}}/apidoc#deletePromocode)

<a name="listPromocodes"></a>
## List Promocodes

### Endpoint

| Method | URI   | Headers |
| : |   :-   |  :  |
| GET |  `http://localhost:8080/api/promocodes`    |  Default  |

### URL Params

```json
{
    "page": "1"
}
```

### Data Params

```html
None
```

> {success} Success Response

Code `200`

Content

```json
{
    "status": "success",
    "data": {
        "data": [
            {
                "id": 1,
                "title": "5km Radius free",
                "code": "FREE5KM",
                "description": "This promocode gives free ride within 5 km radius",
                "radius": 5,
                "radius_unit": "km",
                "start_at": "2020-11-30 19:10:15",
                "end_at": "2020-12-30 19:10:15",
                "is_active": true
            },
            {
                "id": 2,
                "title": "10km Radius free",
                "code": "FREE10KM",
                "description": "This promocode gives free ride within 10 km radius",
                "radius": 10,
                "radius_unit": "km",
                "start_at": "2020-11-30 19:10:15",
                "end_at": "2020-12-30 19:10:15",
                "is_active": true
            }
        ],
        "meta": {
            "current_page": 1,
            "total": 2,
            "count": 2,
            "per_page": 15,
            "total_pages": 1
        }
    }
}
```


<a name="listActivePromocodes"></a>
## List Active Promocodes

### Endpoint

| Method | URI   | Headers |
| : |   :-   |  :  |
| GET |  `http://localhost:8080/api/promocodes/active`    |  Default  |

### URL Params

```json
{
    "page": "1"
}
```

### Data Params

```html
None
```

> {success} Success Response

Code `200`

Content

```json
{
    "status": "success",
    "data": {
        "data": [
            {
                "id": 2,
                "title": "10km Radius free",
                "code": "FREE10KM",
                "description": "This promocode gives free ride within 10 km radius",
                "radius": 10,
                "radius_unit": "km",
                "start_at": "2020-11-30 19:10:15",
                "end_at": "2020-12-30 19:10:15",
                "is_active": true
            },
            {
                "id": 3,
                "title": "15km Radius Free Ride",
                "code": "FREE12KM",
                "description": "This promocode gives free ride within 15 km radius",
                "radius": 15,
                "radius_unit": "km",
                "start_at": "2020-10-30 11:00:00",
                "end_at": "2021-01-01 01:00:00",
                "is_active": true
            }
        ],
        "meta": {
            "current_page": 1,
            "total": 2,
            "count": 2,
            "per_page": 15,
            "total_pages": 1
        }
    }
}
```

<a name="createPromocode"></a>
## Create Promocode

### Endpoint

| Method | URI   | Headers |
| : |   :-   |  :  |
| POST |  `http://localhost:8080/api/promocodes`    |  Default  |

### URL Params

```html
None
```

### Data Params

```json
{
    "title": "12kb Radius Free Ride",
    "code": "FREE12KM",
    "radius": 12,
    "radius_unit": "km",
    "description": "This promocode gives free ride within 12 km radius",
    "start_at": "2020-10-30 11:00:00",
    "end_at" : "2021-01-01 01:00:00"
}
```

> {success} Success Response

Code `200`

Content

```json
{
    "status": "success",
    "message": "Promocode has been created successfully",
    "data": {
        "id": 3,
        "title": "12kb Radius Free Ride",
        "code": "FREE12KM",
        "description": "This promocode gives free ride within 12 km radius",
        "radius": 12,
        "radius_unit": "km",
        "start_at": "2020-10-30 11:00:00",
        "end_at": "2021-01-01 01:00:00",
        "is_active": null
    }
}
```

> {danger} Error Response

Code `400`

Content

```json
{
    "status": "error",
    "message": {
        "title": [
            "The title field is required."
        ],
        "code": [
            "The code field is required."
        ],
        "radius": [
            "The radius field is required."
        ],
        "radius_unit": [
            "The radius unit field is required."
        ],
        "start_at": [
            "The start at field is required."
        ],
        "end_at": [
            "The end at field is required."
        ]
    }
}
```


<a name="applyPromocode"></a>
## Apply Promocode

### Endpoint

| Method | URI   | Headers |
| : |   :-   |  :  |
| POST |  `http://localhost:8080/api/promocodes/apply`    |  Default  |

### URL Params

```html
None
```

### Data Params

```json
{
    "origin_latitude": "33.9587799",
    "origin_longitude": "-118.4111962",
    "destination_latitude": "33.9793132",
    "destination_longitude": "-118.4674853",
    "code": "FREE10KM"
}
```

> {success} Success Response

Code `200`

Content

```json
{
    "status": "success",
    "message": "Promocode has been created successfully",
    "data": {
        "routes": {"..."},
        "promocode": {
            "id": 2,
            "title": "10km Radius free",
            "code": "FREE10KM",
            "description": "This promocode gives free ride within 10 km radius",
            "radius": 10,
            "radius_unit": "km",
            "start_at": "2020-11-30 19:10:15",
            "end_at": "2020-12-30 19:10:15",
            "is_active": true
        }
    }
}
```

> {danger} Error Response if Promocode is not valid

Code `400`
Content

```json
{
    "status": "error",
    "message": {
        "code": [
            "The promocode is not valid."
        ]
    }
}
```

> {danger} Error Response if Promocode is not in range

Code `400`
Content

```json
{
    "status": "error",
    "message": "Sorry. Your destination is not in the range."
}
```


<a name="updatePromocode"></a>
## Update Promocode

### Endpoint

| Method | URI   | Headers |
| : |   :-   |  :  |
| PUT |  `http://localhost:8080/api/promocodes/{id}`    |  Default  |

### URL Params

```html
None
```

### Data Params

```json
{
    "title": "15km Radius Free Ride",
    "code": "FREE12KM",
    "radius": 15,
    "radius_unit": "km",
    "description": "This promocode gives free ride within 15 km radius",
    "start_at": "2020-10-30 11:00:00",
    "end_at" : "2021-01-01 01:00:00"
}
```

> {success} Success Response

Code `200`

Content

```json
{
    "status": "success",
    "message": "Promocode has been updated successfully",
    "data": {
        "id": 3,
        "title": "15km Radius Free Ride",
        "code": "FREE12KM",
        "description": "This promocode gives free ride within 15 km radius",
        "radius": 15,
        "radius_unit": "km",
        "start_at": "2020-10-30 11:00:00",
        "end_at": "2021-01-01 01:00:00",
        "is_active": true
    }
}
```

> {danger} Error Response if Code is not unique

Code `400`

Content

```json
{
    "status": "error",
    "message": {
        "code": [
            "The code has already been taken."
        ]
    }
}
```


> {danger} Error Response if Promocode ID is invalid

Code `404`

Content

```json
{
    "status": "error",
    "message": "Data not found"
}
```


<a name="activatePromocode"></a>
## Activate Promocode

### Endpoint

| Method | URI   | Headers |
| : |   :-   |  :  |
| PUT |  `http://localhost:8080/api/promocodes/{id}/activate`    |  Default  |

### URL Params

```html
None
```

### Data Params

```html
NONE
```

> {success} Success Response

Code `200`

Content

```json
{
    "status": "success",
    "message": "Promocode has been activated successfully"
}
```

> {danger} Error Response if Promocode ID is invalid

Code `404`

Content

```json
{
    "status": "error",
    "message": "Data not found"
}
```


<a name="deactivatePromocode"></a>
## Deactivate Promocode

### Endpoint

| Method | URI   | Headers |
| : |   :-   |  :  |
| PUT |  `http://localhost:8080/api/promocodes/{id}/deactivate`    |  Default  |

### URL Params

```html
None
```

### Data Params

```html
NONE
```

> {success} Success Response

Code `200`

Content

```json
{
    "status": "success",
    "message": "Promocode has been deactivated successfully"
}
```

> {danger} Error Response if Promocode ID is invalid

Code `404`

Content

```json
{
    "status": "error",
    "message": "Data not found"
}
```


<a name="deletePromocode"></a>
## Delete Promocode

### Endpoint

| Method | URI   | Headers |
| : |   :-   |  :  |
| DELETE |  `http://localhost:8080/api/promocodes/{id}`    |  Default  |

### URL Params

```html
None
```

### Data Params

```html
None
```

> {success} Success Response

Code `200`
Content

```json
{
    "status": "success",
    "message": "Promocode has been removed successfully"
}
```

> {danger} Error Response

Code `404`
Content

```json
{
    "status": "error",
    "message": "Data not found"
}
```
