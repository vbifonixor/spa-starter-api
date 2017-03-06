**Delete Author**
----
Delete a single author.

* **URL**

  /api/authors/:id

* **Method:**
    
  `DELETE`
  
*  **URL Params**

   **Required:**

   `id=[integer]`

   `token=[string]`

* **Data Params**

  None

* **Success Response:**
  
  * **Code:** 204 No Content <br />
 
* **Error Response:**

  * **Code:** 404 NOT FOUND <br />
    **Content:** <br />

    ``` json
    {
      "errors": {
        "Not Found"
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
  $ curl -X DELETE http://localhost:8000/api/authors/1?token=your_access_token
  ```
