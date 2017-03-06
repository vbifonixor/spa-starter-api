**Update Author**
----
Update a single author.

* **URL**

  /api/authors/:id

* **Method:**
    
  `PUT`
  
*  **URL Params**

   **Required:**

   `id=[integer]`

* **Data Params**

  ``` json
  {
    "name": "Anakin Skywalker",
    "token": "your_access_token"
  }
  ```

* **Success Response:**
  
  * **Code:** 200 OK <br />
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

  * **Code:** 404 NOT FOUND <br />
    **Content:** <br />

    ``` json
    {
      "errors": [
        "Not Found"
      ]
    }
    ```
  
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
  $ curl -X PUT http://localhost:8000/api/authors/1 \
    -d 'name=Anakin Skywalker' \
    -d 'token=your_access_token'
  ```
