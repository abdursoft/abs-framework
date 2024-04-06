# This is my own PHP MVC Framework  
I build it for personal and commercial uses under MIT license.So you can use this framework for you any kind of ueses.

- First of all you have to clone the project from github to your local/live server
- After that you can modified the files as you want
- Updated your database and host information in __config.php__ file in core/Config/config.php
- Then you can run the application in your localhost through  
    ``php -S localhost:9000``  
with your prefered port number
- For your live server just put all files in your root folder/directory
- You can change the page title dynamically  
    ``$this->load->page_title = "About page"``
- You can add flash message dynamically  
    ``$this->flashMessage('background-color','text-color','line-color','message text')``
- You can add one or more style file in your specific pages 
    - For single style file  
        ``$this->loadStyle('file_name.css')``
    - For multiple style files  
        ``$this->loadStyle(['style1.css','style2.css'])``

- You can add one or more javascript file in your specific pages 
    - For single javascript file  
        ``$this->loadScript('main.js')``
    - For multiple javascript files  
        ``$this->loadStyle(['script1.js','script2.js'])``
