# Proyecto Symfony - prueba técnica

Este es un proyecto Symfony que utiliza Docker para facilitar el desarrollo y la ejecución del entorno.

## Pasos para levantar el proyecto:

1. **Ejecutar Docker Compose:**

   Para levantar el proyecto, ejecuta el siguiente comando en la raíz del proyecto:

   ```bash
   docker-compose up -d
   ```

   Esto iniciará los contenedores necesarios para ejecutar la aplicación Symfony y la base de datos.

### 2. Crear el Schema de la Base de Datos

    Una vez se hayan levantados los contenedores, crea el esquema de la base de datos con el siguiente comando:

    ```bash
    docker-compose exec php bin/console doctrine:schema:create
    ```

### 3. Agregar Datos de Muestra

    He creado una AppFixture para agregar datos de muestra a la base de datos. Para ejecutarlo, ejecuta el siguiente comando:

    ```bash
    docker-compose exec php bin/console doctrine:fixtures:load --no-interaction
    ```

Una vez los contenedores estén ejecutándose, el proyecto estará listo para ser usado. A través de la dirección http://localhost:8080 se puede acceder al proyecto.

Las principales funcionalidades, son:

1. Login
2. Registro
3. Crear un pedido
4. Gestionar producto

Se han creado dos roles, uno para administradores y otro para usuarios. Sólo los usuarios pueden gestionar productos. Uno de los users que se inserta como dato de muestra ya es un admin.

Las credenciales son:

admin: admines
