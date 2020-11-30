# Architecture

---

- [Overview](/{{route}}/{{version}}/architecture#overview)
- [Routes](/{{route}}/{{version}}/architecture#routes)
- [Controllers](/{{route}}/{{version}}/architecture#controllers)
- [Validations](/{{route}}/{{version}}/architecture#validations)
- [Eloquent](/{{route}}/{{version}}/architecture#Eloquent)

<a name="overview"></a>
## Overview

<a name="make-commands"></a>
We are using [Laravel PHP Framework](https://laravel.com) in our project.

Here is the basic architecture of Laravel

![Laravel Architecture](/img/laravel-architecture.jpg)

<a name="routes"></a>
## Routes

As per the flow, initially request goes to the laravel routes, in our case it goes to `routes/api.php`.

We are using `resource` method in Routing. That method generates resourceful endpoints.

E.g. `Route::resource('promocodes', PromocodeController:class);` will generate following endpoints.

| Method | URI   | Action | Description |
| : |   :-   |  :  | : |
| GET  | api/promocodes                  | App\Http\Controllers\PromocodeController@index | Retrieve all promocodes. |
| POST      | api/promocodes                  | App\Http\Controllers\PromocodeController@store | Create new Promocode |
| GET  | api/promocodes/create           | App\Http\Controllers\PromocodeController@create | Create a view for add new hotel | 
| GET  | api/promocodes/{promocode}          | App\Http\Controllers\PromocodeController@show | Return a single promocode that matches the id |
| PUT | api/promocodes/{promocode}          | App\Http\Controllers\PromocodeController@update | Update the promocode that matches the id |
| DELETE    | api/promocodes/{promocode}          | App\Http\Controllers\PromocodeController@destroy | Delete the promocode that matches the id |
| GET  | api/promocodes/{promocode}/edit     | App\Http\Controllers\PromocodeController@edit | Create a view for update the promocode that matches the id |

<a name="controllers"></a>
## Controllers

Based on selected endpoint router will navigate request to controller. In our case, request goes to `PromocodeController` and it goes to selected action (function).

And based on the request it will call the Request Validation (if specified).

For Example. If we call `api/promocodes` (POST) endpoint for creating new entry, then it will call `CreatePromocodeRequest` Validation Class, which will check for all the validation errors. And once that passes, it will go further in `store` method of `PromocodeController`.

<a name="validations"></a>
## Validations

Once the request comes to Request Validation class, it will check for all the rules specified in the `rules` method.

> {info} We can define multiple rules separated by using pipeline symbol.

For Example, `'code' => 'required|string|unique:promocodes,code'`

Will check and ensure that `code` field in request should 
- Required
- Should be string value
- Should be unique across all the values stored in code field in promocodes table

<a name="eloquent"></a>
## Eloquent

Once the validation passes, controller will prepare data and send it to repository and then model. And as we are using Eloquent Relationships. For `promocodes`
We are storing related table data first. And then assigning that table data with hotels table. 

Explanation of following Code:

```php
$promocode = new Promocode();
$promocode->fill($request->all());
$promocode->save();
```

First it creates new Object of Model.
Then it calls fill method of Model. Which actually fills all the value based on `$fillable` value in each model.

For Example. Promocode table will fill only `['title','code','description','radius','radius_unit','start_at','end_at','is_active']` values from the request and no any other values.

And lastly, save function will save the data to storage. In our case, it will store to MySQL database.
