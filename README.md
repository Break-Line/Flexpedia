# Flexpedia Invoice Manager
### The goal of the program was:

_Without using a PHP framework or third party packages of any sort, build a PHP application that connects to the provided database and allows it's users to perform the following tasks:_

- List the invoices from the database table into an HTML paginated table, having 5 records per page.
- Export the transactions as a **CSV** file. The export should be in the following format:
(Invoice ID | Company Name | Invoice Amount)
- Export a **CSV** Customer Report. The export should be in the following format:
(Company Name | Total Invoiced Amount | Total Amount Paid  | Total Amount Outstanding)
- Set the payment status of each invoice via the interface to paid / unpaid. 

I created the application using XAMPP with PHP 7 and MySQL database. 
To start the application, load the _"**database.sql**"_ file in your new database called _"**exercise_fp**"_. Then you can start the application from **localhost / myfolder / index.php** from your browser and click on "**Home**" button.
