Question Score
A Laravel-based questionnaire and scoring application. It provides a workflow for creating question categories, defining questions with selectable options and score values, collecting users' answers, and displaying answer scores.
Project status: This documentation describes the code currently present in the repository's main branch. Several database/model/controller naming mismatches are present and may prevent some workflows from working correctly. Review Known Issues before using the application in production.

Table of Contents
- Overview
- Features
- Technology Stack
- Application Workflow
- Project Structure
- Requirements
- Installation
- Environment Configuration
- Running the Application
- Routes
- Database and Models
- Scoring Logic
- Testing
- Known Issues and Recommended Improvements
- Security Notes
- Contributing
- License
Overview
Question Score is intended to make it easy to create and answer scored questionnaires. A question belongs to a category and contains multiple answer options. Each option has an associated numeric score. Users can answer the available questions, and the application stores their selected options and scores.

The project is built with Laravel and uses Blade templates for server-rendered pages. Bootstrap is used for the page layouts and forms, with jQuery handling the category-creation AJAX request.
Features
The repository contains code for the following features:
- User registration: registration form for username, email, phone number, and password.
- User login: login form using email and password.
- Category management: display existing categories and submit new categories.
- Question creation: create a question and associate it with a category.
- Dynamic answer options: add multiple answer-option fields to a question.
- Option scoring: assign a numeric score to each option.
- Question listing: display questions and their available options.
- Answer submission: allow users to select an option for each question.
- Score storage: save selected options and associated scores.
- Answer summary: display saved answers and calculate a total score.
These describe the implemented/intended code paths; see Known Issues for limitations in the current implementation.
Technology Stack
Technology	Usage
PHP 8.2+	Backend language
Laravel 11	Application framework
Composer	PHP dependency management
MySQL / SQLite / other Laravel-supported DBs	Database options
Blade	Server-side templates
Bootstrap 5	UI styling and components
jQuery 3.6	AJAX category creation
Node.js and npm	Frontend dependency management
Vite 6	Frontend asset development and build
Tailwind CSS 3	Tailwind configuration is included


Bootstrap and jQuery are loaded from CDNs in the current Blade views.
Application Workflow
The intended user flow is:
1. A visitor opens the application and reaches the login page.
2. A new visitor can open the registration page and create an account.
3. The user proceeds to the category and question creation area.
4. The user selects an existing category or submits a new category.
5. The question author enters a question and adds answer options.
6. A score is assigned to each answer option.
7. The question list displays the questions and their options.
8. A user selects an answer for each question and submits the form.
9. The application stores the selected option and score.
10. The answer page displays the saved answers and calculates the total score.
Project Structure
The main application files are organized as follows:
Question_Score/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── Auth/
│   │       │   ├── LoginController.php
│   │       │   └── RegisterController.php
│   │       ├── AnswerController.php
│   │       ├── CategoryController.php
│   │       └── QuestionnaireController.php
│   └── Models/
│       ├── User.php
│       ├── answer.php
│       ├── category.php
│       ├── question.php
│       └── score.php
├── bootstrap/
├── config/
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
├── public/
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
│       ├── Index.blade.php
│       ├── answers.blade.php
│       ├── list.blade.php
│       ├── login.blade.php
│       └── register.blade.php
├── routes/
│   └── web.php
├── tests/
├── .env.example
├── artisan
├── composer.json
├── package.json
├── phpunit.xml
└── vite.config.js
Main Controllers
Controller	Responsibility
LoginController	Handles login form submission and authentication.
RegisterController	Handles user registration and account creation.
CategoryController	Retrieves and creates question categories.
QuestionnaireController	Creates questions and their option scores, and retrieves questions.
AnswerController	Stores submitted answers and retrieves answer data.


Main Models
Model	Purpose
User	Represents an application user.
category	Represents a question category and its panel type.
question	Represents a question, its category, and option data.
score	Represents a score associated with a question option.
answer	Represents a user's selected answer and score.


