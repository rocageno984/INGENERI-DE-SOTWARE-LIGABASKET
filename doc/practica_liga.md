# Documentación Técnica Maestra: Sistema de Liga de Básquetbol (20 Puntos Clave)

Esta documentación es el compendio total y exhaustivo del proyecto. No se ha omitido ningún detalle técnico para garantizar la total comprensión del sistema.

---

## 1. Introducción y Filosofía MVC

El sistema utiliza el patrón **Modelo-Vista-Controlador (MVC)**. Esta arquitectura separa los datos (Modelo), la interfaz (Vista) y la lógica de control (Controlador), permitiendo que el sistema sea escalable y fácil de mantener. Cada petición del usuario pasa primero por el controlador, que decide qué datos pedir al modelo y qué vista mostrar.

**Detalles Adicionales:** Esta separación de responsabilidades asegura que los cambios en la interfaz de usuario no afecten la lógica de negocio subyacente. El flujo de datos es unidireccional: la solicitud llega al Controlador, este interactúa con el Modelo para obtener información de la base de datos y, finalmente, entrega esos datos a la Vista para su representación visual. Esto facilita el trabajo colaborativo y la implementación de pruebas unitarias en el futuro.

## 2. Requisitos y Entorno (XAMPP)

El sistema está optimizado para ejecutarse en entornos **Apache/MySQL**.

- **PHP:** Versión 8.0 o superior.
- **Servidor:** Apache con `mod_rewrite` habilitado (para URLs amigables).
- **Base de Datos:** MySQL / MariaDB con motor InnoDB para soportar relaciones de llaves foráneas.

**Detalles Adicionales:** Se utiliza un archivo `.htaccess` en la raíz para redirigir todas las peticiones a `public/index.php`, lo que actúa como un Front Controller. Esta configuración es vital para la seguridad, ya que impide que los usuarios naveguen directamente por las carpetas del sistema. Además, el motor InnoDB garantiza la integridad referencial de los datos mediante el uso de transacciones y restricciones de clave externa entre equipos, jugadores y partidos.

## 3. El Enrutador Maestro (`Core.php`)

Ubicado en `app/core/`, este archivo es el punto de entrada. Captura la URL, la limpia de caracteres especiales y la divide:

```php
// Ejemplo: dominio.com/matches/edit/5
// Controlador: matches | Método: edit | Parámetro: 5
```

Si el controlador no existe, carga uno por defecto para evitar errores 404 internos.

**Detalles Adicionales:** El enrutador utiliza la función `filter_var(..., FILTER_SANITIZE_URL)` para prevenir ataques de inyección a través de la URL. Una vez identificado el controlador y el método, utiliza `call_user_func_array` para ejecutar la lógica correspondiente pasando los parámetros extraídos. Esto permite una flexibilidad total en la gestión de rutas dinámicas sin necesidad de configurar cada ruta manualmente.

## 4. La Clase Base `Controller.php`

Es la clase "padre" de todos los controladores. Proporciona dos métodos vitales:

- **`model($model)`**: Carga el archivo del modelo solicitado y devuelve una instancia del mismo.
- **`view($view, $data)`**: Verifica si la vista existe y la carga, permitiendo inyectar el array `$data` que contiene toda la información dinámica.

**Detalles Adicionales:** El método `view` utiliza la función `extract($data)` internamente. Esto transforma las llaves del array asociativo en variables independientes (ej: `['title' => 'Inicio']` se convierte en `$title`), permitiendo que el código en la vista sea mucho más limpio y legible. Además, esta clase centraliza la lógica de carga para asegurar que todos los controladores tengan acceso uniforme a los recursos del sistema.

## 5. El Motor de Datos `Database.php`

Implementa **PDO (PHP Data Objects)**. Sus funciones clave son:

- **`query($sql)`**: Prepara la consulta.
- **`bind($param, $value)`**: Vincula los valores de forma segura, evitando **Inyección SQL**.
- **`resultSet()`**: Devuelve múltiples registros como objetos.
- **`single()`**: Devuelve un único registro.

**Detalles Adicionales:** El uso de PDO permite que el sistema sea independiente de la base de datos subyacente. Se manejan errores mediante excepciones para capturar fallos de conexión o sintaxis SQL sin exponer información sensible al usuario final. La vinculación de parámetros (`bind`) asegura que cualquier dato proveniente del usuario sea tratado como texto plano, neutralizando cualquier intento de ejecución de código malicioso en la base de datos.

## 6. Configuración Global (`config.php`)

Centraliza las constantes del sistema:

- `DB_HOST`, `DB_USER`, `DB_PASS`, `DB_NAME`: Credenciales de la base de datos.
- `URL_BASE`: La ruta raíz (ej: `http://localhost/basquet-liga/`), esencial para que los enlaces y assets carguen correctamente en cualquier servidor.
- `APP_NAME`: El título global de la aplicación.

