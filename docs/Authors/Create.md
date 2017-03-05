**Create Author**
----
Creates a new author.

* **URL**

  /api/authors

* **Method:**
    
  `POST`
  
*  **URL Params**

   None

* **Data Params**

  ``` json
  {
    "name": "Anakin Skywalker",
    "token": "your_access_token"
  }
  ```

* **Success Response:**
  
  * **Code:** 201 CREATED <br />
    **Content:** <br />

    ``` json
    {
      "data": {
        "id": 1,
        "name": "Anakin Skywalker"
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
        ]
      }
    }
    ```
  
  * **Code:** 401 UNAUTHORIZED <br />
    **Content:** <br />

    ``` json
    {
      "errors": [
        "Unauthorized, you should provide a valid access token."
      ]
    }
    ```

* **Sample Call:**

  ``` bash
  $ curl -X POST https://spa-starter-api.herokuapp.com/api/authors \
    -d 'name=Anakin Skywalker' \
    -d 'token=your_access_token'
  ```
