**Show Me**
----
Fetch the currently authenticated user.

* **URL**

  /api/me

* **Method:**
    
  `GET`
  
*  **URL Params**

   **Required:**
 
   `token=[string]`

* **Data Params**

  None

* **Success Response:**
  
  * **Code:** 200 OK <br />
    **Content:** <br />

    ``` json
    {
      "data": {
        "id": 1,
        "name": "Anakin Skywalker",
        "email": "anakin@death.star"
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
  $ curl -X GET http://localhost:8000/api/me?token=your_access_token
  ```