**Detalles Adicionales:** Este archivo actúa como el panel de control técnico del proyecto. Al centralizar la `URL_BASE`, evitamos el uso de rutas relativas que fallan al mover el proyecto entre entornos de desarrollo y producción. También define constantes para las rutas de los directorios de la aplicación (`APPROOT`) y del sitio (`SITEROOT`), facilitando la inclusión de archivos de forma absoluta y eficiente.

## 7. Controlador de Partidos: Lógica de Fases

El controlador `Matches.php` no solo guarda datos, sino que categoriza los encuentros. Implementa lógica para diferenciar entre partidos de **Temporada Regular** y los de eliminación directa (**Octavos, Cuartos, Semis, Final**), lo cual es crucial para el funcionamiento del árbol de play-offs.

**Detalles Adicionales:** Cada partido tiene un campo `fase` en la base de datos. El controlador valida que un partido de play-off solo pueda crearse si los equipos participantes han avanzado legalmente en la fase previa. Además, gestiona la actualización de estados de los partidos (programado, en curso, finalizado), lo que permite filtrar visualmente los encuentros en el calendario y la tabla de posiciones.

## 8. Controlador de Equipos: Gestión de Cards

En `Teams.php`, el método `index` recupera no solo los equipos, sino también una vista previa de sus jugadores (`players`). Esto permite que cada tarjeta (Card) de equipo muestre un resumen visual de su plantilla sin necesidad de recargar la página.

**Detalles Adicionales:** Se implementa una carga eficiente de datos para evitar el problema de consultas N+1. Al obtener los equipos, el sistema también calcula el número total de integrantes y el promedio de puntos del equipo. Las "Cards" en la vista están diseñadas para ser responsivas, utilizando CSS Grid para reorganizarse según el tamaño de la pantalla, manteniendo siempre una estética profesional y limpia.

## 9. Controlador de Jugadores: Planteles y Posiciones

El controlador `Players.php` gestiona la relación 1:N (Un equipo tiene muchos jugadores). Permite asignar:

- **Número de Camiseta:** Validado para que no se repita (opcional).
- **Posición Técnica:** Mapeada para ser usada en reportes tácticos (Base, Escolta, Alero, Ala-Pívot, Pívot).

**Detalles Adicionales:** Incluye lógica de validación del lado del servidor para asegurar que los datos ingresados sean correctos (ej: que el número de camiseta sea positivo y que el equipo asignado exista). También facilita la transferencia de jugadores entre equipos, manteniendo un historial de cambios. La gestión de posiciones permite generar estadísticas específicas por rol, ayudando a los entrenadores a analizar el rendimiento de su plantilla.

## 10. Controlador de Estadísticas: El Cerebro del Torneo

`Stats.php` es el controlador más pesado. Realiza dos llamadas principales:

1. Pide al modelo la tabla de posiciones calculada.
2. Recupera todos los partidos de eliminación y los agrupa en un array jerárquico para que la vista pueda "dibujar" las llaves del torneo.

**Detalles Adicionales:** El controlador procesa los datos en bruto de la base de datos para transformarlos en una estructura de "Bracket" (llaves) que JavaScript pueda interpretar fácilmente. Calcula automáticamente quién avanza a la siguiente ronda basándose en los resultados de los partidos de play-off. Esta automatización reduce errores humanos y garantiza que la información mostrada sea siempre el reflejo fiel de la base de datos en tiempo real.

## 11. Controlador de Usuarios: Seguridad y Hash

`Users.php` implementa el flujo de autenticación:

- **Registro:** Usa `password_hash($password, PASSWORD_DEFAULT)` para guardar la clave cifrada.
- **Login:** Usa `password_verify($password, $user->password)` para validar al usuario.
- **Sesión:** Almacena el `user_id` en `$_SESSION` para proteger las rutas administrativas.

**Detalles Adicionales:** Se implementan medidas de seguridad como la regeneración de IDs de sesión en el login para prevenir el secuestro de sesiones. El controlador también redirige automáticamente a los usuarios no autenticados cuando intentan acceder a rutas protegidas (como `/matches/add`). Las contraseñas nunca se almacenan en texto plano, lo que garantiza que incluso en caso de una filtración de base de datos, la información de los usuarios permanezca segura.

## 12. Modelo `Match`: Consultas con JOINs

Para mostrar los partidos, no basta con IDs. El modelo `Match.php` usa `INNER JOIN` para traer los nombres reales de los equipos:

```sql
SELECT p.*, e1.nombre as equipo_local, e2.nombre as equipo_visitante
FROM partidos p
INNER JOIN equipos e1 ON p.equipo_local_id = e1.id
INNER JOIN equipos e2 ON p.equipo_visitante_id = e2.id
```

