# Online Badminton Racket Store: A Web-Based Integrated System Course Assignment

## Getting Started

This project requires **XAMPP** (specifically the PHP and MariaDB components).  
If you haven’t installed it yet, [get XAMPP here](https://www.apachefriends.org/index.html) and set it up.

### 1. Start the Server

Once XAMPP is running:

1. Open your terminal.
2. Navigate to the root folder of this project.
3. Run the following command:

    ```
    php -S localhost:8000
    ```

    This will launch PHP’s built-in development server on `localhost`, port `8000`.

### 2. Set Up the Database

1. Open **phpMyAdmin** (accessible via XAMPP).
2. Import the SQL file located at:  
   `sql/web_based_assignment.sql`

⚠️ The project **won’t work** unless the database is imported.

## Login credentials

Both the admin and customer pages of the online store system **require login**. 
You could use the default credentials listed below, or create new accounts via 
the Sign Up page. However this is only applicable for customer accounts. To 
create new admin accounts, you'll have to manually insert new records into the `admin`
table in the database. The customer account records are stored in the `user` table.

### Main admin

- Admin ID: `A001`
- Password: `pass123`

### Staff admin
	
- Admin ID: `A002`
- Password: `itpass`

### Customers

- Username: 
	- `cookie`, or
	- `icecream`
- Password: `1234Abcd!`
	
## Addresses to main pages

(Assuming you're running the project on `localhost` on port `8000`.)

### Member/Customer pages

Sign up page(Member)
`http://localhost:8000/pages/user/user-signup.php`

Login page(Member)
`http://localhost:8000/pages/user/user-login.php?fromPage=/`

Home page(Member)
`http://localhost:8000/`

Profile Settings (Member)
`http://localhost:8000/pages/user/settings/profile.php`

Account Settings (Member)
`http://localhost:8000/pages/user/settings/account.php`

Product List page(Member)
`http://localhost:8000/pages/product/productlist.php`

Product details page(Member) (Need to add the parameter `?racket=XXX` or will redirect to Product List page)
`http://localhost:8000/pages/product/productDetail.php?racket=?`

User Cart page(Member)
`http://localhost:8000/pages/product/cartPage.php`

About Us page(Member)
`http://localhost:8000/pages/About/about.php`

Order page(Member)
`http://localhost:8000/pages/order/order.php`

Order details page(Member) (Need to add the parameter `?id=xxx` or will redirect to Order page)
`http://localhost:8000/pages/order/orderDetails.php?id=?`

Checkout page(Member)
`http://localhost:8000/pages/checkout/checkout.php?`

Order List page (Member)
`http://localhost:8000/pages/order/order.php`

Order Details (Member)
`http://localhost:8000/pages/order/orderDetails.php`

Cancel Order (Member)
`http://localhost:8000/pages/order/orderCancel.php`




Account Address (Member)
`http://localhost:8000/pages/user/settings/address.php`

Edit Address (Member) (Need to add the parameter `?edit=xxx` or will redirect to Account Address page)
`http://localhost:8000/pages/user/settings/editaddress.php?edit=11`


### Admin pages

Admin Login(Admin)
`http://localhost:8000/pages/admin/admin_login.php`

Admin Home(Admin)
`http://localhost:8000/pages/admin/admin_home.php`

Admin View Customer(Admin)
`http://localhost:8000/pages/admin/view_customer.php`

Admin View Customer Appeal(Admin)
`http://localhost:8000/pages/admin/view_customer_request.php`

Admin Management(Admin)
`http://localhost:8000/pages/admin/admin_Management.php`

Admin View Admin Appeal(Admin)
`http://localhost:8000/pages/admin/view_admin_request.php`

Add Admin(Admin)
`http://localhost:8000/pages/admin/adminAdd.php`

Customer Appeal(Admin)
`http://localhost:8000/pages/user/userRequestUnblock.php?userID=2`

Admin Appeal(Admin)
`http://localhost:8000/pages/admin/adminRequestUnblock.php?id=A002`

View Customer Detail(Admin)
`http://localhost:8000/pages/admin/customer_detail.php?userID=1`

Admin View All Orders(Admin)
`http://localhost:8000/pages/admin/admin_order.php`

Admin View Order Details(Admin) (Need to add the parameter `?id=xxx` or will redirect to Admin Home page)
`http://localhost:8000/pages/admin/admin_orderDetails.php?id=1`

Admin View Vouchers(Admin)
`http://localhost:8000/pages/admin/issueVoucher.php`

Admin View Chats(Admin)
`http://localhost:8000/pages/admin/admin_chat.php`
	
Admin Change Password(Admin)
`http://localhost:8000/pages/admin/admin_change_password.php`
	
Add product page(Admin)
`https://localhost:8000/pages/admin/product/addProduct.php`

Product report(Admin) 
`https://localhost:8000/pages/admin/product/adminProductAnlysis.php`

Product list page(Admin) 
`https://localhost:8000/pages/admin/product/admin_product.php`

Restock history page(Admin) 
`https://localhost:8000/pages/admin/product/restock_history.php`



	

	


	

	


	

	


	

	