Requirements
Before installing the project, make sure you have:
- PHP 8.2 or later.
- Composer 2.x.
- Node.js and npm.
- SQLite support enabled in PHP, or another database supported by Laravel.
- Required Laravel PHP extensions, including PDO and the extension for your selected database.
- A web browser.
Installation
1. Clone the repository
git clone https://github.com/hasanuzzamanpriyam/Question_Score.git
cd Question_Score
2. Install PHP dependencies
composer install
3. Create the environment file
macOS / Linux:
cp .env.example .env
Windows Command Prompt:
copy .env.example .env
4. Generate the application key
php artisan key:generate
5. Configure the database
The example environment configuration uses SQLite:
DB_CONNECTION=sqlite
Create the SQLite database file if it does not already exist.

macOS / Linux:
touch database/database.sqlite
Windows PowerShell:
New-Item -ItemType File -Force database/database.sqlite
If necessary, set DB_DATABASE in .env to the absolute path of the SQLite file.

To use MySQL or PostgreSQL instead, update the database connection and credentials in .env, for example:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=question_score
DB_USERNAME=root
DB_PASSWORD=
Create the database before running the migrations.
6. Run migrations
php artisan migrate
Important: The current migrations contain naming and required-column inconsistencies. A successful migration does not guarantee that all application workflows will work. Review the issues listed below and correct the schema/model/controller mismatches before relying on the application.

7. Install frontend dependencies
npm install
8. Build frontend assets
For development:
npm run dev
For production:
npm run build
Environment Configuration
Important .env settings include:
Variable	Description
APP_NAME	Application name.
APP_ENV	Environment, such as local or production.
APP_KEY	Laravel encryption key. Generate with php artisan key:generate.
APP_DEBUG	Enables detailed error output. Disable in production.
APP_URL	Base URL of the application.
DB_CONNECTION	Database driver.
DB_DATABASE	Database name or SQLite file path.
SESSION_DRIVER	Session storage backend.
CACHE_STORE	Cache storage backend.
QUEUE_CONNECTION	Queue backend.
MAIL_MAILER	Mail transport configuration.


After changing configuration, clear cached configuration when necessary:
php artisan config:clear
php artisan cache:clear
Running the Application
Start the Laravel development server:
php artisan serve
The application is normally available at:
http://127.0.0.1:8000
In a separate terminal, start Vite while developing frontend assets:
npm run dev
The Composer configuration also provides a convenience development command:
composer run dev
Routes
The routes currently declared in routes/web.php include:
Method	URL	Route name	Purpose	Middleware
GET	/	—	Displays the login page.	None explicitly declared
GET	/register	—	Displays the registration page.	None explicitly declared
POST	/login	users.login	Submits login credentials.	None explicitly declared
POST	/register	users.store	Creates a user account.	None explicitly declared
GET	/show_categories	categories.index	Displays the category/question form.	None explicitly declared
POST	/categories	categories.store	Creates a category and returns JSON.	None explicitly declared
GET	/questions_list	questions	Displays the question list.	None explicitly declared
POST	/questions	questions.store	Creates a question and its scores.	None explicitly declared
GET	/show_answers	show_answers	Displays saved answers.	auth
POST	/answers	store_answers	Saves submitted answers.	auth


Only the answer routes are explicitly protected by the auth middleware in the current route file. Review access control before deploying.
Database and Models
The primary domain entities are:
- Users: account details and authentication credentials.
- Categories: category name, panel type, and creator reference.
- Questions: category reference, question text, option labels, and score data.
- Scores: question reference and numeric score.
- Answers: user reference, question reference, category reference, selected option, and submitted score.
The Eloquent models define relationships intended to connect these entities:
- A category has many questions.
- A category has many answers.
- A question belongs to a category.
- A question has many score records.
- A score belongs to a question.
- An answer belongs to a user, category, and question.
- A user has many answers.
The current migrations and models do not consistently use the same column names. See Known Issues.
Scoring Logic
When a question is created, the question form submits:
- The question text.
- A category ID.
- An array of option labels.
- An array of numeric scores corresponding to those options.
The question controller stores option labels and score values in serialized string columns and also attempts to create individual score records for the options.

