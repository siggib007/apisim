# API Simulator
## API Simulator details
This is a site you can point your API parsing code at to test how it responds to various anomalies. All the options available to you are documented at https://apisim.net/apisim.php. In short you can sleep your response for specified seconds to test timeout and slow reponse handling, you can force a specific error code response, specify the format of the response as well as the exact response text.

One thing kind of unique, or weird depending on your point of view, about this site is that there isn't a single <script> element anywhere. This entire site was create without any JavaScript. This was done on purpose, mostly just to demonstrate that it is possible to create a fully functional and interesting site without any JavaScript. This is entirely pure PHP, HTML and CSS. Yes the CSS needs a lot of work but that is a separate project that maybe I will solicit help from a CSS guru at some point, not something I am worried about right now. 

Another thing is that this was written completely from scratch, there are no frameworks used in this and only two modules that are not inherent in native PHP. So my SBOM is very simple.
- PHPMailer for handling sending of emails
- RobThree2FA for TOTP authentication. 

Everything else was written from scratch by me. Any external service used, such as Twilio or Doppler are accessed via REST API using built in curl functions.

There are few environment variables needed for both the SQL server and the PHP part. I've tested this with environment variables as well as using Doppler Secrets management (see https://infosechelp.net/secrets-management/ for more info on them) as well as a secret management system from AKEYLESS systems (https://infosechelp.net/secrets-management-a-key-less-edition for more info on them). See ExtVars.php for more details on environment variables required.

As I alluded to above, I'm not a front end designer. While I would never claim to even be a developer of any kind, I'm way more of a backend dev than anything else. I am very utilitarian by nature so this site is very functional and utilitarian. I'm completely focused on functionality, and very little on looks. So I expect it will never win any awards or even compliments for aesthetics or anything along those lines. As I said before the CSS and other aspects could use a lot of work, but that is not a focus at this point. Reach out if you want to show off your CSS skills and help with that. 

If you are deploying this anywhere other than your laptop for testing purposes I strongly recommend you delete EmailTest.php from the server. If an unauthorized person where to gain access to this site they could start sending emails in your name and bypassing DMARC/SPF. 

If there are any questions or problems, feel free to reach out via info@apisim.net

## Deploy with Docker and Doppler

To set this up using Docker and fetching secrets to Doppler run the following commands. This assumes Docker, docker-compose and Doppler CLI are already setup and that Doppler CLI is properly authenticated into your Doppler workspace. See https://infosechelp.net/secrets-management/ for how to do that if you need. This is setup such that all the secrets in a specified config (project: phpdemo, config: dev by default) are injected into the docker container at run time. If you change the values in the config you need to restart the container to get the new values injected. To work around this I inject a secret called DOPPLERKEY which contains an service API key and allows the program to fetch each secret as needed on the fly via API and therefor always have the most up to date value. While it may seem counterintuitive to have a doppler API key inside doppler, this is the logic.

Run the following commands from your terminal. FYI I'm doing this on a Windows 10 box and Docker Desktop for Windows. 

1. git clone https://github.com/siggib007/apisim.git apisim
2. cd apisim
2. doppler import
3. Adjust the secrets, either via the cli or via the website, as necessary for your environment, the doppler key is a service key you generate on the access tab inside the appropriate config. 
4. In ExtVars.php make sure line 34 and 35, matches what you are using for project and config in Doppler. The Template uses phpdemo, while the code might be uses phpdev depending on what I was using for my testing when I last checked the code in. Also adjust next line accordingly
5. doppler setup -c dev -p phpdemo
6. doppler run -- docker-compose up -d

That should be it, you should be good to go now. Just open up a browser to http://localhost:88 and create yourself an account in this demo system.

## Deploy manually to a web server and a mySQL/mariadb server

If you would rather deploy this manually to PHP server and a mySQL or MariaDB server rather than use Docker here are the general steps you need to follow:

1. Execute DBCreatePopulate.sql against your database server, make sure you adjust the database create and use statement according to your requirements. 
2. Deploy all the php and CSS files from this repo to your php enabled web server
3. Adjust ExtVars.php according to how you are handling secrets and environmental variables. 
4. Create any required environment variables and make sure they are exposed to the PHP engine. (see note below about shared hosting)
   I put them in httpd.conf during my testing using the format:
   `SetEnv DOPPLERKEY "topsecret key"`
5. If you want to use AKEYLESS system there is a shell script file aKeylessImport.txt that will create all the secrets needed, assuming you have their CLI installed. You would then adjust these values as necessary. I recommend against having password and API authentication keys in any sort of shell scripting or import file, rather manually update those on the CLI or in the GUI later.

If you want to deploy this to a shared hosting provider where you can't create environment variables but you want to use Doppler, AKEYLESS or other system that require and API key, just create a php file that isn't tracked by git or any other system and has extra strict file access permissions on it and place the following content in it. 

`<?php
putenv("DOPPLERKEY=dp.st.prd.1cbq8aSUfloXOvQ66h4MKGzTH4PltZieJOpOnlRhd30");
require("DopplerVar.php");
?>`

If you want to use AKEYLESS

`<?php
putenv("KEYLESSID=p-x2ujypx28t3y");
putenv("KEYLESSKEY=QOWl4aybzb9SllNtJuQihkqU+sw91FFaZvZpiH+0WLY=");
require("DopplerVar.php");
?>`

Say you name it secrets.php then have the last line in ExtVars.php be as follows:

`require("secrets.php");`

The reason I created ExtVars.php as a separate file that is required by DBCon.php, rather than just having those three lines directly in DBCon.php, is because these three lines can change from environment to environment and this way I can exclude ExtVar.php while still being able to change DBCon.php and still have it propagate to other git locations without messing with the local configuration. 
