
# Instruction:

## Setup Database:
*(Suggest to EMPTY TABLES users and profiles)*
- 1. create databae userDB (Updated Table Description)
- 2. create tables users, profiles, groups, groupmembers, interest with queries @ LoginDB/userDB.sql
- 3. GRANT ALL PRIVILEGES ON userDB. * TO 'csci_proj'@'localhost' identified by 'csci_proj';
- *need to alter groups.decripton to groups.decription if error 'no attribute/column occurs'*
## system requirement: 
- 1. basic/vendor/* by extracting vendor.tar.gz
- 2. PHP GD extension
- 3. Setup codecept for test (Instruction in basic/tests) OPTIONAL!

## Run Test:
- 1. codecept run @ basic/tests


