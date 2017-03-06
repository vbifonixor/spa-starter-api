**Show All Authors**
----
Show all of the authors.

* **URL**

  /api/authors

* **Method:**
    
  `GET`
  
*  **URL Params**

   **Required:**
 
   `token=[string]`

   **Optional:**
 
   `include=books`

   `limit=[integer]`

   `page=[integer]`

   `sort=[id|name]`

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
          "name": "Anakin Skywalker"
        },
        {
          "id": 2,
          "name": "R2-D2"
        },
        {
          "id": 1,
          "name": "C-3PO"
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
  $ curl -X GET http://localhost:8000/api/authors?token=your_access_token
  ```
