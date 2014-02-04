## kkelly login with notes

PHP Toy repository for a centralized authentication service

---

The login service provides global session management for a single sign-on solution.  There are three main pieces: 1) the login page where sessions are started, 2) a private page visable to authenticated users only, and 3) a session resource that provides user information for a given session.

### The Login Page
Pretty simple.  Username, password, login.  The login page sets a "rzsession" cookie that other services can use as an authorization token.  `users.json` is the user store and any non-empty password is valid for a valid user name.
Upon successful login, a session is created for that user and the user sees the "private page" (see below).  Only one session is allowed per user; if a session is created for a user, any previous sessions are no longer valid.
If a user with a valid session visits the login page, they are not prompted to login.  Instead, they immediately see the private page.
>**Build Notes:**
>My login controller is contained in the php/getAccess.php file.  The user must provide a valid user name to gain access, password input, not being required, is ignored. non-valid names will display an error message.
>If the user returns to the login page and still has a session active, they'll be forwarded to their private page after seeing a brief notification
>I am setting cookies at login and removing them, along with session validation, at log out.  Not actually using them anywhere as I'm managing the access via subsequent pages.
>Half way through this I realized how nicely this would suit a single page application nicely but as it seemed more of a test of my session management ability over object oriented page building, I went with the multi-page approach.

### _Bonus:_ Redirection
The login page accepts a "redirect" parameter which is a percent encoded URL or relative path.  After successful login the user is redirected to the appropriate URL, rather than seeing the private page.
>**Build Notes:**
>A user can entry any url into the "Redirect" input and will be forwarded their upon successful login.  I don't validate the url as being well formatted or check that it's an existing url but could.  I didn't use PHP redirect and it's handled through a javascript handler in "js/session.js".
>I wanted to handle when the user clicks the back button gracefully, so a user logs in with a Redirect and gets the welcome message and then forwards to the requested URL.  If they hit the back button, their greeted with an appropriate message and forwarded to their private page.
>They can repeat that process as often as they like.  This is handled in "php/redirect.php" and I save state with a cookie for convenience.

### The Private Page
Only users with a valid session can access this page.  It's pretty boring, and just shows the session data (see below).  To make the users feel like authentication is something to be happy about, maybe there are some gratuitous hover effects.
>**Build Notes:**
>Added one of my JavaScript experiments for something to see on the page and random colors for the Role list.

### _Bonus:_ Logout
The private page has a method for logging out.  After logging out, the session is ended and the user must log in again.
>**Build Notes:**
>Logout clicker in the top right corner ends the session. removes the cookies and send the user back to the login page. I almost added a logout session invalidate on page unload but it's not really reliable and using a keep alive timer seemed a little too much for this.

### The Session Resource
The "session" consists of the user, their ip address, and the time the session was created.  Get requests to the session resource return the session data as json.  If the session id is not valid or does not exist, the session data is empty.  Other services use the session resource to access global session data.
>**Build Notes:**
>I'm actually keeping track of the session locally with the user name. It's unique and easy to manage.  Letting the server keep track of the session ID.  Otherwise the session data is displayed at the bottom of the private page

### Installation
Please complete this section with instructions on how to set up your application so that we can try it out.  We've got a variety of applications using Java, PHP, HTTPD, and Tomcat and are pretty comfortable in that space.  Outside of that, we could use some extra details!
>**Build Notes:**
>I wrote this in PHP, rather than Java, because it's so much faster to build, debug and deploy.
