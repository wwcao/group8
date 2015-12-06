# Hobby Hub
CSCI 3308 Project
Groupmember:
Weipeng Cao, Lacey Conrad, Austin Linn, Dmytro Ryzhkov

DIRECTORY STRUCTURE
-------------------
      basic/            contains main of yii framework(see README.md in basic)
      LoginDB/          contains .sql for database setup
      ScreenShots/      contains website screenshots
      tests/        		contains test results
      
## Instruction:

### system requirement: 
1. basic/vendor/* by extracting vendor.tar.gz
2. PHP GD extension
- 1. install by $ apt-get install php5-gd
- 2. start or restart server
3. Setup codecept for test (Instruction in basic/tests) OPTIONAL!

### Setup Database:
*(Suggest to EMPTY TABLES users and profiles)*
1. create databae userDB (Updated Table Description)
2. create tables users, profiles, groups, groupmembers, interest with queries @ LoginDB/userDB.sql
3. GRANT ALL PRIVILEGES ON userDB. * TO 'csci_proj'@'localhost' identified by 'csci_proj';
*need to alter groups.decripton to groups.decription if error 'no attribute/column occurs'*

### Run Test: (need to setup)
1. go to basic/web
2. run php -S localhost:<port #> 

### Run Test: (need to setup see README.md @basic/tests)
- 1. codecept run @ basic/tests



