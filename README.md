# HelpDesk PHP

Sistema web de gestión de incidencias TI desarrollado como proyecto de portafolio.

El proyecto permite registrar y administrar incidencias de soporte utilizando PHP y una base de datos MySQL/MariaDB.

## Funcionalidades actuales

- Crear incidencias.
- Listar incidencias registradas.
- Editar incidencias.
- Eliminar incidencias.
- Asignar prioridad.
- Gestionar estados de las incidencias.
- Validación básica de formularios.
- Persistencia de información en MySQL/MariaDB.

## Tecnologías

- PHP
- MySQL / MariaDB
- PDO
- HTML
- Git
- GitHub

## CRUD implementado

| Operación | Estado |
| --------- | ------ |
| Create    | ✅     |
| Read      | ✅     |
| Update    | ✅     |
| Delete    | ✅     |

## Estructura actual

```text
helpdesk-php/
├── config/
│   └── database.php
│
├── public/
│   ├── index.php
│   ├── edit-ticket.php
│   └── delete-ticket.php
│
├── src/
├── .gitignore
└── README.md
```
