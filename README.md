# **Welcome to the E-commerce website (Auto World)**

## *Team Name: Group 6*

Department of Electrical & Computer Engineering, North South University, Bangladesh.

## Team Members:
1. Sifat Arifen 2012621642
2. Kazi Lutfullah Hil Mazid 2014083642
3. Md Mominul Islam Raju 1813544042
4. Md Mashikur Rahaman 2011033642
5. Silvia Salim 1530712042

## How to Use
### 1. Clone the project

Install git bash

Open your local directory's git bash terminal

Configure git:

git config --global user.name <github_username>

git config --global user.email <github_email>

Run command: git clone https://github.com/mashikur-sijan/e-commerce-website

### 2. Navigate to the project directory commands

Open VS Code.
Open E_Commerce Website folder

### 3. Run the Project

Check PHP and Mysql.

Checkout to specific branch: git checkout <branch_name>

Click and Follow: 
[http://127.0.0.1:8000/](http://localhost/E_Commerce_Website/index.php)
http://localhost/E_Commerce_Website/admin/index.php
http://localhost/phpmyadmin/index.php?route=/database/structure&db=autoworld

## How to Develop

# 1. Create a new branch:

Run command: git checkout -b <new_branch_name>

# 2. Make Changes: For raw PHP (without framework)

Create new PHP files for your e-commerce functionality (products.php, cart.php, checkout.php)

For database changes:

Modify your SQL schema directly

Run SQL queries to update your database structure

# 3. Commit and Push Changes:

Commit changes to the local repository

git add .
git commit -m "Added product management for e-commerce site"

Push changes to the remote repository: git push origin main

For payment integration, you might need to:

Set up SSL certificate

Integrate payment gateways

For inventory management:

Create database tables for products, categories, inventory

Implement cart functionality with sessions

# 4. Check CI:

Go to Github Actions
Click on test

# 5. Create a Pull Request:

Create a Pull Request from new branch to the main development branch.

# 6. Review and Merge:

Collaborators will review changes in the Pull Request.
If approved, merge changes into the main branch.

# 7. Update Local Repository:

Switch back to the main branch: git checkout main

Pull the latest changes from the remote repository: git pull origin main

Delete the local feature branch (optional): git branch -d <new_branch_name>

Delete the remote feature branch (if merged and no longer needed): git push origin --delete <new_branch_name>



