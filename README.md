# Hobby Hub
####CSCI 3308 Project  
  
####Groupmember:  
Weipeng Cao, Lacey Conrad, Austin Linn, Dmytro Ryzhkov  
  
####Description:  
HobbyHub is the first website of its kind! Connect with users from around the world who share the same interests as you. Share your ideas, or read the ideas of others!
DIRECTORY STRUCTURE
-------------------
      basic/            contains main of yii framework(see README.md in basic)
      LoginDB/          contains .sql for database setup
      ScreenShots/      contains website screenshots
      tests/       		contains test results
      autodoc/			contains auto document in formats html and pdf
      
## Instruction:

### system requirement: 
1. basic/vendor by running **tar -xvf vendor.tar.gz** at /basic
2. PHP GD extension
  1. install by $apt-get install php5-gd
  2. start or restart server
3. database userDB *(see Setup Database below)*
4. Setup codecept for test (Instruction in basic/tests) OPTIONAL!

### Setup Database:
1. create databae userDB
2. create tables users, profiles, groups, groupmembers, *interest* with queries @ LoginDB/userDB.sql
3. GRANT ALL PRIVILEGES ON userDB. * TO 'csci_proj'@'localhost' identified by 'csci_proj';
  table interest is optional
  

### Deployment: (need to setup)
1. go to basic/web
2. run php -S localhost:<port #> 

### Run Test: (need to setup see README.md @basic/tests)
- codecept run @ basic/tests



