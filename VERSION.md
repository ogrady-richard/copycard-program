1.0.4
<ul><li>Minor GUI changes</li><li>Employee permission descriptions correctly show when adding new users<li>Colorized copy previews below customer table.</li><li>Removed unnecessary files.</li><li>New employees will be forced to update their passwords when they sign in the first time.</li><li>Added Customer Consolidation to the Admin Menu.</li><li>Working page now has session timeout alerts, and will automatically log them out after session expiration.</li><li>This box is a little longer to accommodate all updates.</li></ul>

# Version History

## 1.0.4
### August
- Colourized the copy previews below the customer table.
- Added (but not implemented) a customer consolidation button to the Admin menu.
- When adding new employees, the correct employee description will show up before processing.
- Changed the help desk button to not be so atrociously long, so it will fit better on small screens.
- New employees will be forced to reset their password on sign-in.
- Deleted extraneous file "addEmployee.php", which had no function.
- Added a Customer Consolidation table to mySQLCommands to handle user consolidations.
- Added an "Active" column to the Customers table on mySQLCommands to handle customer deactivation and consolidation.
- Added consolidateCustomers.php, to handle customer consolidation (incomplete).
- Updated mySQLCommands to reflect changes to Customer and Employee tables.
- Added session timeout alerts and automatic user logoff once a users session has expired.
- Added the current working version to the login page for at-a-glance version information.

## 1.0.3
### August 17, 2015
- Added version change alerts - will be modified to be version reminders on the CopyCard working page.
- Changed the order of the version display in VERSION.md - latest version will now appear at the top.
- Process Transaction window will now clear every time it is opened, preventing accidental garbage data errors.
- Customer tel. extensions now properly read and write in the database and on the customer information screen.
- Customer tel. numbers are formatted nicer for quicker reading.
- Minor formatting changes to the customer pdf generation page to account for business only accounts.

## 1.0.2
### August 14, 2015
- Fixed an IE compatibility issue when processing a transaction.
- Color copy fields are now colourful to quickly distinguish between black and white copies.
- Black and White copy fields fade to grey to quickly distinguish between color copies.
- Added Customer Telephone Extensions
- Customer fields now have correct created and modified data on their info screen.

## 1.0.1
### August 10, 2015
- Customer name is now optional when adding customers - the only required fields for adding a new customer are copies, per customer request.
- Receipt ID and Job Description are now optional, per customer request.

## 1.0.0
### July 22, 2015
- Copycard released. Future changes will be monitored here.

---

# To-do
- More styles. Top priority.
- Verify e-mails for new users before saving user to the database.
- Refresh users session timer when server requests are made to prevent erroneous user logout.
- Complete customer consolidation page.
- Verify users have the correct permissions before performing any server based task. Vulnerabilities everywhere.
- Check for existing customers when adding customers.
- Implement Remove User on the Admin Menu
- Option to generate history reports.
- Check for redundant CSS, make classes to correct (Ongoing)
- Logout page should tell user their session has been terminated, and they are logged out.
 - Also check to make sure there is no unsaved data.
- Allow employees to change their style.
- More informative error codes. Most are very generic.
- File-by-file spot checking. Syntax and formatting is all over the place. Try for consistency.
- More professional look.
- Password recovery option.
- Administrator info page for at-a-glance statistics (number of users, weekly transactions, so on.)
- Alert user when their session has expired.
- Folder and file organization.
- Check for open database connections and close them when finished (Ongoing).
- More exception handling - things can break with no feedback, and I need to know where and why.
- Start work on the README.md - it's still a mess.
- Clean up confusing variable names. 
- Implement a functions driver to simplify messy spots in code.
 - Permission checking especially. isAdmin() versus isset() and permission checks.
- Customer Page for copy card requests and customer account information.
- (Not in Git) Start adding information to the helpdesk Knowledgebase.
- Greater administrator control, to easily enable-disable features on the fly.
 - Optionality of Job Description, Business, etc. depending on settings.
- ... And so much more!
