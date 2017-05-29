Tic Tac Toe Game
=================================

This is an Application based on Symfony 3.


Main technologies in this project
---------------------------------

  * Symfony 3.

  * Vagrant Box that can be reused to setup the development environment.
  
  * Ansible to provision the Vagrant Box. The roles used in this project are provided by https://github.com/geerlingguy/

  * FOS Rest Bundle to add a Rest Api.    
  
  * PHPUnit to test each part of the application implementing TDD as much as possible, either Unit and Integration tests.
  
  
Structure
---------------------------------
 
The code is separated in three bundles. 
GameBundle contains Unit and Integration tests.
Test code coverage can be found at var/cache/coverage.
    
* GameBundle
    This bundle contains all the logic business.                     
           
* ApiBundle
    With three endpoints to interact with the GameBundle:
        "/api/v1/start-game" to start a new game.
        "/api/v1/user-move/{x}/{y}" to allows users play by using the UI provided by the client.
        "/api/v1/bot-move" to make a move for the bot after user move.
        
* ClientBundle
    Contains an user interfaces to allows users playing against to the bot.
    
    
How setup this application
---------------------------------

* Install dependencies 
    VirtualBox
    Vagrant
    Ansible

* Install Tic Tac Toe        
    - Copy "vagrant_inventory.example.yml" to "vagrant_inventory.yml" and replace what you need.
    - Check "ansible/hosts" file to make sure that some parameters match with vagrant_inventory.yml.
    - Run "vagrant up"
    - Run "Vagrant ssh" to access to the development box.
    - Run "composer install"
    - Make sure to add a new host in you /etc/hosts (check the IP in your vagrant_inventory)  