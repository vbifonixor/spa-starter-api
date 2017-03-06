**Show All Books**
----
Show all of the books.

* **URL**

  /api/books

* **Method:**
    
  `GET`
  
*  **URL Params**

   **Required:**
 
   `token=[string]`

   **Optional:**
 
   `include=author`

   `limit=[integer]`

   `page=[integer]`

   `sort=[id|title]`

   `order_by=[asc|desc]`

* **Data Params**

  None

* **Success Response:**
  
  * **Code:** 200 OK <br />
    **Content:** <br />

    ``` json
    {
        "data": [
            {
                "id": 3,
                "title": "C-3PO: Tales of the Golden Droid"
            },
            {
                "id": 2,
                "title": "Book of Sith: Secrets from the Dark Side"
            },
            {
                "id": 1,
                "title": "The Jedi Path"
            },
        ],
        "metadata": {
            "pagination": {
                "total": 6,
                "per_page": 3,
                "current_page": 1,
                "last_page": 2,
                "next_page_url": "/?page=2",
                "prev_page_url": null,
                "from": 1,
                "to": 3
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
        "Unauthorized, you should provide a valid access token."
      ]
    }
    ```

* **Sample Call:**

  ``` bash
  $ curl -X GET http://localhost:8000/api/books?token=your_access_token
  ```
