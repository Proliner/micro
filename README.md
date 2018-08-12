# Getting started with Symfony 4
This project is a tutorial for getting started with the Symfony PHP framework. If your system meets the requirements the tutorial requires about 15 minutes of your time.

## Requirements

Modern Symfony applications require PHP 7.1 and composer. In our tutorial we will also use the MySQL database version 5.7. Mac users should use Homebrew to install PHP and Vagrant. Mac Setup: [https://www.phptherightway.com/#mac_setup](https://www.phptherightway.com/#mac_setup)

Windows users are required to run Ubuntu 18.04 as a VM for local development. Vagrant with Homestead is not recommended because it is just too complex for most web development purposes. 

Install VirtualBox or VMware and download Ubuntu from the website. Install your Ubuntu VM with 2GB RAM and 20GB disk space (Ubuntu requires 8GB). We recommend the Minimal Installation.

When your VM is finally ready open the terminal for the real work. Install PHP 7.1 from packages.  
```sh
sudo apt-get install software-properties-common  
sudo add-apt-repository ppa:ondrej/php  
sudo apt-get update  
sudo apt-get install php7.1-cli php7.1-common php7.1-json php7.1-opcache php7.1-curl php7.1-mysql php7.1-mbstring php7.1-mcrypt php7.1-xml php7.1-zip php7.1-fpm php7.1-sqlite
```

Install the requirements for Linux valet.
```sh
sudo apt-get install network-manager libnss3-tools jq xsel
```

Download Composer from the website.
[https://getcomposer.org/download/](https://getcomposer.org/download/)

Setup Composer globally.  
```sh
sudo mv composer.phar /usr/local/bin/composer
```

Install Valet Linux with Composer.
```sh
composer global require cpriego/valet-linux
```

Setup PATH to include Composer tools.  
```sh
echo 'PATH=$HOME/.config/composer/vendor/bin:$PATH' >> ~/.bashrc
```

Exit the terminal and open new session, run valet install.  
```sh
valet install
```

Install Git for version control.  
```sh
sudo apt-get install git
```

Install Atom as code editor. Text Editor works if you are a Linux minimalist.

## Installation

Open your terminal home directory and create your projects directory. Clone this repository in your projects directory. Install dependencies with composer.

```sh
mkdir Projects
cd Projects
git clone https://github.com/mikepage/symfony-bootstrap-boilerplate
cd symfony-bootstrap-boilerplate
composer install
```

Link valet from the project directory. Open [http://symfony.test](http://symfony.test) in your browser, you should see the Symfony welcome page.

```sh
valet link symfony
```

## Configure the database and entities

Open your terminal in the project directory and setup sqlite as your database. 
[https://symfony.com/doc/current/doctrine.html#configuring-the-database](https://symfony.com/doc/current/doctrine.html#configuring-the-database)

Add entities with the maker bundle.  
[https://symfony.com/doc/current/doctrine.html#creating-an-entity-class](https://symfony.com/doc/current/doctrine.html#creating-an-entity-class)

Update your database with the schema update tool.  
```sh
php bin/console doctrine:schema:update --force
```
