<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Тестовое задание API интернет-магазина

- [Текст задачи находится здесь](https://docs.google.com/document/d/1oSTzvjFFYXWqMoCtP5yj0o0cqYAGk-xTlYDuw7XitRY/edit).

Развертывание проекта:
<pre>
composer install
</pre>
Необходимо создать базу данных и создать файл .env с заполнением данных для подключения к базе данных
<pre>
php artisan optimize 
php artisan key:generate
php artisan optimize
</pre>

Миграция таблиц и заполнение тестовыми данными
<pre>
php artisan migrate
php artisan db:seed
</pre>
##
Примечания:

-Для товаров доступна необязательная загрузка изображений. Для работы необходимо создать ссылку в <i>public</i> на папку <i>storage</i> коммандой:
<pre>
php artisan storage:link
</pre>

Описание запросов:

<pre>GET <i>/api/v1/products</i> - постраничный вывод товаров

Параметры(Все поля являются необязательными):

<i>count</i> ('integer', 'min: 5', 'max: 50') - количество элементов на странице
<i>search_product_name</i> ('string', 'min:3', 'max:50') - поиск товаров по наименованию товаров
<i>category_id</i> ('integer') - фильтрация по id категории
<i>search_category_name</i> ('string', 'min:3', 'max:50') - поиск товаров по названию категорий
<i>search_price_from</i> ('float') - фильтрация по цене от
<i>search_price_to</i> ('float') - фильтрация по цене до
<i>show_published</i> ('boolean') - показать только опубликованные
<i>show_deleted</i> ('boolean') - показать все товары включая удаленные
</pre>

<pre>POST <i>/api/v1/products</i> - создание товара

Параметры(Обязательные поля отмечены *):
<i>name*</i> ('string', 'max:255') - наименование
<i>description</i> ('string', 'max:500') - описание
<i>price*</i> ('float', 'min:0', 'max:99999999.99') - цена 
<i>categories</i>* ('array, 'min:2', 'max:10') - массив с id категорий к которым необходимо привязать товар
<i>categories[]*</i> - проверка на повторение и на наличие категорий в системе
<i>is_published</i> (boolean) - статус публикации
<i>image</i> - картинка
</pre>

<pre>PUT/PATCH <i>/api/v1/products/%ID%</i> - обновление товара

Параметры(Все поля не обязательные, заполняются только те, которые подверглись изменениям):
<i>name*</i> ('string', 'max:255') - наименование
<i>description</i> ('string', 'max:500') - описание
<i>price*</i> ('float', 'min:0', 'max:99999999.99') - цена 
<i>categories</i>* ('array, 'min:2', 'max:10') - массив с id категорий к которым необходимо привязать товар
<i>categories[]*</i> - проверка на повторение и на наличие категорий в системе
<i>is_published</i> (boolean) - статус публикации
<i>image</i> - картинка
</pre>

<pre>DELETE <i>/api/v1/products/%ID%</i> - Удаление товара(softDelete)
</pre>

<pre>GET <i>/api/v1/categories</i> - Список категорий
</pre>

<pre>POST <i>/api/v1/categories</i> - создание товара

Параметры(Обязательные поля отмечены *):
<i>name*</i> ('string', 'max:255') - наименование
</pre>

<pre>DELETE <i>/api/v1/categories/%ID%</i> - Удаление категории(при условии что категория не привязана к товару)
</pre>