**Detalles Adicionales:** Estas consultas optimizadas permiten obtener toda la información necesaria de una sola vez, mejorando el rendimiento del servidor. El modelo también incluye métodos para filtrar partidos por fecha, fase o equipo específico. Se utilizan alias en SQL (`as equipo_local`) para evitar conflictos de nombres de columnas y hacer que el acceso a los datos en PHP sea intuitivo (`$match->equipo_local`).

## 13. Modelo `Team: El SQL Maestro de Puntos FIBA`

Este modelo contiene el cálculo matemático que define la liga:

- **Victoria:** +2 puntos.
- **Derrota:** +1 punto.
- **Diferencia (DIF):** Puntos a Favor (PF) - Puntos en Contra (PC).
- **Orden:** Primero por Puntos (PTS), luego por Diferencia (DIF).

**Detalles Adicionales:** El cálculo se realiza dinámicamente mediante una consulta SQL compleja que suma los resultados de todos los partidos jugados. Se tiene en cuenta si el equipo jugó como local o visitante para calcular correctamente los puntos anotados y recibidos. Este enfoque "on-the-fly" asegura que la tabla de posiciones esté siempre actualizada sin necesidad de procesos de sincronización manuales o almacenamiento de datos redundantes.

## 14. Modelo `User`: Validación de Credenciales

Responsable de la persistencia de usuarios. Su método `findUserByEmail` es la primera línea de defensa durante el login para verificar si una cuenta existe antes de intentar validar la contraseña.

**Detalles Adicionales:** El modelo también gestiona la creación de nuevos usuarios y la actualización de perfiles. Implementa verificaciones de unicidad para el correo electrónico durante el registro, evitando duplicados. Al separar la lógica de base de datos en este modelo, el controlador `Users.php` se mantiene limpio y enfocado únicamente en gestionar el flujo de la solicitud y la respuesta.

## 15. Vistas de Layout: Estructura Modular

Ubicadas en `app/views/layouts/`, permiten que el `header.php` (con el CSS) y el `footer.php` (con el JS) sean los mismos en todo el sitio. Esto garantiza que si cambias un enlace en la barra de navegación, el cambio se refleje en toda la aplicación instantáneamente.

