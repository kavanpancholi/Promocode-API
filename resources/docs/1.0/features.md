# Features

---

- [Make Commands](/{{route}}/{{version}}/features#make-commands)
- [Database Migrations](/{{route}}/{{version}}/features#database-migrations)
- [Rate Limit](/{{route}}/{{version}}/features#rate-limit)
- [CORS](/{{route}}/{{version}}/features#cors)
- [ETag](/{{route}}/{{version}}/features#etag)
- [PHPStan](/{{route}}/{{version}}/features#phpstan)
- [Caching](/{{route}}/{{version}}/features#caching)

<a name="make-commands"></a>
## Make Commands

A makefile is a file (by default named "Makefile") containing a set of directives used by a make build automation tool to generate a target/goal.

Using following [Make Command][1] you can check all the available commands

[1]: https://en.wikipedia.org/wiki/Makefile

```shell script
make help
```

Output:

![Make Help Command](/img/make-help.png)


<a name="database-migrations"></a>
## Database Migrations & Seeding

[Migrations](https://laravel.com/docs/6.x/migrations) are like version control for your database, allowing your team to easily modify and share the application's database schema. Migrations are typically paired with Laravel's schema builder to easily build your application's database schema. If you have ever had to tell a teammate to manually add a column to their local database schema, you've faced the problem that database migrations solve.

Laravel includes a simple method of [seeding](https://laravel.com/docs/6.x/seeding) your database with test data using seed classes. 

> {info} Database Migrations we are using in deploying script. So we don't need to execute that after the deployment. 

```shell script
docker-compose exec laravel php artisan migrate:fresh --seed --force
```

Output:

![Make Help Command](/img/docker-migration.png)


<a name="rate-limit"></a>
## Rate Limit

[Rate limiting](https://www.keycdn.com/support/rate-limiting) is used to control the amount of incoming and outgoing traffic to or from a network. For example, let's say you are using a particular service's API that is configured to allow 100 requests/minute. If the number of requests you make exceeds that limit, then an error will be triggered.

---

By Default, we are having rate limit of 60 requests per minute.
But if we want to change that, we can do it in `app/Http/Kernel.php`

```php
protected $middlewareGroups = [
    ...
    'api' => [
        'throttle:60,1',
        'bindings',
    ],
];
```


<a name="cors"></a>
## CORS

[Cross-Origin Resource Sharing (CORS)](https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS) is a mechanism that uses additional HTTP headers to tell browsers to give a web application running at one origin, access to selected resources from a different origin. A web application executes a cross-origin HTTP request when it requests a resource that has a different origin (domain, protocol, or port) from its own.

The default configuration of this application allows all requests from any origin (denoted as '*'). But we probably want to at least specify some origins relevant to your project. If we want to allow requests to come in from https://google.com and https://laravel.com then add those domains to the config file:

File: `config/cors.php`

```php
'default_profile' => [

'allow_origins' => [
    'https://google.be',
    'https://laravel.com',
],
```

If you, for example, want to allow all subdomains from a specific domain, you can use the wildcard asterisk (*) and specifiy that:

File: `config/cors.php`

```php
'default_profile' => [

'allow_origins' => [
    'https://google.com',
    'https://laravel.com',

    'https://*.google.com',
    'https://*.laravel.com',
],
```



<a name="etag"></a>
## ETag

The [ETag](https://en.wikipedia.org/wiki/HTTP_ETag) or entity tag is part of HTTP, the protocol for the World Wide Web. It is one of several mechanisms that HTTP provides for Web cache validation, which allows a client to make conditional requests. This allows caches to be more efficient and saves bandwidth, as a Web server does not need to send a full response if the content has not changed. ETags can also be used for optimistic concurrency control, as a way to help prevent simultaneous updates of a resource from overwriting each other.

---

By adding a middleware in routing like below, we can implement ETag.

```php
Route::resource('promocodes', [PromocodeController::class])->middleware('cache.headers:public;max_age=2628000;etag');
``` 

If the etag option has been set, it will automatically hash the response content so it can be quickly compared against the etag the Request sent.

### Lifecycle of ETag:

![ETag](/img/etag.png)

<a name="caching"></a>
## Caching

[Caching][1] is the process of storing data in a cache. A cache is a temporary storage area. For example, the files you automatically request by looking at a Web page are stored on your hard disk in a cache subdirectory under the directory for your browser.

[1]: https://en.wikipedia.org/wiki/Cache_(computing)

We use [Redis](https://redis.io/) for caching.

Redis is an open source (BSD licensed), in-memory data structure store, used as a database, cache and message broker. It supports data structures such as strings, hashes, lists, sets, sorted sets with range queries, bitmaps, hyperloglogs, geospatial indexes with radius queries and streams. Redis has built-in replication, Lua scripting, LRU eviction, transactions and different levels of on-disk persistence, and provides high availability via Redis Sentinel and automatic partitioning with Redis Cluster.

---

In order to implement Response Caching,
We have created a middleware which will run before each request.
That will check whether request type is GET or any other. If request type is get, in that case we cache entire response.

```php
public function handle($request, Closure $next)
{
    if ($request->method() === 'GET') {
        $key = 'request|' . $request->url();
        return Cache::remember($key, 60, function () use ($request, $next) {
            return $next($request);
        });
    }
    return $next($request);
}
```

For now, we have added 60 secs for caching. That we can modify in the `app/Http/Middleware/ResponseCacheMiddleware.php` file. 
