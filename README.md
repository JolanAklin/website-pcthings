# website-pcthings
a website to talk about computer and technology things

create a .env.local in the top dir and set database credentials in this file

Load the test dataset by running php bin/console doctrine:fixtures:load in the project directory

When updating the user picture, make sure that the webserver has the right to write in ./public/images folder or else, a error while occur.
