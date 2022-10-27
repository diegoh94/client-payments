# Technical tests - Enpoints
Para el desarrollo del presente proyecto se ha tomado en cuando lo expresado en la historia de usuario. Haciendo uso de mi criterio en ocasiones para detalles de la lógica de negocio.
## Stack
- Laravel 8.83.25
- PHP 8.1.11
## Instalación
- Instalar dependencias: composer install && npm install
- Personalizar parámetros de BD en .env
- Personalizar driver para jobs: QUEUE_CONNECTION=database
- Crear migraciones para almacenar queue: php artisan queue:table
- Personalizar driver para cache: CACHE_DRIVER=file
- Personalizar credenciales de MAIL en .env
- Ejecutar migraciones: php artisan migrate
- Ejecutar seeders: php artisan db:seed
- Limpiar cache:  php artisan cache:clear
- Poner a trabajar las queues: php artisan queue:work
## Consideraciones
- Se ha hecho uso de factories y seeders para asignar data de prueba.
- Se ha utilizado una clave primaria convencional para el modelo Client y una clave especial (uuid) para el modelo Payment
- Se está usuando por defecto el primer valor de https://mindicador.cl/api/dolar para leer el tipo de cambio.
- El tipo de cambio es almacenado en caché y olvidado al finalizar el día. De esta forma se garantiza realizar una sola peticion diaria a la API.
## Lógica
### Guardar exchange_rate en payments
- Al crear un pago, un Observer detecta el evento de creación y dispara un job.
- Este job, hace uso de la caché para obtener el exchange_rate.
- En caso la variable ya exista en caché, tomará el valor directamente de la caché.
- Caso contrario hará una petición a la api(https://mindicador.cl/api/dolar) a través del cliente ExchangeRateUsdClient
- Para limitar el tiempo de permanencia en caché de esta variable, se ha usado Carbon. Clase que permite establecer un datatime del final del día, que será pasado como argumento al helper cache()->remember().
- Seguidamente el mismo job se encarga de actualizar el payment, asignando el valor de exchange_rate
### Envío de correo
- Para diseñar el correo se hace uso de Mailable, para ello he creado CreatedPaymentNotificationMailable.
- El envío de correo también se esta encolando cuándo se hace create del modelo.
- Para este caso no se ha creado un job, pues basta con ir CreatedPaymentNotificationMailable y hacer implements de ShouldQueue. 
- Con esto conseguimos encolar siempre que se quiera hacer un envío de correo.
## Oportunidades de mejora
- Usar Supervisor para ejecución de jobs.
- Establecer autenticación para todos los endpoints. Por ejemplo haciendo uso de Laravel Passport
## Endpoints
Puede usar Postman como herramienta para probar los endpoints. En mi caso uso el host 'client-payments.test.com' como base.
1. Listar clientes
GET http://client-payments.test.com/api/clients
Devuelve un arreglo de objetos Client.

![image](https://user-images.githubusercontent.com/26363315/198378647-d5b93faa-b543-42e0-a3b6-a5734d57118a.png)

2. Listar pagos de un cliente
GET http://client-payments.test.com/api/payments?client=7
Se debe enviar un parámetro y se espera un arreglo de objetos Payment correspondiente al cliente indicado

![image](https://user-images.githubusercontent.com/26363315/198379333-aee54d66-d01b-4cc0-86a6-b5992c689570.png)

3. Crear un pago en la plataforma
POST http://client-payments.test.com/api/payments
Hacemos una petición POST y registramos un pago con nuestros datos.
Se espera una respuesta 201, el registro asíncrono de exchange_rate y el envío del correo.

![image](https://user-images.githubusercontent.com/26363315/198380145-78a4bc63-7dbc-4a27-98e7-2651cec62d6d.png)

![image](https://user-images.githubusercontent.com/26363315/198380258-a995d4cc-71c2-44ff-986d-0e14ebf007b4.png)


