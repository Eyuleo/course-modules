**Functional Requirements** 

---

## **Core Functional Requirements**

### **1. User Accounts & Authentication**
- Student (Service Provider) registration/login/logout
- Client registration/login/logout
- Email verification/password reset
- Profile management (edit info, profile picture, bio, etc.)

### **2. Service Listings (Gigs)**
- Create new service listing (title, description, category, price, tags, delivery time, attachments/samples)
- Edit/delete service listing
- View all service listings
- Search/filter/sort service listings (by keyword, category, price, rating, etc.)
- Service detail page

### **3. Marketplace Browsing**
- Home page with featured/new/popular listings
- Service discovery (by category, trending tags)
- Service listing previews (basic card with price, student rating, etc.)
- Pagination/infinite scroll for listings

### **4. Order & Booking Management**
- Place an order/request service (select package, input requirements)
- Order tracking/status updates (pending, in progress, delivered, completed, disputed)
- Order management dashboard for clients and students
- File delivery and messaging within orders

### **5. Messaging & Communication**
- Messaging between client and student (pre-order and post-order)
- Notifications (email & in-app) for order updates, messages, system events

### **6. Payment & Transaction Management**
- Integration with payment gateway (Stripe)
- Student wallet/balance management
- Commission deduction for platform

### **7. Ratings & Reviews**
- Clients can rate and review students and their services
- Display average rating and review snippets on service and student profile pages

### **8. Admin Dashboard**
- User management (view, ban/suspend users)
- Service and order moderation (approve, reject, report)
- Commission and revenue tracking
- Site analytics/dashboard (number of users, revenue, popular categories, etc.)

### **9. Notifications**
- Email and/or in-app notifications for:
  - New order/booking
  - New message
  - Order status change
  - Review received


---

## **Summary Table Example**
| Functional Area | Requirement Example                               |
|-----------------|--------------------------------------------------|
| Accounts        | Student/Client Registration                      |
| Listings        | Create/Edit/Delete/View Listings                  |
| Orders          | Place Order, Track Status, Deliverables           |
| Payment         | Payment Gateway, Escrow, Commission               |
| Reviews         | Submit/view ratings & reviews                     |
| Messaging       | Chat between users, notifications                 |
| Admin           | Moderate users, services, disputes, analytics     |



## **Student Skill Marketplace Functional Requirements by User Role**

---

### **1. Student (Service Provider) Features**
- Register/login/logout  
- Create and manage profile (bio, photo, skills, education, etc.)
- Create, edit, and delete service listings (title, description, price, category, delivery time, samples, etc.)
- View all own listings, manage which are active/inactive
- Receive and manage orders:
  - Accept/decline orders (if applicable)
  - View order details and requirements
  - Upload and deliver work/files
  - Mark orders as "delivered"
- View order history and statuses (pending, in progress, delivered, completed, cancelled)
- Communicate with clients via messaging (within orders and/or through platform chat)
- Receive notifications for new orders, messages, reviews, status changes
- Track earnings/balance (wallet)
- Withdraw funds (if allowed)
- View and respond to ratings & reviews

---

### **2. Client (Service Buyer) Features**
- Register/login/logout  
- Create and manage profile (name, photo, contact details, etc.)
- Browse/search/filter service listings (keyword, price, category, rating, etc.)
- View service details pages
- Contact/message students before placing an order (optional)
- Place orders, provide requirements for service
- View and manage orders placed (track status, download deliveries, request revisions)
- Leave ratings and reviews on completed orders
- Communicate with students through platform messaging/chat
- Receive notifications for order updates, messages, reviews
- View order and payment history

---

### **3. Admin Features**
- Admin dashboard (summary stats, graphs, site metrics)
- Manage users (view, edit, ban/suspend, reset passwords)
- Moderate service listings (approve/reject, remove, edit, handle reports)
- Moderate orders and disputes (resolve issues, refund/compensate if needed)
- Manage site-wide configurations (commission rate, fees, payment integration)
- View and manage platform earnings and payouts
- Review platform-wide transactions and activity logs
- Send platform-wide announcements or notifications

---

### **4. Common / Platform-wide Features**
- Secure authentication (passwords, sessions, email verification, password reset)
- Dashboard for each user to manage their activities (orders, messages, finances)
- In-app and/or email notifications (order placed, message received, order status update, etc.)
- Responsive, mobile-friendly user interface
- Help/FAQ and contact support options
- Reporting/flagging abuse system



---

