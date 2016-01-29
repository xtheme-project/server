# XTheme Server
XTheme Website Server

## Installation

```sh
git clone git@github.com:xtheme-project/server.git
cd server
composer install
```

## Configuration

```sh
cp app/config/parameters.yml.dist app/config/parameters.yml
```
Next, create a yml file in `app/config/domains` for each domain you want the server to host.

For example `localhost.yml`
```yml
---
site:
    path: /data/git/xtheme-project/core/sites/demo
theme:
    path: /data/git/xtheme-project/core/themes/demo
```

## Starting the server:

```sh
php -S 0.0.0.0:54321 -t web/
```

Now you can open [http://localhost:54321](http://localhost:54321) to view the site

## License

MIT (see [LICENSE](LICENSE))

## Brought to you by the LinkORB Engineering team

<img src="http://www.linkorb.com/d/meta/tier1/images/linkorbengineering-logo.png" width="200px" /><br />
Check out our other projects at [linkorb.com/engineering](http://www.linkorb.com/engineering).

Btw, we're hiring!
