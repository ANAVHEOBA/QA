



{
  "name": "Abraham",
  "email": "wisdomvolt@gmail.com",
  "password": "Abrisco@real17"
}


{
  "message": "Registration successful",
  "token_type": "Bearer",
  "token": "1|ZZLAtsq95P8NjMnhfuXCNRsFOqrtcouPNCHNZ3phd7aa72b0"
}






### Public Routes (No Authentication Required)

1. **Login**
   - **Method:** `POST`
   - **Endpoint:** `/login`
   - **Description:** Allows users to log in.
   - **Body Parameters:**
     - `email`: string (required)
     - `password`: string (required)

2. **Register**
   - **Method:** `POST`
   - **Endpoint:** `/register`
   - **Description:** Allows users to register.
   - **Body Parameters:**
     - `name`: string (required)
     - `email`: string (required)
     - `password`: string (required)

---

### Protected Routes (Authentication via Sanctum Required)

3. **Logout**
   - **Method:** `POST`
   - **Endpoint:** `/logout`
   - **Description:** Logs the user out by invalidating their token.
   - **Headers:**
     - `Authorization: Bearer <token>`

4. **Profile**
   - **Method:** `GET`
   - **Endpoint:** `/profile`
   - **Description:** Fetches the authenticated user's profile information.
   - **Headers:**
     - `Authorization: Bearer <token>`

5. **Get Authenticated User Info**
   - **Method:** `GET`
   - **Endpoint:** `/user`
   - **Description:** Fetches the authenticated user's info.
   - **Headers:**
     - `Authorization: Bearer <token>`

---

### Product Resource Routes (Protected by Sanctum)

6. **List Products**
   - **Method:** `GET`
   - **Endpoint:** `/products`
   - **Description:** Fetches a list of all products.
   - **Headers:**
     - `Authorization: Bearer <token>`

7. **Create Product**
   - **Method:** `POST`
   - **Endpoint:** `/products`
   - **Description:** Creates a new product.
   - **Body Parameters:**
     - Depends on your `ProductController` validation.
   - **Headers:**
     - `Authorization: Bearer <token>`

8. **Get Product Details**
   - **Method:** `GET`
   - **Endpoint:** `/products/{id}`
   - **Description:** Fetches details of a specific product by its ID.
   - **Headers:**
     - `Authorization: Bearer <token>`

9. **Update Product**
   - **Method:** `PUT` or `PATCH`
   - **Endpoint:** `/products/{id}`
   - **Description:** Updates a specific product by its ID.
   - **Body Parameters:**
     - Depends on your `ProductController` validation.
   - **Headers:**
     - `Authorization: Bearer <token>`

10. **Delete Product**
    - **Method:** `DELETE`
    - **Endpoint:** `/products/{id}`
    - **Description:** Deletes a specific product by its ID.
    - **Headers:**
      - `Authorization: Bearer <token>`

---

