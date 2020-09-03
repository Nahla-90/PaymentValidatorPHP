## Payment Validator

#Important Note " If you use postman for testing"

  - add this lines inside pre-request script tab
      var timestamp =  Math.floor(Date.now() / 1000);
      pm.globals.set("timestamp", timestamp);
  - add two params to headers tab
     timestamp => {{timestamp}}
     key => abcd
   

#Usage
1- Example 1 :
   URL : http://localhost/paymentValidator/index.php
   Headers : should contain timstamp and key="abcd"
   Request : [
             						{
             							"key": "paymentType",
             							"value": "creditCard"
             						},
             						{
             							"key": "creditCardNumber",
             							"value": "132544564654568"
             						},
             						{
             							"key": "expirationDate",
             							"value": "kjkljklj"
             						},
             						{
             							"key": "cvv2",
             							"value": "kjljkj"
             						},
             						{
             							"key": "email",
             							"value": "nodi"
             						},
             						{
             							"key": "format",
             							"value": "json"
             						}
             					]
             				

2- Example 2 : 
   URL : http://localhost/paymentValidator/index.php
   Headers : should contain timstamp and key="abcd"
   Request : [
             						{
             							"key": "paymentType",
             							"value": "mobile"
             						},
             						{
             							"key": "format",
             							"value": "xml"
             						}
             					]