The question-list view displays the options and their associated scores. When a user selects an option, JavaScript copies the selected score into a hidden form field. The answer controller stores the selected option and submitted score. The answer view adds the displayed answer scores to calculate a total.

Conceptually:
Total Score = Score of Answer 1
            + Score of Answer 2
            + ...
            + Score of Answer N
This is a basic additive scoring approach. The current repository does not implement weighted category totals, score bands, result interpretation, or configurable scoring formulas.
Testing
Run the automated Laravel test suite:
php artisan test
Build frontend assets:
npm run build
Recommended feature tests include:
- User registration and login.
- Category creation and validation.
- Question creation with multiple options.
- Correct option-to-score association.
- Answer submission.
- Server-side score calculation.
- Authentication and authorization.
- Ensuring users can only view answers they are permitted to access.
Known Issues and Recommended Improvements
The following issues are visible in the current source and should be addressed.
1. Category column mismatch: the category migration uses catergory_name (misspelled), while the model/controller use category_name. The migration also requires created_by, but the category controller does not supply it when creating a category.
2. Score foreign-key mismatch: the scores migration creates questions_id, while the score model, question relationship, and question controller use question_id. These names need to be standardized.
3. Answer column mismatch: the answers migration declares multiple_choice as a non-nullable column, but the answer controller does not assign it. This can cause answer inserts to fail.
4. User model fillable mismatch: the users migration uses username, user_number, user_email, and password. The User model's fillable list instead contains user_name, user_phone, and user_password. Standardize these names.
5. View filename case: the category controller requests view('index'), while the tracked view is resources/views/Index.blade.php. This can fail on case-sensitive filesystems. Rename the view or update the controller consistently.
6. Category AJAX option value: the category form's success handler appends the category name as the option value, while question creation expects a category ID. Return and use the new category's ID.
7. Authentication and authorization: category and question management routes are not protected by auth middleware in the current route file. Add appropriate authentication and authorization rules.
8. Answer privacy: the answer listing retrieves answer records without clearly scoping them to the authenticated user. Ensure users cannot access other users' private answers unless explicitly authorized.
9. Registration/login flow: registration returns the login view but does not automatically authenticate the new user. Failed login handling should return clear validation or authentication feedback.
10. Option storage format: options and score values are stored as comma-delimited strings. This can break when an option label contains a comma. A dedicated question-options table is a more reliable design.
11. Trusting client-submitted scores: the answer form sends the score in a hidden input. Hidden fields can be modified by users. The server should determine the score from the selected option instead of trusting the submitted value.
12. Validation and transactions: validate that questions and options exist, that selected options belong to the submitted question, and that scores are valid. Use database transactions when creating a question and its options or saving related answers.
Suggested Improvements
For a more reliable application:
- Standardize column names across migrations, models, and controllers.
- Add foreign keys and indexes for relationships.
- Create a dedicated question_options table with one record per option and score.
- Calculate scores on the server.
- Add authentication and authorization to management routes.
- Scope answer queries to the authenticated user or an authorized administrator.
- Add logout and password-reset functionality.
- Improve validation and error messages.
- Add feature tests for the complete questionnaire workflow.
- Verify a clean installation and end-to-end workflow on the target database.
Security Notes
Before deploying:
- Never commit the real .env file or production credentials.
- Use a unique application key for each deployment.
- Set APP_DEBUG=false in production.
- Serve the application over HTTPS.
- Keep PHP, Laravel dependencies, and npm packages updated.
- Protect management routes with authentication and authorization.
- Validate all user-submitted data on the server.
- Calculate scores server-side rather than trusting hidden form values.
- Restrict access to users' answer records.
Contributing
Contributions are welcome.
1. Fork the repository.
2. Create a feature branch.
3. Make your changes.
4. Keep migrations, models, controllers, and views consistent.
5. Add or update tests for changed behavior.
6. Run php artisan test and npm run build.
7. Submit a pull request with a clear description of the changes.
For larger changes, consider opening an issue first to discuss the proposed implementation.
License
The repository does not currently include a project-level LICENSE file. The Composer metadata contains an MIT license value inherited from the Laravel application setup, but the intended project license should be confirmed. Add a LICENSE file before redistributing the project.
