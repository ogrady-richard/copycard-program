# ZhongNet Copy Card Program

All the essential files for the ZhongNet Small Business Copy Card Program.

| File                      | Description                                    |
| ------------------------- | ---------------------------------------------- |
| * README.md               | You are here.                                  |
|  _./vendors/_             | ##                                              |
| jquery-ui-1.11.4/         | [JQueryUI](https://jqueryui.com/) Resources    |
| jquery.dataTables.min.js  | [DataTables](http://datatables.net/) Resources |
| jquery.dataTables.min.css | [DataTables](http://datatables.net/) Resources |
| _./resources/_            | ##                                              |
| index.html                | Index Page                                     |
| cc.html                   | Copycard Interface Page                        |
| favicon.ico               | Webpage Favcion                                |
| _css/_                    | #                                              |
| _default-theme_           | #                                              |
| style.css                 | Default Webpage Theme Stylesheet               |
| _data/_                   | #                                              |
| login.php                 | Login Processing (Server-side)                 |
| _images/_                 | #                                              |
| sort_*.png                | DataTables Sort Priority Icons                 |
| _js/_                     | #                                              |
| login.js                  | Login Processing (Server-side)                 |

## About the mySQLCommands File

This is the file that will build or rebuild the database. *Running this file will destroy the existing database! Please backup all database files before attempting to execute this file through mySQL.*

This file will clear the CopyCardProgram database, and rebuild it with the following tables:

| Table Name          | Description                                                                        |
| ------------------- | ---------------------------------------------------------------------------------- |
| AuthorizedUsers     | Contains information on all users tied to a primary customer file.                 |
| Customers           | Holds all primary customer information.                                            |
| EmployeePermissions | A pairing of employees and their permissions regarding the program.                |
| Employees           | Contains information on all the employees authorized to use the copy card program. |
| History             | A running log of all customer transactions and account modifications.              |
| Permissions         | A list of permissions, with a description of each permission.                      |
| Sessions            | The server session file, to keep track of individual employee logins.              |

## Error codes

* ERR100
  * | Server Error. A database AJAX call has failed. Please check the servers connection to the mySQL database, refresh the page, and try again.
* ERR200
  * | User error. One or more required fields are left blank. Advise user to check input before trying their command again.
* ERR300
  * | User Error. The user has submitted their username or password incorrectly. Advise user to check their credentials before attempting to login again.