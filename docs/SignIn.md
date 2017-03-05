**Sign In**
----
Authenticate users by generating an access token based on their credentials.

* **URL**

  /api/auth/token

* **Method:**
    
  `POST`
  
*  **URL Params**
  
  None

* **Data Params**

  ``` json
  {
    "email": "anakin@death.star",
    "password": "darkside"
  }
  ```

* **Success Response:**
  
  * **Code:** 200 <br />
    **Content:** <br />

    ``` json
    {
      "data": {
        "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
        "user": {
          "id": 1,
          "name": "Anakin Skywalker",
          "email": "anakin@death.star"
        }
      }
    }
    ```
 
* **Error Response:**

  * **Code:** 401 UNAUTHORIZED <br />
    **Content:** <br />

    ``` json
    {
      "errors": [
        "Invalid credentials"
      ]
    }
    ```

* **Sample Call:**

  ``` bash
  $ curl -X POST https://spa-starter-api.herokuapp.com/api/auth/token \
    -d 'email=anakin@death.star' \
    -d 'password=darkside'
  ```
