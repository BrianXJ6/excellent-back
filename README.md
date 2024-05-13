<p align="center">
    <a href="https://github.com/BrianXJ6/excellent-back" target="_blank">
        <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
    </a>
</p>

## Requirements

- composer: `^2.x`

## Installation

The first step is to clone the project

```bash
git clone https://github.com/BrianXJ6/excellent-back.git
```

Access the `excellent-back` directory that was just created when performing the clone and within it run the command for the composer to install all the dependencies, follow the command below if you wish:

```bash
cd excellent-back && composer update
```

With all the dependencies installed, it is now possible to access `Sail` through the `vendor/bin/sail` command, but it is a little uncomfortable when we start using it constantly, if you prefer, use the command below to create an alias:

```bash
alias sail="vendor/bin/sail"
```

Now we need to create a `.env` file for the application to work correctly, then in the root of the project run the following command:

```bash
cp .env.example .env
```

Now we can raise our application with the following command:

```bash
sail up -d
```

With the next command, we will generate our app key and make our file directory publicly accessible.

```bash
sail a key:generate && sail a storage:link
```

Finally, let's run our migrations on the database so that the application can start being used, run the following command:

```bash
sail a migrate --seed
```
