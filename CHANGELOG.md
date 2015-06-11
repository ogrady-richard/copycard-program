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

### BUG FIXES
- Hovering over the customer table with no data no longer sends an error to the console.

## June 10th, 2015
- Stylesheet is now dynamically generated, requiring a single style.php file instead of many themed style.css documents.
- Altered the default style and bird style.
- Customer table is now partially generated with data from the CopyCardProgram database.
- New file getCustomers.php, which handles AJAX calls to the database to get customer information.
- Placeholder for remaining black/white copies implemented, and font color changed for debugging purposes.

## To-do:
- More styles. Top priority.
- Clean up the code, for goodness sake.
- Have new customer dialog close upon successful customer addition.
- Standardize the stylesheets, so a change in one reflects a change in all.
- Verify data before adding it to the table.
- Logout page should tell user their session has been terminated, and they are logged out.
- Implement permissions (add employees)
- Allow employees to change their password.
- Allow employees to change their style.
- Alert user about successful logout, and check to make sure there is no unsaved data.
- Implement session timeout.
- Folder and file organization.
- Write customer information to the database.
- ... And so much more!