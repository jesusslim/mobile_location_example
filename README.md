# mobile_location_example
get location of mobile phone number in php

# Install

cd Lib

run 

	composer update
	
then

	php index.php
	
# Example

API
	
url:

	http://localhost:9876?service=mobile&function=getLocation

post

	mobile=17005686856
	
result:

	{
	   "status": 1,
  		"result": {
    		"province": "浙江",
    		"city": "杭州"
  		}
	}	