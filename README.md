## login

Toy repository for a centralized authentication service

---

The login service provides global session management for a single sign-on solution.  There are three main pieces: 1) the login page where sessions are started, 2) a private page visable to authenticated users only, and 3) a session resource that provides user information for a given session.

### The Login Page
Pretty simple.  Username, password, login.  The login page sets a "rzsession" cookie that other services can use as an authorization token.  `users.json` is the user store and any non-empty password is valid for a valid user name.

Upon successful login, a session is created for that user and the user sees the "private page" (see below).  Only one session is allowed per user; if a session is created for a user, any previous sessions are no longer valid.

If a user with a valid session visits the login page, they are not prompted to login.  Instead, they immediately see the private page.

#### _Bonus:_ Redirection
The login page accepts a "redirect" parameter which is a percent encoded URL or relative path.  After successful login the user is redirected to the appropriate URL, rather than seeing the private page.

### The Private Page
Only users with a valid session can access this page.  It's pretty boring, and just shows the session data (see below).  To make the users feel like authentication is something to be happy about, maybe there are some gratuitous hover effects.

#### _Bonus:_ Logout

The private page has a method for logging out.  After logging out, the session is ended and the user must log in again.

### The Session Resource
The "session" consists of the user, their ip address, and the time the session was created.  Get requests to the session resource return the session data as json.  If the session id is not valid or does not exist, the session data is empty.  Other services use the session resource to access global session data.
