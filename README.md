# Event Management System

The Event Management System is a web-based application that allows users to create, manage, and participate in various events. It provides three types of user accounts: students, coordinators, and departments. Students can view and register for events organized by coordinators or departments, and they can also unregister if needed. After an event is completed, students can provide feedback for the event. Coordinators and departments have the authority to create new events and remove existing ones.

## Features

- User Registration: Students, coordinators, and departments can create their accounts.
- User Authentication: Secure login system using password hashing for user authentication.
- Event Creation: Coordinators and departments can create new events with event details, dates, and photos.
- Event Registration: Students can register for events they are interested in attending.
- Event Unregistration: Students can unregister from events if they change their plans.
- Event Feedback: After an event is completed, students can provide feedback and ratings.
- Account Roles: Different account types with specific privileges (students, coordinators, departments).

## Technologies Used

- PHP: Server-side scripting language used for backend development.
- MySQL: Database management system used for storing user and event data.
- HTML/CSS: Frontend technologies for designing and styling the web pages.
- JavaScript: Client-side scripting for interactive elements and form validations.

## How to Use

1. Clone the repository to your local machine.
2. Set up a web server with PHP and MySQL support.
3. Import the provided `portal.sql` file into your MySQL server to create the necessary tables.
4. Update the `connection.php` file with your MySQL database credentials.
5. Access the application through the web server.

## Screenshots

### Login
![Login](https://github.com/11aniketkumar/event_management_system/raw/main/images/login.png)

### Events Page
![Event](https://github.com/11aniketkumar/event_management_system/raw/main/images/event.png)

### New Event Page
![Event](https://github.com/11aniketkumar/event_management_system/raw/main/images/new_event.png)

## License

This project is licensed under the [MIT License](LICENSE).
