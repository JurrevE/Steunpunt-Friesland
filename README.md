## Before usage run these lines in the terminal:
1. php artisan serve
2. Hopefully it works
3. Go to (http://127.0.0.1:8000/admin/login)
4. Login using the credentials:
    - email: admin@admin.nl
    - password: admin

# Steunpunt Friesland Filter tool
Writen by: Egbert Ludema
Build by: Iwan Bijl, Jurre van Eijk, Egbert Ludema
Designed by: Yaron Piest, Amber Kroes

## Introduction
For our school project, we were given the task by Steunpunt Friesland to find a solution for their problem.

### Problem:
Steunpunt Friesland needs to find care/shelter locations daily for children who struggle in regular education. Currently, there are more than 200 locations in Friesland and Steunpunt Friesland mainly works with an Excel file and a map with pin points.

### Wishes
- An application that does not require an IT professional
- Export all locations to a excel sheet

### Solution:
The solution quickly became clear. An advanced filtering system was needed. It was initially unclear if a map was required or not. After several test sessions, it quickly became clear that a map was not necessary.

Ultimately, we set up a filtering system and are currently working on adding one more filter to complete it.

Current filters:
- Under 15
    - Yes
    - No
    - All
- Sectors
    - Able to select multiple sectors
    - Shows all items containing one or more selected sectors
- Name
    - Search
    - Sort
- Location
    - Search
    - Sort

The filter we want to add, and are currently working on:
- Radius for location
    - Currently, when you filter by location, it leaves out all other locations surrounding the selected location. Also, some children in need of help live in villages without any locations. Therefore, the radius filter is a must-have.

### Application
Currently we have a login screen, 2 users and 4 screen.

For this project we used the <a href="https://tallstack.dev/" target="_blank">TALL</a>(Tailwind css, Angular, Laravel, Livewire) stack. On top of the stack we added the <a href="https://filamentphp.com" target="_blank">Filament package</a>. On top of all that we used the <a href="https://filamentphp.com/plugins/pxlrbt-excel" target="_blank">Excel export</a> function from <a href="https://github.com/pxlrbt" target="_blank">Dennis Koch</a>

#### Login screen
This is the default login screen of Filament with minor changes like a logo and color changes.

#### Users
- Admin
    - This user has the role "Admin" in the database and has acces to all panels.
- Viewer
    - THis user has the role "Viewer" in the database and has acces to the dashboard and locations panels.

### Panels
#### Dashboard
The dashboard shows some statistics and has a logout button

#### Locations
The locations screen is the main screen for this application. This is the screen used for searching a locations, making use out of the filters described earlier.

#### Edit locations
This screen is for admins only. On this screen you have the same filter function, but you can now edit, add or remove locations.
On this screen the admin(s) are able to export all locations at once, or select as many locations as they want, and export all selected locations to a Excel sheet.

#### Edit sectors
Each location has their own sectors(or no sectors). The edit sectors screen is also for admins only. On this screen admins are able to edit, add or remove sectors.

<hr>

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