**Detalles Adicionales:** Se utiliza un sistema de "vistas anidadas" donde la página principal de cada sección se carga entre el header y el footer. Esto promueve el principio DRY (Don't Repeat Yourself), facilitando enormemente el mantenimiento del diseño global. Además, el `header.php` incluye de forma dinámica etiquetas meta para SEO y títulos de página personalizados, mejorando la visibilidad del sistema en buscadores.

## 16. Vista de Calendario: Lógica de Pestañas y JS

En `matches/index.php`, se utiliza un sistema de **Pestañas (Tabs)** manejado por JavaScript. Permite alternar entre una vista de lista tradicional y un **Calendario Mensual** visual, donde cada día muestra los partidos programados con su hora y marcador.

**Detalles Adicionales:** El calendario se renderiza dinámicamente, calculando los días del mes actual y posicionando los partidos en sus respectivas celdas. Se utilizan clases CSS específicas para resaltar el "Día de Hoy". Esta funcionalidad proporciona una experiencia de usuario mucho más rica que una simple lista, permitiendo visualizar la carga de partidos de un vistazo y planificar la logística del torneo con mayor claridad.

## 17. Vista de Play-offs: El Árbol Dinámico

La vista `stats/index.php` genera el árbol de eliminación.

- Si un partido de la fase final termina, la vista detecta al ganador y le pone una **Corona (`fa-crown`)**.
- Implementa una animación de resplandor (`glow`) para el campeón final del torneo.

**Detalles Adicionales:** El diseño del árbol utiliza CSS Flexbox para alinear perfectamente las conexiones entre las diferentes fases (Octavos, Cuartos, etc.). Los cables o líneas de conexión son elementos visuales dinámicos que cambian de color cuando se determina un ganador. Esta representación visual de la competencia aumenta el "engagement" de los usuarios y otorga al sistema un aspecto de plataforma profesional de alta competición.

## 18. Sistema de Notificaciones `Flash Messages`

Ubicado en `app/helpers/session_helper.php`, permite enviar alertas entre páginas:

```php
flash('registro_exito', '¡Te has registrado correctamente!');
```

La alerta aparece una sola vez y se borra automáticamente al recargar, mejorando la experiencia del usuario.

**Detalles Adicionales:** Estas notificaciones son cruciales para el feedback del usuario (ej: "Equipo eliminado con éxito", "Error al guardar partido"). El helper gestiona tanto el mensaje como la clase CSS de la alerta (success, danger, info), permitiendo que el sistema se comunique de forma visualmente coherente. Se integra perfectamente con los estilos de la aplicación para aparecer como un "Toast" elegante en la parte superior de la pantalla.

## 19. Diseño CSS: Variables, Glassmorphism y Dark Mode

El archivo `public/css/style.css` utiliza variables modernas:

- `--primary`: Naranja intenso para acciones.
- `--surface`: Gris azulado para las tarjetas.
- **Glassmorphism:** Los modales usan `backdrop-filter: blur(10px)` para ese efecto de cristal translúcido premium.

**Detalles Adicionales:** El diseño es "Mobile First", asegurando una navegación fluida en smartphones y tablets. Se utilizan transiciones CSS para efectos de "hover" suaves en botones y enlaces. La paleta de colores está cuidadosamente seleccionada para reducir la fatiga visual, utilizando contrastes altos para los textos importantes y sombras sutiles para dar profundidad a la interfaz, logrando un acabado estético de primer nivel.

## 20. JS Interactivo: Modales y Comportamiento del Cliente

El archivo `public/js/main.js` centraliza la interactividad:

- Controla la apertura y cierre de modales de forma suave.
- Gestiona el cambio de pestañas sin recargar la página.
- Implementa confirmaciones antes de eliminar registros importantes.

**Detalles Adicionales:** El código JavaScript utiliza las últimas características de ES6+, como funciones de flecha y plantillas de cadena. Se implementa "Event Delegation" para manejar eventos en elementos creados dinámicamente, lo que mejora la eficiencia del navegador. Además, se incluyen pequeñas animaciones de entrada para los elementos de la interfaz, haciendo que la aplicación se sienta "viva" y receptiva a las acciones del usuario.

---

## Árbol de Carpetas del Proyecto

A continuación se presenta la estructura jerárquica del sistema para facilitar la navegación entre los archivos del núcleo, la lógica y la interfaz:

```text
Basquet
|   .htaccess               # Configuración de Apache para URLs amigables
|   readme.md               # Instrucciones básicas del proyecto
|
+---app                     # Carpeta principal de la aplicación (Lógica MVC)
|   +---config
|   |       config.php      # Variables globales y credenciales de BD
|   |
|   +---controllers         # Manejadores de las peticiones del usuario
|   |       Home.php        # Controlador de la página de inicio
|   |       Matches.php     # Gestión de partidos y fases
|   |       Players.php     # Gestión de jugadores y plantillas
|   |       Stats.php       # Cálculo de tabla y árbol de play-offs
|   |       Teams.php       # Gestión de equipos y sus visualizaciones
|   |       Users.php       # Autenticación y registro de usuarios
|   |
|   +---core                # El motor interno del framework
|   |       Controller.php  # Clase base para todos los controladores
|   |       Core.php        # Enrutador principal (Front Controller)
|   |       Database.php    # Capa de abstracción de datos (PDO)
|   |
|   +---helpers             # Funciones de utilidad global
|   |       session_helper.php # Manejo de sesiones y mensajes flash
|   |       url_helper.php     # Redirecciones y manejo de URLs
|   |
|   +---models              # Interacción directa con la base de datos
|   |       Match.php       # Consultas relacionadas con partidos
|   |       Player.php      # Consultas relacionadas con jugadores
|   |       Team.php        # Lógica de puntos y tabla de posiciones
|   |       User.php        # Validación y persistencia de usuarios
|   |
|   \---views               # Interfaz de usuario (HTML/PHP)
|       +---home            # Vistas de la sección de inicio
|       +---layouts         # Estructuras comunes (Header, Footer, Navbar)
|       +---matches         # Vistas para CRUD de partidos y calendario
|       +---players         # Vistas para gestión de jugadores
|       +---stats           # Vistas de estadísticas y llaves del torneo
|       +---teams           # Vistas para gestión de equipos
|       \---users           # Formularios de login y registro
|
+---database                # Archivos de respaldo de la base de datos
|       db.sql              # Estructura inicial de tablas
|       cambios.sql         # Registro de modificaciones en el esquema
|
+---doc                     # Documentación técnica del proyecto
|       practica_liga.md    # Este archivo de documentación maestra
|
\---public                  # Directorio raíz accesible desde la web
    |   .htaccess           # Redirección al Front Controller
    |   index.php           # Punto de entrada de todas las peticiones
    |
    +---css                 # Hojas de estilo (Diseño Premium)
    |       style.css       # Estilos globales y efectos visuales
    |
    +---img                 # Recursos gráficos y multimedia
    |       cancha.svg      # Gráficos tácticos de básquetbol
    |
    \---js                  # Lógica del lado del cliente
            main.js         # Interactividad principal y modales
            toast.js        # Sistema de notificaciones emergentes
```

---
