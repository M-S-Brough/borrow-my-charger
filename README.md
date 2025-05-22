# 📡 Borrow My Charger

A full-stack web application for connecting electric vehicle (EV) users with private charge point owners. Built as part of a university module on *Client Server Systems* (Level 5).

## 🔧 Tech Stack
- PHP (Object-Oriented, MVC Pattern)
- MySQL (via PDO)
- HTML/CSS (Bootstrap)
- JavaScript (no jQuery)
- Leaflet.js (Mapping)
- AJAX (vanilla JS)

---

## 📚 Project Overview

This project was developed over two assignments:

### ✅ Assignment 1: Core System
- User registration and login (passwords hashed)
- Two user roles: Home Owner (hosts charge point) and Rental User
- Users can create and manage charge point listings
- Listings include address, postcode, price per kWh, and GPS coordinates
- Charge point search feature with filters (e.g., postcode, cost)
- Responsive design using Bootstrap
- Live system deployed on university server: `http://yourusername.poseidon.salford.ac.uk/clientserver/`

### ✅ Assignment 2: Advanced Features
- **Live Mapping**: Display of charge points using Leaflet.js, centered on user’s geolocation
- **AJAX Search**: As-you-type live search for charge points using vanilla JavaScript
- **JSON API**: Backend data exchange using JSON
- Modular JavaScript with OOP and reusable components
- Layered map view options (tile, satellite, terrain)
- Security features like input sanitization and session-based authentication

---

## 🚀 How to Run

### 🔧 Requirements
- PHP 7.x+
- MySQL
- Apache or compatible web server
- Internet access (for Leaflet CDN)
- Poseidon university server (for deployment)

### 🔑 Setup Instructions
1. Clone this repo:
   ```bash
   git clone https://github.com/M-S-Brough/borrow-my-charger.git
   ```
2. Import the provided `.sql` file into your MySQL database.
3. Update database credentials in `Database.php`.
4. Deploy to your server and access `index.php`.

---

## 🗺️ Features

- 🌍 Live map with geolocation and interactive charge point markers
- 🔎 AJAX-based smart search with real-time filtering
- 🧾 Dynamic forms and secure data handling
- 📦 Modular PHP classes and MVC structure
- 🎨 Custom styling with accessible layout

---


## 🧠 Why This Project?

This project was created as coursework for the *Client Server Systems* module (CRN 50249). The aim was to:
- Apply MVC principles using PHP
- Practice database interaction using PDO
- Build a real-world, data-driven web application
- Demonstrate modern frontend techniques with plain JavaScript

---

## 🏁 Future Improvements

- Calendar booking system
- Email notifications
- Admin dashboard
- Stripe integration for payments

---

## 👨‍🎓 Author

Mark Brough  
University of Salford 
