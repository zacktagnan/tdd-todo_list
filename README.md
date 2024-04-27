# Sobre tdd-todo_list

Tratando de ir implementando un proyecto básico para la gestión de un listado de tareas aplicando la técnica del TDD (Test Driven Development).

- Según se vayan recibiendo errores en los tests establecidos, se irá desarrollando lo necesario para pasar dichos tests.

- Una vez todos los tests pasados relativos a todas las posibles funcionalidades de la aplicación, es cuando se podrá pasar a la refactorización del código. Siempre respetando lo establecido en los tests.

El proyecto de *Laravel* se creará con el comando de CuRL, en este caso, a través de la terminal de WSL2 de Windows, para poder gestionarlo a través de **[Laravel Sail](https://laravel.com/docs/11.x/sail)** durante el desarrollo local.

## Xdebug en el Proyecto

Al menos, desde las últimas versiones de *Laravel Sail*, **[Xdebug](https://xdebug.org/)** ya se encuentra preinstalado cuando se crea el proyecto tal y como se indicó anteriormente.<br>
Para verificar esto, teniendo arrancado los contenedores mediante *Sail* por la terminal (`sail up -d`), bastaría con lanzar este comando que debería mostrar tanto la versión de PHP empleada en el proyecto, como la versión de Xdebug disponible:

    sail php -v

No obstante, será necesario efectuar ciertas configuraciones adicionales. Una de ellas es disponer de una configuración para el DEBUG dentro del archivo "./.vscode/launch.json" del proyecto.

Un ejemplo de su contenido se puede encontrar en este **[GIST](https://gist.github.com/zacktagnan/b436eea3d3a3cf69ccee263b821591b7)**.

Otro complemento que puede ayudar a la ejecución del DEBUG dentro del proyecto a nivel del navegador es tener instalada una extensión como la de **Xdebug helper** (disponible, al menos, en *Google Chrome* y en *Firefox*).
