# Code Checking Standards

This template uses the following stat analyzers:

* [phpstan(larastan)](https://github.com/larastan/larastan)
* [codesniffer](https://github.com/squizlabs/PHP_CodeSniffer)
* [rector](https://github.com/driftingly/rector-laravel)

## PhpStan

[Documentation](https://phpstan.org/)

This is a static code analyzer that checks your code for
typing before executing the code

## CodeSniffer

This is a tool for checking code according to standards in the PHP world

## Rector

This is an automatic refactoring tool that checks the code - the difference from CodeSniffer is that it can fix
the code and can also change the constructions (remove the extra else, etc.)

for convenience, you can also install it as a plugin in phpstorm and fix the code via alt+enter

## Usage

A command that runs code check

```bash
make lint
```

A command to fix the code

```bash
make lint-fix
```

A command to hide errors (only for phpstan) allows you to hide errors in the phpstan-baseline. neon file and continue the correct operation of phpstan

If you are fixing errors and run this command, it will remove errors from the phpstan-baseline. neon file

```bash
make code-baseline
```
