ENGINEERING
===========
This is an stack file, append here at the top.

# Sprint 0: Understanding the Problem

## 1. Extracting the text from pdf with `GostScritp`

```sh
gs -sDEVICE=txtwrite -o RunWeb-DesenvolvedorWeb.pdf.txt RunWeb-DesenvolvedorWeb.pdf
```

## 2. Tecnology Stack

> - Docker, Docker-compose
> - PHP, Laravel Framework 5.6
> - PostgreSQL or MySQL
> - Bootstrap front-end framework or Material Design
> - Ajax
> - CSS3 using Sass
> - Javascript
> - Translation keys
> - Unit tests

My experience covers it all, except by the assumed use of the blade templating engine
provided with laravel. I have never before used it and integrating CSS, SASS, Material and l10n (localization) may be hard.

As for the base, [Laradock](http://laradock.io/) seems to be the way to go.

## 3. Problem Scope

To quote directly:
> Application for managing music albums.

### Entities

The entities involved as follow.
- Artist
  - Name
  - Image
  - Genre
  - Description
- Album
  - Cover photo
  - Name
  - Year
- Song
  - Name
  - Duration
  - Composer
  - Order number
- User
  - Name
  - Email address
  - Image
  - Password
  - Admin permissions

### Operations

#### CRUD
Those entities will need CRUD operations as described:
- **C:** Create (Register)
- **R:** Read (View)
- **U:** Update (Edit)
- **D:** Delete (Remove)
- Index (List)

Other miscellaneous operations are:
#### Search
Provided an search string or search term, returns Artist, Album or Song.

#### Authentication (AuthN)
Provided an email and password returns an user and session token.

### Authorization (AuthZ)

Access to operations will be controlled by three roles, each widening the access: Public, User and Administrator.

For the [Search](#Search) and [AuthN (infered)](#authn) operations, the access will be Public.

| Entity        | Index     | Read      | Create    | Update    | Delete    |
|---------------|-----------|-----------|-----------|-----------|-----------|
| **Artist**    | Public    | Public    | User      | User      | User      |
| **Album**     | Public    | Public    | User      | User      | User      |
| **Song**      | Public    |           |           |           |           |
| **User**      | Admin<sup>[1](#n1) | User<sup>[1](#n1) | Admin | Admin | Admin |
<a name="n1">1</a>: Operation not described in the original request, but infered.
