**Sign Up**
----
Sign up new users and return their data and access token.

* **URL**

  /api/signup

* **Method:**
    
  `POST`
  
*  **URL Params**
  
  None

* **Data Params**

  ``` json
  {
    "name": "Anakin Skywalker",
    "email": "anakin@death.star",
    "password": "darkside"
  }
  ```

* **Success Response:**
  
  * **Code:** 201 CREATED <br />
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

  * **Code:** 422 UNPROCESSABLE ENTRY <br />
    **Content:** <br />

    ``` json
    {
      "errors": {
        "name": [
          "The name field is required."
        ],
        "email": [
          "The email field is required.",
          "The email has already been taken."
        ],
        "password": [
          "The password field is required."
        ]
      }
    }
    ```

* **Sample Call:**

  ``` bash
  $ curl -X POST http://localhost:8000/api/signup \
    -d 'name=Anakin Skywalker' \
    -d 'email=anakin@death.star' \
    -d 'password=darkside'
  ```
