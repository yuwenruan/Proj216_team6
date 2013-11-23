Threaded Project:  PHP/mySQL Prototype WebSite    23 Nov 2013
PROJ216/CPRG207    Team 6:
                     George Chacko
                     Yu Wen Ruan
                     Parker Smith
                     Paul Milligan

***IMPORTANT:
  1. Testing requires importing the provided database script:
                 TravelExperts-v2.sql
        (Note: an alert is displayed if the database is not correct.)

  2. Please test using Google Chrome or Firefox.
	Internet Explorer does not support needed features.

  3. We feel we have all contributed equally to the presentation
         and WebSite implementation (design, coding, testing, etc).


Regarding testing:

  Logging in:
    -there is an agent with  user name: janet
                              password: janet
    -there is a customer with  user name: judy.sethi
                                password: judy
    -when a new customer is registered their information is inserted in the
       customer table and their user name & password are inserted in the user table
	   therefore, they will be logged in and they will be able to login in the future

  Ordering which leads to booking:
    -clicking the order button remembers the selected package then proceeds as follows
    -if a "logged in customer" clicks an order button then
       then go directly to the booking page where they complete the booking
       and when they click the booking button, a row is inserted in the database
    -if a "logged in agent" clicks an order button then
       it is the same as above except they also select the customer from a drop down
    -if the user is not logged in then the order button takes them to the login page
       after they login they go to the booking page
    -if a customer has not registered then they will not be able to log in
       therefore they can click the register button
	   after registering they will be logged in and go to the booking page

---------------------------------------------------------------------------------

Implemented featuers:
  -main page slide show:
    -progression is displayed in bottom left with little squares
	-clicking a progression square stops the show at that slide
	-after it has been stopped clicking the arrow restarts it
        -clicking the order button proceeds as described in previous section
  -contact page:
    -sending email requires server configuration so not implemented
  -registration page:
    -checks for missing fields; also checks postal code & email address
    -if preceeded by clicking order button then completing registration goes to booking page
  -login page:
    -login is case sensitive; register button allows new customers to register
  -if an agent is logged in then the following pages are available:
    -agent managemant page: supports creating, displaying, updating and deleting
       -agent can only be deleted if they are not assigned any customers
    -customer management page: supports displaying customers one screen at a time
    -supplier management page: is not implemented
    -report generation page: displays two simple sample reports
  -ordering leading to booking is described above
