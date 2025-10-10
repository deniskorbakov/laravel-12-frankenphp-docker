# Ansible

it is mandatory that the server is on Debian/Ubuntu OS

In order to deploy, you need to install [ansible](https://docs.ansible.com/ansible/latest/installation_guide/intro_installation.html)

Configure the inventory [file](../ansible/inventory.ini) you need to add your server configuration via ssh

Replace variables for [ansible](../ansible/vars/default.yml)
- **repo_url**: changing it to your repository
- **domain**: I'll replace it with your domain

Run the command
```shell
make expand-server
```



