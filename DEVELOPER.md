# Java Script Code Spliting

Followed: http://channingdefoe.com/vuejs-code-splitting-in-laravel-webpack/

```
npm install babel-plugin-syntax-dynamic-import
```

Create a file called .babelrc in your root Laravel installation and enter the following:

```
{
    "plugins": ["syntax-dynamic-import"]
}

```
In your webpack.mix.js file that is in your root Laravel installation enter the following:

```
mix.webpackConfig({
    output: {
        // Chunks in webpack
        publicPath: '/',
        chunkFilename: 'js/components/[name].js',
    },
});
```

php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --tag="migrations"
php artisan migrate



npm install laravel-mix-copy-watched

npm install --global prettier

mkdir app/Exports

$ composer require bjeavons/zxcvbn-php
composer require elibyy/tcpdf-laravel
composer require maatwebsite/excel
composer require spatie/laravel-permission

 php artisan make:crud clients --force --display-name="Applicants" --grid-columns="full_name:filing_court:phone:address:status"
php artisan make:crud statuses --force --display-name="Statuses" --grid-columns="name:alais:sequence"


#
