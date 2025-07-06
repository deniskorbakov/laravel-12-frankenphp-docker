# GitHub Actions

this template also has auto deployment configured

For deployment to the server, you need to specify the following variables:

```dotenv
# server ip address
SERVER_IP=
# ssh login
SERVER_USERNAME=
# ssh password
SERVER_PASSWORD=
# path where the project is located
PROJECT_PATH=
```
Change in deploy.yml environment and uncomment lines

environment attribute - used to specify which secret pool to use (relevant when you are using a public repository)
