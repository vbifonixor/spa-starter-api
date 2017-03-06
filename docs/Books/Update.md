**Update Book**
----
Update a single book.

* **URL**

  /api/books/:id

* **Method:**
    
  `PUT`
  
*  **URL Params**

   **Required:**

   `id=[integer]`

* **Data Params**

  ``` json
    {
        "title": "The Jedi Path",
        "author": 1,
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
            "title": "The Jedi Path",
            "author": {
                "id": 1,
                "name": "Daniel Wallace"
            }
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
            "title": [
                "The title field is required."
            ],
            "author": [
                "The author field is required.",
                "The selected author is invalid."
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
  $ curl -X PUT http://localhost:8000/api/books/1 \
    -d 'title=The Jedi Path' \
    -d 'author=1' \
    -d 'token=your_access_token'
  ```
