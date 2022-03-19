# Restaurant Recommendation for NCCU

Demo video: https://youtu.be/OTVHOEt4oo0

Introduction
----
* ### Restaurant Recommendation
  >As a NCCU student, there’s a problem to select a restaurant at the meal time. Therefore, we developed the system to recommend the restaurant around NCCU. Our system contains three recommendation mode, including random, user commonly chosed, conditional filter. The restaurant information, such as business hour, address, telephone, comments, is displayed on the introduction pages. Moreover, the system will record the restaurant the user has been. If someone has also been the same places, the system would suggest the place in he or she’s history which the user hasn’t been to the user. In brief, the user may explore different but possibly highly matched restaurant.

* ### Business Strategy
  >Users can collect the point via scanning QR code after having meal. Then, they can exchange the coupons of cooperative restaurants in our shopping center. The ad fee will influence the order of the list for all restaurant showing page.

Techniques
----
* ### Database
  >We applied Amazon EC2 virtual machine, which was installed the XAMPP and used its Apache server, as the cloud server. Based on the relational database concepts, we used SQL with Maria DB framework to build our database, and managed it with phpMyAdmin.

* ### Data Transmission
  >PHP files connected all data of each function between user side and database. The connection to the database and SQL commands were written in PHP files. We used POST method to receive the data from Android side to manipulate our database, such as querying, updating, deleting and so on. If it needs to send the value to Android side, we will form the data to Json format and return it with echo commands.

* ### User Interface
  > The user interface was developed with Android Studio. The Layout was generated with XML, and the interface operation was coded with Java. The techniques included CardView, RecyclerView, Barcode Scanner, etc. Besides, we embedded Google Map API to achieve navigation function. Volley library was applied to pass the data. Gson library helped in Java to parse the Json format data from PHP files.

Environment
----
* ### Database
  > We used Windows os environment on AWS EC2, and set the port to make external network available to connect it. To enter the virtual machine, you need to download the authorized certificate and type the password to login. In the machine, you need to download XAMPP and set the username and the password. It's necessary to start the functions of Apache and MySQL. Then, you can be access to phpMyAdmin after linking to the localhost(127.0.0.1), and import our sql file to implement the database.

* ### PHP
  >XAMPP contains the PHP environment. Therefore, you just need to move all PHP files and backstage files to the path /xampp/htdoc/ in the EC2 machine. It's noticed that the username and password in those files should be modified to your own settings.

* ### Android Studio
  > Follow the official document to download Android Studio, and open our project from Android Studio. If your pc doesn't contain Java environment, you need to follow the hints to download it. Also, you should synchronous the gradle file with our project. Our server is closed. Therefore, you need to modify all the IP links in the projects to your own settings. The setting of minSdkVersion is 23 and targetSdkVersion is 28 in our project.

  >Notification: Our project only provides to academic needs. If you need to download the user interface file, please feel free to contact us via the e-mail 109753106@g.nccu.edu.tw. We would authorize the access after an assessment.

Supplement
----
* ### Business Strategy
  >The business strategy is only a concept. There’s no real cooperative restaurant in our project. The function we developed is a simulation to the expected situation.

* ### Document
  >The document file contains the introduction document and presentation ppt for final project of DBA course. All the documents are written in Chinese. If you want to understand our systems work in details, you can watch the demo video via above link.
