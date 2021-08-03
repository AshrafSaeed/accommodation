<p align="center"><img src="https://cdn.freebiesupply.com/logos/large/2x/trivago-logo-png-transparent.png" width="400"></p>


## Instruction

after running the docker build . command follow these instrection

- run these commands 
``` 
// for Laravel clear cache
php artisan optimize

// for database table migration
php artisan migrate 
```
- Here is link of postman collection (https://www.getpostman.com/collections/85487b346fef1cb9b1c4)
- import this collection into you postman
- first register new user 
- use 'access_token' as bearer token in Create, Read, Update and Delete the accomodation, and logout as well 
- to run PHPUnit test use ```php artisan test```


## Task Detail

#### Important notes

- Although you can solve this problem with any programming language, you should
know that most of our backend services are PHP / Kotlin based, so we strongly
encourage you to use one or both of them to complete this task.
- [I use PHP programming language]()
- You can use any major PHP Framework, be sure to not abuse code generation, we
want to see your code.
- [I use Laravel version 8 Framework]()
- Your API should follow as close as possible the RESTful design pattern.
- [I follow the RESTful design pattern.]()
- You can use any library of package that you think suits best for your API.
- [I use Laravel Sanctum for Authorization (bearer) token ]()
- You can choose any DB technology you like, SQL or NoSQL. Preferred database
used is MySQL or PostgreSQL.
- [I use MySQL Database]()
- Your commit history tells us the story of your code, so please create relevant commits
with descriptive messages.



## The Task
The Frontend team is working on a new application for accommodation listings, in this app
any hotelier can manipulate the information that they want to display on our platforms.
Your assignment is to implement an API to allow them to interact with a storage layer.

#### Acceptance criteria

- I can get all the items for the given hotelier. [(Completed)]()
- I can get a single item.  [(Completed)]()
- I can create new entries.  [(Completed)]()
- I can update information of any of my items.  [(Completed)]()
- I can delete any item.  [(Completed)]()
- A booking endpoint than whenever is called reduces the accommodation availability,
and that fails if there is no availability.  [(Completed)]() 

#### Requirements

- Create a Docker file which lists all required and optional dependencies and runs your
project. We should be able to execute "docker build ." command from the root of your
project and "docker run" to launch it. Provide detailed instructions on how to execute your code but please notice that we are going to run the execution on a fresh VM or PC using the latest
Ubuntu or macOS [(Completed)]()
##### I create file docker yml file and DockerFile all configrations are in these file as well as I have add nginx file and linux shell executables files (entrypoint.sh)

- Design your API using the OpenAPI Spec, you can provide the specification in YAML
or JSON. to run migration ``` php artisan migrate ``` on terminal [(Completed)]()
- Create the database schema. [(Completed)]()
- When a user tries to save some data, you must validate against the following
constraints: [(Completed)]()

- A hotel name cannot contain the words ["Free", "Offer", "Book", "Website"]
and it should be longer than 10 characters [(Completed)]()
- The rating MUST accept only integers, where rating is >= 0 and <=  5 [(Completed)]()
- The category can be one of [hotel, alternative, hostel, lodge, resort, guesthouse] and it should be a string [(Completed)]()
- The location MUST be stored on a separate table. [(Completed)]()
- The zip code MUST be an integer and must have a length of 5. [(Completed)]()
- The image MUST be a valid URL [(Completed)]()
- The reputation MUST be an integer >= 0 and <= 1000. [(Completed)]()
- The reputation badge is a calculated value that depends on the reputation
    If reputation is <= 500 the value is red
    If reputation is <= 799 the value is yellow
    Otherwise the value is green
    The price must be an integer
    The availability must be an integer [(Completed)]()
- Provide as many tests as possible, at trivago we aim for at least 85% code coverage. [(Completed)]()
- All of your application errors and exceptions MUST be returned following the
RFC7807 spec. [(Completed)]()

##### extra features
- Add to your API the ability to retrieve information according to some filters:
o Retrieve my items with rating = X
o Retrieve my items located in X city
o Retrieve my items with X reputationBadge
o Retrieve my items with availability of more/less than X
o Retrieve my items with X category [(Completed)]()
- What happens if an user wants to check an item that is not of his property? Can you
provide a solution for this case? [(not done yet Need to be impliment Role Permission)]()
- What about CACHE? Can you implement this layer on your service? [(Completed)]()
- Your code complies to PSR-2 linting and Static (PHPStan) code analysis. [(Completed)]()
