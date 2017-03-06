**Show Book**
----
Show a single book.

* **URL**

  /api/books/:id

* **Method:**
    
  `GET`
  
*  **URL Params**

   **Required:**

   `id=[integer]`

   `token=[string]`

   **Optional:**

   `include=author`

* **Data Params**

  None

* **Success Response:**
  
  * **Code:** 200 OK <br />
    **Content:** <br />

    ``` json
    {
        "data": {
            "id": 1,
            "title": "The Jedi Path"
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
  $ curl -X GET http://localhost:8000/api/books/1?token=your_access_token
  ```
