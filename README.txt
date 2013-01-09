NOTES:

THIS SOFTWARE IS RELEASED UNDER THE GPL V3.

THE SOFTWARE IS PROVIDED AS-IS.  

There are almost certainly errors. This software is 5 years old, I cleaned it up a little bit by hand, but I have not tried to install it fresh. The original system, last I checked, still runs fine in modern browsers, but it is likely you'll have to do some set up work beyond entering data.

I do not have the time or willingness to help you set up your own system.  Sorry.

If you do find a bug, and a fix for that bug, please leave a comment on the GitHub page for this project: https://github.com/leducmills/Inventory and I will push the change into the master branch.


BASIC SETUP:

1. Import/load inventory.sql into your mysql database.  This should set up the basic structure of the database system.

2. Open config.php and change the variables to match your host, database, and passwords.

3. Open 'addEquip.php'.  At around line 45, there will be a series of directory paths you will need to fill in to match your system's location.

4. Most likely you will want to customize the look and feel of your system. I've provided the .css files I have under the includes folder, but you will probably want to change them. 

5. You will have to enter the users, equipment, etc. into your system. You may want to configure the various tables in the database to reflect the info you want to store / present.  IF YOU DO THIS: you will have to go through the various .php files and find where the equipment table is being accessed AND/OR displayed and change the code to reflect the changes you make.  

6. Good luck! And if you do get a system working, shoot me a message through my website at benatwork.cc/contact I'd love to see it.