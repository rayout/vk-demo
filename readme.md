# **Задача:**
Написать упрощенную систему выполнения заказов.  
Есть заказчики, исполнители и система. Заказчик публикует заказ, указывает его стоимость.

Исполнитель видит ленту заказов, доступных для исполнения.  
Исполнитель кликает «выполнить» на заказе, исполнителю на счет зачисляется сумма за вычетом комиссии системы.

У одного заказа может быть только один исполнитель. Если заказ выполнен, он исчезает из ленты. 


## Требования

* php 5.6+
* composer
* nodejs 5.10.0 (другие не проверялись)

Опцианально docker.

## Установка

* `make install`
* `nano .env` (прописать HOST и MYSQL_PORT при желании)
* прописать HOST в `/etc/hosts`
* настройка конфигов в app/config/databse если менялся порт и изменение host если запуск не через docker
* npm run prod
* `docker-compose up` или если нет, настройка nginx на локальной машине с помощью `nginx.conf`  в корне проекта.

## Особенности реализации

1. Написан фреймворк с нуля. Вдохновлся Laravel и некоторыми репозиториями в интернете, но из за ограничений во времени необходимо дорабатывать
многие компоненты. Основное и довольно сложное - модели. Если их реализовать (с учетом связей), то контроллеры станут намного чище.
Еще не хватает класса валидации. В vue так же компонент для валидации был бы кстати.
2. Множественность баз данных реализована. Используется как в миграциях так и в моделях.
3. Фронт - довольно кривой, так как опыта vue у меня довольно мало. Но работает.
4. Не совсем уверен что реализация транзакций между БД у меня правильная. Точнее она наверняка не правильная, но время поджимало.
5. JWT используется не правильно. Не реализована подмена токена после протухания и другие возможности протокола.
Но тем не менее авторизация работает. Недоработка опять же связана с ограниченностью времени.
6. Я старался писать сам, но все равно пришлось использовать несколько пакетов для ускорения разработки.
Миграции, класс работы с БД и фейкер. 
7. К сожалению основной функционал получился самым грязным. 
Я оставил его на последний этап реализации. И это было ошибкой. Спешка из за задержки и общая усталость превратились в говнокод.
Но я решил что доработка до нужного состояния потребует слишком много времени, поэтому оставил как есть.

## Распределение времени

По моим подсчетам я потратил примерно 3-4 8-ми часовых рабочих дня. Но размазалось это на 7 дней, так как не всегда удавалось поработать.

Распределение времени в процентном соотношении:

* php фреймворк и доработки в процессе реализации - 30%
* vue front, webpack, bootstrap - 20%
* настройка среды и образов docker - 10%
* Реализация функцинала (фронт + бэк) - 40%