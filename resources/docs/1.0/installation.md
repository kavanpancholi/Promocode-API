# Installation

---

- [Install](/{{route}}/{{version}}/installation#install)
- [View](/{{route}}/{{version}}/installation#view)

<a name="install"></a>
## Install

Install via MakeFile

```shell script
make deploy
```

This command will do following things:
- Set Environment Variables
- Run Docker Services
- Waits until MySQL Service starts
- Generate API Key
- Generate MySQL Schema and Default Database Data Entries

Output:

![Test List Endpoint](/img/make-deploy.png)


<a name="view"></a>
## View

Open [http://localhost:8080](http://localhost:8080)
