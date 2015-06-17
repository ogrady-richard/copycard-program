# Change Log

## May 27th, 2015
- Updated README.md, but it is a little too crazy. Consider moving some of README to documentation, and start documenting more.
- Added mySQLCommands, which can be passed to mySQL to generate the necessary tables.
- Updated mySQL Database to include all tables, as opposed to just Employees.
- Fixed login.php script, which will now successfully authenticate users and send them to the Copy Card Program page.
 - Session issuing has not yet been implemented. Next update, perhaps!
- mySQL Database tables now have functioning Foreign Keys.

## June 2nd, 2015
- Updated README.md, still need to revise it to be an appropriate README.
- Very preliminary session implementation. User's name is passed to the interface page, but permissions have not yet been implemented.
 - To utilize sessions, cc.html has been altered to be cc.php
- Made some modifications to the default CSS stylesheet. A rework of the file, with additional classes, will be necessary.
- Added very basic user style implementation using the default style and a new red theme. And a bird theme.
- Enter will now work for login form submissions.

## June 8th, 2015
- Login link added to the cc.php page, allowing users to logout.
- Logout page implemented.
- Attempting to view access-restricted pages will result in an error.
- Add New Customer button implemented (JS Only - no DB Support yet)
- Hovering over the customer table with no data no longer sends an error to the console.

## June 10th, 2015
- Stylesheet is now dynamically generated, requiring a single style.php file instead of many themed style.css documents.
- Altered the default style and bird style.
- Customer table is now partially generated with data from the CopyCardProgram database.
- New file getCustomers.php, which handles AJAX calls to the database to get customer information.
- Placeholder for remaining black/white copies implemented, and font color changed for debugging purposes.

## June 11th, 2015
- Added a placeholder PHP file placeholder.php, to stand in for admin pages not yet developed.
- Beautified the following files, because it was just getting chaotic:
 - 401.php, addEmployee.php, copyCardTemplate.php, copyCard.js, login.js
- Implemented "Black and White" and "Color" copy fields for customers on mouseover.
- Changed 404.php to 401.php, like it should have already been.
- New file addCustomer.php, which successfully adds customers to the database.
- New customer dialog will now close no matter how data is submitted (Enter key vs. button.)
- Adding a customer will now create an entry in the history database table.
- Links (inoperable currently) to alter style, change password, and access the admin menu now on the working page.
- Changed mySQLCommands to use Employee ID's in history, instead of names, for easier foreign key linking.

June 16th, 2015 (History Update)
- Implemented a history log, which can be accessed with admin level accounts.
 - Uses data/getHistory driver and history-transaction page to display history.
- Permissions implemented but not optimized. Many pages will now refuse access without valid login.
- mySQLCommands file will now build a stand-in admin account for immediate use.
- Cell borders around tables to improve readability.
- (Not in Git) Added a helpdesk (Thanks, [osTicket](http://osticket.com/)!).
- Data is now verified when a user tries to add a new customer.
- CHANGELOG.md now has snapshot update information (wow!)

## To-do:
- More styles. Top priority.
- Add a link to the helpdesk.
- Make dates more intuitive  for searching in history DataTable
- Option to destroy temporary admin account in Admin menu.
- Option to add a new employee from the Admin menu.
- Stop using IDs for styles, start implementing classes instead.
- Replace permission integers with human-readable equivalents.
- Implement helpdesk support - allow users to open tickets.
- Logout page should tell user their session has been terminated, and they are logged out.
 - Also check to make sure there is no unsaved data.
- Allow employees to change their password.
- Allow employees to change their style.
- More informative error codes. Most are very generic.
- File-by-file spot checking. Syntax and formatting is all over the place. Try for consistency.
- More professional look.
- Administrator info page for at-a-glance statistics (number of users, weekly transactions, so on.)
- Implement custom session timeout.
- Folder and file organization.
- Add Daily Manifest with transaction history for the copy card.
- Check for open database connections and close them when finished.
- More exception handling - things can break with no feedback, and I need to know where and why.
- Start work on the README.md - it's still a mess.
- Clean up confusing variable names. 
- Generate a printable date-range manifest with specific transaction information (user, date, quantity, etc.)
- Start crossing things off the changelog as they are completed.
- Implement a functions driver to simplify messy spots in code.
 - Permission checking especially. isAdmin() versus isset() and permission checks.
- Customer Page for copy card requests and customer account information.
- Printable backup copy cards.
- ... And so much more!
