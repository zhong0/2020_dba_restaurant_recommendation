# 隨食文山

demo video: https://youtu.be/OTVHOEt4oo0

Introduction
----
* ### Restaurant Recommendation
  >As a NCCU student, there’s a problem to choose the restaurant at the meal time. Therefore, we development the system to recommend the restaurant around the NCCU. It contains random, user common choices, conditional filter modes. The information, such as business hour, address, telephone, comment, will be showed on the introduction pages. Moreover, the system will record the restaurant the user has been. If someone has also been the same places, the system would suggest he or she’s history which the user hasn’t been. In brief, the user may obtain different but possibly highly matched restaurant to explore.

* ### Business Strategy
  >User can collect the point via scanning QR code after having the meal. Then, they can exchange the coupon of restaurant in our shopping center. The ad fee will influence the order of all restaurant list.

Technique
----
* ### Database
  >We applied Amazon EC2 virtual machine, which was set up the Xampp and used its Apache server, as the cloud server. Based on relational database concepts, we used SQL with Maria DB framework to build our database, and managed it with phpMyAdmin.

* ### Data Passing
  >Php files connected all data of each function between user side and database. In php codes, there were the connection to the database and SQL commands. We used POST method to receive the data from Android side to operate our database, such as query, update, delete and so on. If it was need to send the value to user, we formed the data to Json format and returned it with echo commands.

* ### User Interface
  > The user interface was developed with Android Studio. The Layout was generated with XML, and the interface operation was coded with Java. The techniques included CardView, RecyclerView, Barcode Scanner, etc. Besides, we embedded Google Map API to achieve navigation function. Moreover, we used Volley Library to pass the data and Gson Library help Java to depack the Json format data from php files.

Environment
----
* ### Database
  >We used Windows os environment on AWS EC2, and set the port to make external network available to connect it. To enter the virtual machine, you need to download the authorized certificate and type the password to login. In the machine, you need to download Xampp, and set the username and the password. It's necessary to start the functions of Apache and MySQL. Then, you could open the localhost(127.0.0.1) to get the access to phpMyAdmin. You can implement the database after importing our sql file.
* ### php
  >Xampp contains the php environment. Therefore, you just need to make all php files under the path xampp/htdoc/ in the EC2 machine. It's notified that the username and password in those files need to be modified to your own settings.

* ### Android Studio
  >Download Android Studio first according to the official document, and open our project files from Android Studio. If your pc doesn't contain Java environment, you need to follow the hints to download it. Also, you should synchronous the gradle file with our project. Our server is closed. Therefore, you should modify all the IP links in the projects to your own settings. The setting of minSdkVersion is 23 and targetSdkVersion is 28 in our project.

  >Notification: Our project only provides to academic needs. If you need to download the user interface file, please feel free to contact us via sending the e-mail to 109753106@g.nccu.edu.tw. We would authorize the access after estimating.

Supplement
----
* Document
  >The document file contains the introduction document and presentation ppt for final project of DBA courses. All the documents are written in Chinese. If you want to understand our systems practical work, you can access the demo video via above link.
